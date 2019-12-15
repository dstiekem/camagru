<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
require ('config/database.php');
function fetchuid($oldusern, $uid)
{
    global $pdo;
    try{
        $fectheduid = $pdo->prepare("SELECT userid FROM users WHERE username = :username");
        $fectheduid->bindParam(':username', $oldusern);
        $fectheduid->execute();
        if($fetcheduid->fetch())
        {
            return True;
        }
        else
            return False;
    }
    catch (PDOexception $e) {
        //throw $th;
        echo $e->getMessage();
    }  
}

?>