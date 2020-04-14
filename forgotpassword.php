<html>
    <header>
        <link rel="stylesheet" type="text/css" href="stylesheet2.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,700,800&display=swap" rel="stylesheet">
    </header>
    <body>
        <?php
        require (dirname(__FILE__) . '/config/database.php');
        require (dirname(__FILE__) . '/functions/email.php');
        require (dirname(__FILE__) . '/functions/modal.php');
        if(isset($_POST['email']) && isset($_POST['username']))
        {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
            $body = "hi $username, click link to continue to password. <br>" . "http://localhost:8080/mvc2/forgotchangepassword.php?username=". $username;
            try
            {
                $checkemail = $pdo->prepare("SELECT username FROM users WHERE email = :email");
                $checkemail->bindParam(':email', $email);
                $checkemail->execute();
                $fetched = $checkemail->fetch();

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
        //send email to change passowrd
        //generate new key
        //
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
                <a href="http://localhost:8080/mvc2/loggedout.php">continue browsing without logging in?</a>
            </form>
        </div>
    </body>
</html>