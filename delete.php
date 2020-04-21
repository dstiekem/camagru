<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
require (dirname(__FILE__) . '/config/database.php');

if(isset($imageid['thumbv']))
{
    $todel = $imageid['thumbv'];
    try{
        $delim = $pdo->prepare("DELETE FROM `images` WHERE `imageid` = :imageid");
        /* UPDATE users SET notif = $boool WHERE userid = :userid */
        $delim->bindParam("imageid", $todel);
        $delim->execute();
        echo $todel . "is gone";
    }
    catch (PDOexception $e){
        //throw $th;
        echo $e->getMessage();
        echo "it dunnaework";
    }
}
?>
