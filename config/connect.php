<?php
require_once('../config/database.php');
try
{
    echo "mysql:host=$db_host:dbname=camagru";
    $pdo = new PDO("mysql:host=$db_host;dbname=camagru", $db_user, $db_password);
    echo "i come in peace\n";
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $err){
    echo $err->getMessage();
}
// $stmt = $pdo->prepare($sql);
?>