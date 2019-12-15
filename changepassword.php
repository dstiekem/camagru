<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet2.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,700i,800&display=swap" rel="stylesheet">
</head>
<?php

session_start();
    $page = "changepassword";
    require (dirname(__FILE__) . '/header.php');
    require (dirname(__FILE__) . '/functions/pswdval.php');
    require (dirname(__FILE__) . '/functions/pswdsub.php');
    require (dirname(__FILE__) . '/functions/modal.php');
    require (dirname(__FILE__) . '/config/database.php');
if(isset($_SESSION['uid']))
{
    $uid = $_SESSION['uid'];
        if(isset($_POST['password1']) && isset($_POST['password2']))
        {
            $password1 = pswdsub($_POST['password1']);
            $password2 = pswdsub($_POST['password2']);
            if($_POST['password1'] == $_POST['password2'])
            {
                if(pswdval($password1) && pswdval($password2))
                {
                    try{
                        $updatepass = $pdo->prepare("UPDATE users set passwd = :passwd WHERE userid = :useid");
                        $updatepass->bindParam("useid", $uid);
                        $updatepass->bindParam("passwd", $password2);
                        $updatepass->execute();
                        $string1 = "success";
                        $string2 = "loggout to see changes";
                        modal($string1, $string2);
                    }
                    catch (PDOexception $e) {
                        //throw $th;
                        echo $e->getMessage();
                    }
                }
                else
                {
                    $string1 = "error";
                    $string2 = "That password isnt strong enough";
                    modal($string1, $string2);
                }
            }
            else
            {
                $string1 = "error";
                $string2 = "make sure both passwords are the same!";
                modal($string1, $string2);
            }
        }
    ?>
        <div class="gridsettings">
            <ul class="boxsettings" class="settings" style="float: left; width: 100%; box-shadow: none;">
                <li><a href=http://localhost:8080/mvc2/changeusern.php>CHANGE USERNAME</a></li>
                <li><a href=http://localhost:8080/mvc2/changeemail.php>CHANGE EMAIL</a></li>
                <li id="selected"><a href=http://localhost:8080/mvc2/changepassword.php>CHANGE PASSWORD</a></li>
                <li><a href=http://localhost:8080/mvc2/enablenotif.php>ENABLE NOTIFICATIONS</a></li>
            </ul>
            <div style="width:100%; padding: 1%; background-color: #17141d;">
                <div class="box" class="settings" style="background-color: #17141d; width: 50%; height: 30%; box-shadow: none; text-align: centre;">
                    <p class="title" style="padding: 10px; margin: 10px;">Please enter your new password in both feilds</p> 
                    <form action="changepassword.php" method="post">
                        <input type="password" name="password1" placeholder="new password"/>
                        <input type="password" name="password2" placeholder="confirm password"/>
                        <input type="submit" name="submit" value="CHANGE PASSWORD" />
                    </form>
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
