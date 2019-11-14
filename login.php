<?php

require (dirname(__FILE__) . '/functions/pswdveri.php');
require (dirname(__FILE__) . '/functions/userexists.php');
require (dirname(__FILE__) . '/config/database.php');
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
            header('Location: ../mvc2/loggedin.php');
        }
        else if(!password_verify($password, $fetched['passwd']) || $fetched['emailver'] == 0)
        {
            echo "incorrect password. If you have signed up already check your email. If you have not signed up, sign up!";
        }
        
            /*$fecthed = $checkuser->fetchAll();
            $checkpasswd = $fetched[5];
            var_dump($checkpassword);*/
            
    }
    catch (PDOexception $e)
    {
        //throw $th;
        echo $e->getMessage();
    }
}
else
{
    echo "please enter username and password";
}
?>

<form action="login.php" method="post" >
username: <input type="text" name="username" autocomplete="on"/>
password: <input type="password" name="password" />
<input type="submit" name="submit" value="LOG IN" />
<a href="http://localhost:8080/mvc2/loggedout.php">continue browsing without logging in?</a><br>
<a href="http://localhost:8080/mvc2/forgotpassword.php">forgot password?</a><br>
<a href="http://localhost:8080/mvc2/index.php">SIGN UP</a>

</form>

<div class="form-popup" id="myForm">
  <form action="/action_page.php" class="form-container">
    <h1>Login</h1>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn">Login</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>