<?php
session_start();

require (dirname(__FILE__) . '/config/database.php');
require (dirname(__FILE__) . '/functions/randomiseimages.php');
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

/* else
{
  echo "halooo";
  header('Location: ../login.php');
} */

?>
<html>
  <head>
  <link rel="stylesheet" type="text/css" href="stylesheet2.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,800&display=swap" rel="stylesheet">
  </head>
  <body>
    <div>
    <ul class="nav">
      <li id="home" style="float:left"><a href=http://localhost:8080/mvc2/home.php><img class="active" src="../mvc2/graphics/logo_trans.png"></a></li>
      <li class="grad"><a class="inactive" href=http://localhost:8080/mvc2/newimage.php>NEW IMAGE</a></li>
      <li class="grad"><a class="inactive" href=http://localhost:8080/mvc2/loggedout.php>LOGOUT</a></li>
      <li class="grad"><a class="inactive" href=http://localhost:8080/mvc2/settings.php>SETTINGS</a></li>
      
    </ul>
    </div>
  <div>
  </div>
  </body>
</html>