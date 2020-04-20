<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
require (dirname(__FILE__) . '/functions/randomstr.php');
require (dirname(__FILE__) . '/config/database.php');
try{
    $userid = $_SESSION['uid'];
    $insertim = $pdo->prepare("INSERT INTO images (imagepath, `user_id`) VALUES(:impath, :userid)");
    $insertim->bindParam(':impath', $savedimpath);
    $insertim->bindParam(':userid', $userid);
    $insertim->execute();
}
catch (PDOexception $e){
//throw $th;
    echo $e->getMessage();
}
try{
    $dellike = $pdo->prepare("DELETE FROM `images` WHERE `likes`.`imageid` = :imageid AND `likes`.`user_id` = :userid");
    /* UPDATE users SET notif = $boool WHERE userid = :userid */
    $dellike->bindParam("imageid", $imagelikeid);
    $dellike->bindParam("userid", $userlikeid);
    $dellike->execute();
}
catch (PDOexception $e){
    //throw $th;
        echo $e->getMessage();
        echo "it dunnaework";
}
?>
