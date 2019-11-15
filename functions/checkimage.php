<?php
function checkimage($savedimpath){
    try{
        $checkimage = $pdo->prepare("SELECT * FROM images WHERE imagepath = :imagepath");
        $checkimage->bindParam(":imagepath", $savedimpath);
        $checkimage->execute();
        $fetchedimage = $checkimage->fetch();
        if($fetchedimage)
        {
            return()
        }
    }
    catch (PDOexception $e) {
        //throw $th;
        echo $e->getMessage();
      }
}
?>