<?php
require (dirname(__FILE__) . '/config/database.php');
require (dirname(__FILE__) . '/functions/email.php');
echo "what's your username and email?";
if(isset($_POST['email']) && isset($_POST['username']))
{
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $body = "hi $username, click link to continue to password. <br>" . "http://localhost:8080/mvc2/changepassword.php?username=". $username;
    try
    {
        $checkemail = $pdo->prepare("SELECT username FROM users WHERE email = :email");
        $checkemail->bindParam(':email', $email);
        $checkemail->execute();
        $fetched = $checkemail->fetch();

        if(strncmp($fetched['username'], $username, strlen($username)) == 0)
        {
            if(sendemail($email, $username, $body))
            {
                echo "Thank you email has been sent to " . htmlentities($email, ENT_QUOTES) . "\n" . "Click to reset password.";
            }
            else
            {
                echo "something went wrong! please try again";
            }
        }
        else
        {
            echo "username and email dont match!";
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
<form action="forgotpassword.php" method="post" >
username: <input type="text" name="username" autocomplete="on"/>
email: <input type="email" name="email" autocomplete="on" />
<input type="submit" name="submit" value="RESET PASSWORD" />
<a href="http://localhost:8080/mvc2/loggedout.php">continue browsing without logging in?</a>
</form>