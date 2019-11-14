<?php
session_start();
if(isset($_SESSION['uid']))
{
  echo "loggedin";
  require (dirname(__FILE__) . '/config/database.php');
  try
  {
    $images = $pdo->prepare("SELECT imagepath FROM images");
    $images->bindParam();
    $images->execute();
    $fetchedim = $images->fetch();
    foreach($fetchedim as $value)
    {
      echo $value;
    }
    //fecth images to use in html css stuff
  }
  catch (PDOexception $e)
  {
    //throw $th;
    echo $e->getMessage();
  }
  //on click


    //header('location: /newimage.php');
    echo "
    <a href=http://localhost:8080/mvc2/newimage.php>NEW IMAGE<a>;
    <a href=http://localhost:8080/mvc2/loggedout.php>LOG OUT<a>;
    <a href=http://localhost:8080/mvc2/settings.php>SETTINGS<a>
    <div>

    </div>
    ";
}
else
{
  echo "halooo";
  header('Location: ../login.php');
}


?>