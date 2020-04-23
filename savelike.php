<?php
session_start();
if(!isset($_SESSION['uid']))
{
    header('Location: ' . str_replace("savelike.php", "loggedout.php", $_SERVER['REQUEST_URI']));
}
$thisuser = $_SESSION['uid'];
echo $thisuser;
echo $_POST["`user_id`"];
echo $_POST["`imageid`"];
echo $_POST["check"];
echo $_POST["notif"];
require (dirname(__FILE__) . '/config/database.php');
require (dirname(__FILE__) . '/functions/email.php');
if(isset($_POST["`imageid`"]) && isset($_POST["`user_id`"]) && isset($_POST["`user_id`"]) == $thisuser && isset($_POST['notifluser']))
{
    $imagelikeid = $_POST["`imageid`"];
    $userlikeid = $_POST["`user_id`"];
    $check = $_POST["check"];
    $notifuser = $_POST['notifluser'];
    $notiff = $_POST["notif"];
    if($check === "true" && isset($_POST['notif']))
    {
        $notif = $_POST["notif"];
        try{
            $inslike = $pdo->prepare("INSERT INTO likes (`imageid`, `user_id`) VALUES (:imageid, :userid)");
            $inslike->bindParam("imageid", $imagelikeid);
            $inslike->bindParam("userid", $userlikeid);
            $inslike->execute();

            if($notif === "1")
            {
                $lbody = "Hi user, someone has liked one of your posts. YAY!";
                if(sendemailnotif($notifuser, "user", $lbody))
                {
                    echo "notification sent";
                }
                else
                {
                    echo "PORQUE";
                }
            }

        }
        catch (PDOexception $e){
                echo $e->getMessage();
        }
    }
    else if($check === "false")
    {
        try{
            $dellike = $pdo->prepare("DELETE FROM `likes` WHERE `likes`.`imageid` = :imageid AND `likes`.`user_id` = :userid");
            $dellike->bindParam("imageid", $imagelikeid);
            $dellike->bindParam("userid", $userlikeid);
            $dellike->execute();
        }
        catch (PDOexception $e){
            echo $e->getMessage();
            echo "it dunnaework";
        }
    }
}
else
{
    echo "why??";
}
?>