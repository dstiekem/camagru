
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="stylesheet2.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,700,800&display=swap" rel="stylesheet">
    </head>
    <body>
        <!-- <div class="box" class="nav">
            <button>
        </div> -->
        <?php
            $page = "index";
            require (dirname(__FILE__) . '/header.php');
            ?>
        <div class="box">
            <p class="title" id="signup">Please enter a username, password, and valid email address</p>
            <form action="index.php" method="post">
                <input type="text" name="username" placeholder="Username" autocomplete="on" />
                <input type="password" name="password" placeholder="Password"/>
                <input type="email" name="email" autocomplete="on" placeholder="Email"/>
                <input type="submit" name="submit" value="SIGN UP" />
                <a href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace( $page.".php", "login.php", $_SERVER['REQUEST_URI']);?>'>LOGIN</a><br>
                <a href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace( $page.".php", "home.php", $_SERVER['REQUEST_URI']);?>'>continue browsing without signing in?</a>
            </form>
        </div>
        <?php
        session_start();
        require (dirname(__FILE__) . '/config/database.php');
        require (dirname(__FILE__) . '/functions/pswdval.php');
        require (dirname(__FILE__) . '/functions/email.php');
        require (dirname(__FILE__) . '/functions/pswdsub.php');
        require (dirname(__FILE__) . '/functions/modal.php');

        if(isset($_POST['password']) && isset($_POST['email']) && isset($_POST['username']))
        {
            try{
            $passwd = $_POST['password'];
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
            $emailverif = 0;
            $notif = 1;
            $vkey = md5(time().$username);
            $body = "Hi " . $username . "," . " please click on the link to confirm your email address. <br>" . "http://localhost:8080/mvc2/functions/confirmuser.php?key=".$vkey."";
        
            //check if user already exists. check if email exists.
            //$checkuser = $pdo->prepare("");
            //echo "sorry! username or email already exists!"
            $checkemail = $pdo->prepare("SELECT email FROM users WHERE email = :email");
            $checkemail->bindParam(':email', $email);
            $checkemail->execute();
            $fetchedemail = $checkemail->fetch();
            $checkuser = $pdo->prepare("SELECT username FROM users WHERE username = :username");
            $checkuser->bindParam(':username', $username);
            $checkuser->execute();
            $fetcheduser = $checkuser->fetch();
                
                if(!$fetcheduser['username'] && !$fetchedemail['email'])
                {
                    
                    if(pswdval($passwd))
                    {
                        if(sendemail($email, $username, $body))
                        {

                            $string1 = "success";
                            $string2 = "Thank you email has been sent to " . htmlentities($email, ENT_QUOTES) . ". Click the link to confirm address.";
                            modal($string1, $string2);
                            $passwdsub = pswdsub($passwd); 
                            $insertrow = $pdo->prepare("INSERT INTO users (userid, username, email, emailver, notif, vkey, passwd) VALUES(:userid, :username, :email, :emailverif, :notif, :vkey, :passwd)");
                            $insertrow->bindParam(':userid', $userid);
                            $insertrow->bindParam(':username', $username);
                            $insertrow->bindParam(':email', $email);
                            $insertrow->bindParam(':emailverif', $emailverif);
                            $insertrow->bindParam(':vkey', $vkey);
                            $insertrow->bindParam(':passwd', $passwdsub);
                            $insertrow->bindParam(':notif', $notif);
                            $insertrow->execute();
                        }
                        else
                        {
                            modal("error", "oops");
                        }
                    }
                    else
                    {
                        $string1 = "error";
                        $string2 = "invalid password. Is you Password at least 8 characters in length with at least one upper case letter, one number, and one special character?";
                        modal($string1, $string2);
                    }
                }
                else
                {
                    $us = $fetcheduser['username'];
                    $em = $fetchedemail['email'];
                    $string1 = "error";
                    $string2 = "Sorry! that user or email already has an account!";
                    modal($string1, $string2);
                }
            }
            catch (PDOexception $e) {
                //throw $th;
                echo $e->getMessage();
            }
        }
        /* else
        {
            echo "
            <script type=\"text/javascript\">
            document.getElementById(\"title\").style.visibility = \"visible\";
            </script>
            ";
        } */

        ?>
    </body>
</html>

