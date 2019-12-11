<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
require (dirname(__FILE__) . '/config/database.php');
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
/* header('Location: ../mvc2/comment.php'); */
?>