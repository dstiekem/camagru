
 
<!-- if(isset($_SESSION['uid']))
{ 
    set_include_path("..");
    include ('config/database.php');
    $uid = $_SESSION['uid'];
    if(isset($_POST['iset']))
    {
        echo "and theeeen";

        if($notif === "false")
        {
            $noti = 0;
        }
        else if($notif === "true")
        {
            $noti = 1;
        }
        try{
            $update = $pdo->prepare("UPDATE users SET notif = :noti WHERE userid = :useid");
            $update->bindParam(':useid', $uid);
            $update->bindParam(':noti', $noti);
            $update->execute();
        }
        catch (PDOexception $e) {
            //throw $th;
            echo $e->getMessage();
        }
    }
    else
    {
        echo "NAH POO";
    }
} 

 else
{
    header('Location: ' . str_replace("setnotif.php", ".php", $_SERVER['REQUEST_URI']));
}  -->
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
