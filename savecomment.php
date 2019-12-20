<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
require (dirname(__FILE__) . '/config/database.php');
if(isset($_POST['commenttext']) && isset($_POST['imageid']))
{
    $comment = htmlspecialchars($_POST['commenttext'], ENT_QUOTES);
    $user = $_SESSION['uid'];
    $imageid = $_POST['imageid'];
    try{
        $inscomment = $pdo->prepare("INSERT INTO comments (`imageid`, `user_id`, commenttext) VALUES
        (:imageid, :userid, :commentt)");
        $inscomment->bindParam("imageid", $imageid);
        $inscomment->bindParam("userid", $user);
        $inscomment->bindParam("commentt", $comment);
        $inscomment->execute();
    }
    catch (PDOexception $e){
        //throw $th;
            echo $e->getMessage();
    }
}
?>