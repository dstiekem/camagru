<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
require (dirname(__FILE__) . '/config/database.php');
require (dirname(__FILE__) . '/functions/email.php');
if(isset($_POST['commenttext']) && isset($_POST['imageid']) && isset($_POST['notifuser']) && isset($_POST['notif']))
{
    $comment = htmlspecialchars($_POST['commenttext'], ENT_QUOTES);
    $user = $_SESSION['uid'];
    $imageid = $_POST['imageid'];
    $notifuser = $_POST['notifuser'];
    $notif = $_POST['notif'];
    try{
        $inscomment = $pdo->prepare("INSERT INTO comments (`imageid`, `user_id`, commenttext) VALUES
        (:imageid, :userid, :commentt)");
        $inscomment->bindParam("imageid", $imageid);
        $inscomment->bindParam("userid", $user);
        $inscomment->bindParam("commentt", $comment);
        $inscomment->execute();
        /* header('Location: comment.php'); */
        if($notif === "1")
        {
            $cbody = "Hi user, someone has commented on one of your posts. YAY!";
            if(sendemailnotif($notifuser, "User", $cbody))
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
        //throw $th;
            echo $e->getMessage();
    }
}
?>