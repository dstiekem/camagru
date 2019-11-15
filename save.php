<?php
require (dirname(__FILE__) . '/functions/randomstr.php');
echo $_POST['image'];
$image = imagecreatefromstring(base64_decode($_POST['image']));
$savedimpath = "../mvc2/images/".RandomString(16).".png";

imagepng($image, $savedimpath);
?>
