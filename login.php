<html>
    <head>
    <link rel="stylesheet" type="text/css" href="stylesheet2.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,700,800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <?php
    $page = "login";
    require (dirname(__FILE__) . '/header.php');
    
        require (dirname(__FILE__) . '/functions/userexists.php');
        require (dirname(__FILE__) . '/config/database.php');
        require (dirname(__FILE__) . '/functions/modal.php');


        if(isset($_POST['password']) && isset($_POST['username']))
        {
            $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
            $password = $_POST['password'];
            try
            {
                $checkpass = $pdo->prepare("SELECT * FROM users WHERE username = :username");
                $checkpass->bindParam(':username', $username);
                $checkpass->execute();
                $fetched = $checkpass->fetch();
                if(password_verify($password, $fetched['passwd']) && $fetched['username'] && $fetched['emailver'] == 1)
                {
                    session_start();
                    $_SESSION['uid'] = $fetched['userid'];
                    header('Location: ' . str_replace("login.php", "home.php", $_SERVER['REQUEST_URI']));
                }
                else if(!password_verify($password, $fetched['passwd']) || $fetched['emailver'] == 0)
                {
                    $string1 = "error";
                    $string2 = "incorrect password. If you have signed up already check your email. If you have not signed up, sign up!";
                    modal($string1, $string2);
                }       
            }
            catch (PDOexception $e)
            {
                echo $e->getMessage();
            }
        }
        ?>
        <div class="box">
            <p class="title" id="login">please enter your username and password</p>
            <form action="login.php" method="post" >
                <input type="text" name="username" placeholder="username" autocomplete="on"/>
                <input type="password" name="password" placeholder="password"/>
                <input type="submit" name="submit" value="LOG IN" />
                <a href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace( $page.".php", "index.php", $_SERVER['REQUEST_URI']);?>'>SIGN UP</a><br>
                <a href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace( $page.".php", "home.php", $_SERVER['REQUEST_URI']);?>'>continue browsing without logging in?</a><br>
                <a href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace( $page.".php", "forgotpassword.php", $_SERVER['REQUEST_URI']);?>'>forgot password?</a><br>
            </form>
        </div>
    </body>
</html>


