<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet2.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,700i,800&display=swap" rel="stylesheet">
</head>
<?php
session_start();
    $page = "changepassword";
    require (dirname(__FILE__) . '/functions/pswdval.php');
    require (dirname(__FILE__) . '/functions/pswdsub.php');
    require (dirname(__FILE__) . '/functions/modal.php');
    require (dirname(__FILE__) . '/config/database.php');
if(isset($_SESSION['uid']))
{
        if(isset($_POST['password1']) && isset($_POST['password2']))
        {
            $password1 = pswdsub($_POST['password1']);
            $password2 = pswdsub($_POST['password2']);
            if(!strncmp($password1, $password2, strlen($password1)))
            {
                $updatepass = $pdo->prepare("UPDATE users set passwd WHERE username = :username");
            }
            else
            {
                $string1 = "error";
                $string2 = "makesure both passwords are the same!";
                modal($string1, $string2);
            }
        }
        $page = "changepassword";
        require (dirname(__FILE__) . '/header.php');
    ?>
        <div style="width: 100%; height: auto; margin: 0; overflow: auto;">
            <ul class="box" class="settings" style="float: left; width: 100%;">
                <li><a href=http://localhost:8080/mvc2/changeusern.php>CHANGE USERNAME</a></li>
                <li><a href=http://localhost:8080/mvc2/changeemail.php>CHANGE EMAIL</a></li>
                <li><a class="active" href=http://localhost:8080/mvc2/changepassword.php>CHANGE PASSWORD</a></li>
                <li><a href=http://localhost:8080/mvc2/enablenotif.php>ENABLE NOTIFICATIONS</a></li>
            </ul>
            <div class="box" style="width: 100%; float: left; height: initial;">
                <p class="title">please enter your new password in both feilds</p>
                <div action="changepassword.php" method="post">
                    <input type="password" name="password1" placeholder="new password"/>
                    <input type="password" name="password2" placeholder="confirm password"/>
                    <input type="submit" name="submit" value="CHANGE PASSWORD" />
                </div>
            </div>
        </div>
    </body>
    <?php
}
else
{
    header('Location: ../mvc2/login.php');
}
?>
</html>
