<?php
session_start();
if(!isset($_SESSION['uid']))
{
    header('Location: ' . str_replace("save.php", "newimage.php", $_SERVER['REQUEST_URI']));
}
require (dirname(__FILE__) . '/functions/randomstr.php');
require (dirname(__FILE__) . '/config/database.php');
/* echo $_POST['image']; */
function composeimage($cimage, $csticker)
{
    $image = imagecreatefromstring(base64_decode($_POST['image']));
    imagefilter($image, IMG_FILTER_GRAYSCALE);

    if($csticker != "NOT")
    {
        $sticker = imagecreatefromstring(base64_decode($_POST['sticker']));
        imagecopy($image, $sticker, 0, 0, 0, 0, 480, 480);
    }
    $charset='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $savedimpath = ".." . str_replace("save.php", "images/", $_SERVER['REQUEST_URI']) . RandomString(16, $charset) . ".png";
    imagepng($image, $savedimpath);
    global $pdo;
    try{
        $userid = $_SESSION['uid'];
        $insertim = $pdo->prepare("INSERT INTO images (imagepath, `user_id`) VALUES(:impath, :userid)");
        $insertim->bindParam(':impath', $savedimpath);
        $insertim->bindParam(':userid', $userid);
        $insertim->execute();
        /* $inserted = $insertim->fetch(); */
        $fetchedim = $pdo->prepare("SELECT * FROM images WHERE imagepath = :immpath");
        $fetchedim->bindParam(':immpath', $savedimpath);
        $fetchedim->execute();
        $im = $fetchedim->fetch();
        echo $im['imageid'];
        echo $im['imagepath'];

    }
    catch (PDOexception $e){
    //throw $th;
        echo $e->getMessage();
    }
    return($savedimpath);
}
if(isset($_POST['image']))
{
    composeimage($_POST["image"],  $_POST["sticker"]);
}
?>
