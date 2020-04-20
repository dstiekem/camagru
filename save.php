<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
require (dirname(__FILE__) . '/functions/randomstr.php');
require (dirname(__FILE__) . '/config/database.php');
/* echo $_POST['image']; */
echo $_POST['sticker'];
function composeimage($cimage, $csticker)
{
    $image = imagecreatefromstring(base64_decode($_POST['image']));

    $sticker = imagecreatefromstring(base64_decode($_POST['sticker']));

    if($image && imagefilter($image, IMG_FILTER_GRAYSCALE))
    {
        $savedimpath = "../mvc2/images/".RandomString(16).".png";
        imagecopy($image, $sticker, 0, 0, 0, 0, 480, 480);
        imagepng($image, $savedimpath);
    }
    global $pdo;
    try{
        $userid = $_SESSION['uid'];
        $insertim = $pdo->prepare("INSERT INTO images (imagepath, `user_id`) VALUES(:impath, :userid)");
        $insertim->bindParam(':impath', $savedimpath);
        $insertim->bindParam(':userid', $userid);
        $insertim->execute();
        $inserted = $insertim->fetch();

    }
    catch (PDOexception $e){
    //throw $th;
        echo $e->getMessage();
    }
    return($savedimpath);
}
composeimage($_POST["image"],  $_POST["sticker"]);
?>
