<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet2.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,700i,800&display=swap" rel="stylesheet">
</head>
<?php
session_start();
$page = "forgotchangepassword";
require (dirname(__FILE__) . '/header.php');
require (dirname(__FILE__) . '/functions/pswdval.php');
require (dirname(__FILE__) . '/functions/pswdsub.php');
require (dirname(__FILE__) . '/functions/modal.php');
require (dirname(__FILE__) . '/config/database.php');
if(isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['uid']))
{
    $password1 = pswdsub($_POST['password1']);
    $password2 = pswdsub($_POST['password2']);
    $uid = $_POST['uid'];
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
                $string2 = "password changed";
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
<body>
<?php
if(isset($_GET["athing"]) && isset($_GET["uid"]))
{
    $key = $_GET["athing"];
    $uid = $_GET["uid"];
    try
    {
        $check = $pdo->prepare("SELECT * FROM users WHERE userid = :usid");
        $check->bindParam("usid", $uid);
        $check->execute();
        $checkfetch = $check->fetch();
        
    }
    catch (PDOexception $e) {
        //throw $th;
        echo $e->getMessage();
    }
    if(password_verify($checkfetch['email'] . $checkfetch['userid'], $key))
    {
        ?>
        <div class="box" class="settings" style="background-color: #17141d; width: 50%; height: 40%; box-shadow: none; text-align: centre;">
            <p class="title" style="padding: 10px; margin: 10px;">Please enter your new password in both feilds</p> 
            <form action="forgotchangepassword.php" method="post">
                <input type="password" name="password1" placeholder="new password"/>
                <input type="password" name="password2" placeholder="confirm password"/>
                <input type="hidden" name="uid" value="<?php echo $uid ?>"/>
                <input type="submit" name="submit" value="CHANGE PASSWORD" />
            </form>
        </div>
        <?php
    }
}
else
{
    header('Location: ' . str_replace("forgotchangepassword.php", "forgotpassword.php", $_SERVER['REQUEST_URI']));
}
?>
</body>
</html>

