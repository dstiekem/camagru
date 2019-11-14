<?php
require (dirname(__FILE__) . '/functions/pswdval.php');
require (dirname(__FILE__) . '/functions/pswdsub.php');
require (dirname(__FILE__) . '/config/database.php');
echo "change password";
$username = $_GET['username'];
if(isset($_POST['password1']) && isset($_POST['password2']))
{
    $password1 = pswdsub($_POST['password1']);
    $password2 = pswdsub($_POST['password2']);
    if(!strncmp($password1, $password2, strlen($password1)))
    {
        $updatepass = $pdo->prepare("UPDATE users set passwd WHERE username = :username");
    }
    else
        echo "makesure both passwords are the same!";
}
else
    echo "please enter your new passowrd in both feilds";
?>
<form action="changepassword.php" method="post" >
new password: <input type="password" name="password1" />
confirm password: <input type="password" name="password2" />
<input type="submit" name="submit" value="" />
<a href="http://localhost:8080/mvc2/loggedout.php">continue browsing without logging in?</a>
</form>