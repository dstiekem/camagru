<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
require (dirname(__FILE__) . '/config/database.php');
if(isset($_POST["imagelikeid"]) && isset($_POST["userlikeid"]) && isset($_POST["unlike"]))
{
    $imagelikeid = $_POST["imagelikeid"];
    $userlikeid = $_POST["userlikeid"];
    try{
        $inslike = $pdo->prepare("INSERT INTO likes (imageid, `user_id`) VALUES (:imageid, :userid)");
        $inslike->bindParam("imageid", $imagelikeid);
        $inslike->bindParam("userid", $userlikeid);
        $inslike->execute();
    }
    catch (PDOexception $e){
        //throw $th;
            echo $e->getMessage();
    }
}
else if(isset($_POST["imagelikeid"]) && isset($_POST["userlikeid"]) && isset($_POST["unlike"]))
{
    try{
        $inslike = $pdo->prepare("DELETE FROM likes WHERE imageid = :imageid and `user_id` = :userid)");
        $inslike->bindParam("imageid", $imagelikeid);
        $inslike->bindParam("userid", $userlikeid);
        $inslike->execute();
    }
    catch (PDOexception $e){
        //throw $th;
            echo $e->getMessage();
    }
}
?>