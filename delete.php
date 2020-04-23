<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
require (dirname(__FILE__) . '/config/database.php');

if(isset($_POST['imageid']) && isset($_POST['usus']) && isset($_POST['usim']) && isset($_POST['usus']) === isset($_POST['usim']))
{
    $todel = $_POST['imageid'];

    try{
        $delim = $pdo->prepare("DELETE FROM `images` WHERE `imageid` = :imageid");
        $delim->bindParam("imageid", $todel);
        $delim->execute();
        echo $todel . "is gone";
    }
    catch (PDOexception $e){
        echo $e->getMessage();
        echo "it dunnaework";
    }
}
else
{
    echo "it dunnaeworkFOK";
}
?>
