<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
echo $_POST['sticker'];
require (dirname(__FILE__) . '/functions/randomstr.php');
function composeimage($cimage, $csticker){
    $image = imagecreatefromstring(base64_decode($cimage));

    $sticker = imagecreatefromstring(base64_decode($csticker));

    if($image && imagefilter($image, IMG_FILTER_GRAYSCALE))
    {
      /*   $savedimpath = "../mvc2/images/cache".RandomString(16).".png"; */
        imagecopy($image, $sticker, 0, 0, 0, 0, 480, 480);
       /*  imagepng($image, $savedimpath); */
        return($image);
    }
}
composeimage($_POST["image"],  $_POST["sticker"]);
?>