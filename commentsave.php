<?php
session_start();
if(!isset($_SESSION['uid']))
{
    header('Location: ' . str_replace("commentsave.php", "comment.php", $_SERVER['REQUEST_URI']));
}
if(isset($_SESSION['uid']))
{
    require (dirname(__FILE__) . '/config/database.php');
    if(!isset($_POST['comment']) && !isset($_POST['imageid']))
    {
        header('Location: ' . str_replace("commentsave.php", "home.php", $_SERVER['REQUEST_URI']));
    }
    $comment = $_POST['comment'];
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