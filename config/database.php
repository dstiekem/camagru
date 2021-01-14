<?php
include (dirname(__FILE__) . '/setup.php');
$db_user = 'root';
$db_password = 'root';
$db_host = 'localhost';
$db_dsn = 'mysql:host=localhost';

try {
    $pdo = new PDO($db_dsn , $db_user, $db_password);
    echo "i come in peace\n";
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->query("USE camagru");
} catch (PDOexception $e) {
    //throw $th;
    echo $e->getMessage();
}
?>