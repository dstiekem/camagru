<html>
    <header>
        <link rel="stylesheet" type="text/css" href="stylesheet2.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,700,800&display=swap" rel="stylesheet">
    </header>
    <body>
        <?php
        session_start();
        if(isset($post['string1']) && isset($post['string2']))
        {
            $string1 = "error";
            $string2 = "something went wrong, make sure your email and username are from the same account";
            modal($string1, $string2);
        }
        require (dirname(__FILE__) . '/config/database.php');
        require (dirname(__FILE__) . '/functions/email.php');
        require (dirname(__FILE__) . '/functions/modal.php');
        
        if(isset($_POST['email']) && isset($_POST['username']))
        {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
            
            try
            {
                $checkemail = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $checkemail->bindParam(':email', $email);
                $checkemail->execute();
                $fetched = $checkemail->fetch();

                $string = password_hash($fetched['email'] . $fetched['userid'], PASSWORD_DEFAULT);
                $body = "hi $username, click link to continue to password. <br>" . "http://" . $_SERVER['HTTP_HOST'] . str_replace("forgotpassword.php", "forgotchangepassword.php", $_SERVER['REQUEST_URI']) . "?athing=" . $string . "&uid=" . $fetched['userid'] . "";
                if(strncmp($fetched['username'], $username, strlen($username)) == 0)
                {
                    if(sendemailfor($email, $username, $body))
                    {
                        $string1 = "success";
                        $string2 = "Thank you email has been sent to " . htmlentities($email, ENT_QUOTES) . ". Click the link to confirm address.";
                        modal($string1, $string2);
                    }
                    else
                    {
                        $string1 = "error";
                        $string2 = "something went wrong! please try again";
                        modal($string1, $string2);
                    }
                }
                else
                {
                    $string1 = "error";
                    $string2 = "username and email dont match the same account!";
                    modal($string1, $string2);
                }
            }
            catch (PDOexception $e) {
                //throw $th;
                echo $e->getMessage();
            }
        }
        ?>
        <?php
            $page = "forgotpassword";
            require (dirname(__FILE__) . '/header.php');
        ?>
        <div class="box">
            <p class="title">What's your username and email?</p>
            <form action="forgotpassword.php" method="post" >
                <input type="text" name="username" autocomplete="on"placeholder="username"/>
                <input type="email" name="email" autocomplete="on" placeholder="email"/>
                <input type="submit" name="submit" value="RESET PASSWORD" />
                <a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("forgotpassword.php", "loggedout.php", $_SERVER['REQUEST_URI'])?>>continue browsing without logging in?</a>
            </form>
        </div>
    </body>
</html>