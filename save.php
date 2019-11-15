<?php
echo $_POST['image'];
$image = imagecreatefromstring(base64_decode($_POST['save']));
$savedimpath = "./images/".RandomString(16).".png";

imagepng($image, $savedimpath);
?>
