<?php
require("../config/connect.php");
$userid = $_POST["userid"];
$imageid = $_POST["imageid"];

// verification

try
{
    $stmt = $pdo->prepare("INSERT INTO `likes` (`user_id`, `imageid`) VALUES (?, ?);");
    $stmt->execute(array($userid, $imageid));
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>