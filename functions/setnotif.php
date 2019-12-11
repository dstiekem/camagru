<?php
if(!isset($_SESSION['uid']))
{
    session_start();
    set_include_path("..");
    include ('config/database.php');
    function setnotif($boool, $uid){

        global $pdo;
        try{
            $update = $pdo->prepare("UPDATE users SET notif = $boool WHERE userid = :userid");
            $update->bindParam(':userid', $uid);
            $update = $update->execute();
        }
        catch (PDOexception $e) {
            //throw $th;
            echo $e->getMessage();
        }
        return ;
    }
    setnotif($_POST['notif'], $_SESSION['uid']);
}
?>