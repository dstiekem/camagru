<?php
include ('../config/database.php');
{
    $key = $_GET["key"];
    try{
        $update = $pdo->prepare("UPDATE users set emailver = 1 WHERE  vkey = :vkey");
        $update->bindParam(':vkey', $key);
        $update = $update->execute();
        header('Location: ../login.php');
    }
    catch (PDOexception $e) {
        //throw $th;
        echo $e->getMessage();
    }
}
?>