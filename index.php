<?php
session_start();
require (dirname(__FILE__) . '/config/database.php');
require (dirname(__FILE__) . '/functions/pswdval.php');
require (dirname(__FILE__) . '/functions/email.php');
require (dirname(__FILE__) . '/functions/pswdsub.php');

echo '<form action="index.php" method="post">
username: <input type="text" name="username" autocomplete="on" />
password: <input type="password" name="password" />
email: <input type="email" name="email" autocomplete="on" />
<input type="submit" name="submit" value="SIGN UP" />
<a href="http://localhost:8080/mvc2/loggedout.php">continue browsing without signing in?</a>
<a href="http://localhost:8080/mvc2/login.php">LOGIN</a><br>
</form>';

if(isset($_POST['password']) && isset($_POST['email']) && isset($_POST['username']))
{
    try{
    $passwd = $_POST['password'];
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $emailverif = 0;
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
                    echo "Thank you email has been sent to " . htmlentities($email, ENT_QUOTES) . "\n" . "Click the link to confirm address.";
                    
                        $passwdsub = pswdsub($passwd); 
                        $insertrow = $pdo->prepare("INSERT INTO users (userid, username, email, emailver, vkey, passwd) VALUES(:userid, :username, :email, :emailverif, :vkey, :passwd)");
                        $insertrow->bindParam(':userid', $userid);
                        $insertrow->bindParam(':username', $username);
                        $insertrow->bindParam(':email', $email);
                        $insertrow->bindParam(':emailverif', $emailverif);
                        $insertrow->bindParam(':vkey', $vkey);
                        $insertrow->bindParam(':passwd', $passwdsub);
                        $insertrow->execute();
                }
                else
                {
                    echo "opps";
                }
            }
            else
            {
                echo "invalid password. Is you Password at least 8 characters in length with at least one upper case letter, one number, and one special character?";
            }
        }
        else
        {
            $us = $fetcheduser['username'];
            $em = $fetchedemail['email'];
            echo "Sorry! that user or email already has an account!";
        }
    }
    catch (PDOexception $e) {
        //throw $th;
        echo $e->getMessage();
    }
}
else
{
    echo "please enter a username, password and valid email address";
}

?>


