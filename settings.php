<?php
session_start();

echo "
";

?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="stylesheet2.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,800&display=swap" rel="stylesheet">
    </head>
    <body>
    <div style="width: 100%; position: static;">
    <ul class="nav">
      <li id="home" style="float:left"><a href=http://localhost:8080/mvc2/home.php><img class="active" src="../mvc2/graphics/logo_trans.png"></a></li>
      <li class="grad"><a class="inactive" href=http://localhost:8080/mvc2/newimage.php>NEW IMAGE</a></li>
      <li class="grad"><a class="inactive" href=http://localhost:8080/mvc2/loggedout.php>LOGOUT</a></li>
      <li class="grad"><a class="inactive" href=http://localhost:8080/mvc2/settings.php>SETTINGS</a></li>
    </ul>
    </div>
    <div style="width: 100%; position: relative; display: block;">
    <div class="box"> 
        <a href=http://localhost:8080/mvc2/changeusern.php>CHANGE USERNAME</a>  
        <a href=http://localhost:8080/mvc2/changeemail.php>CHANGE EMAIL</a>
        <a href=http://localhost:8080/mvc2/changepassword.php>CHANGE PASSWORD</a>
        <a href=http://localhost:8080/mvc2/.php>ENABLE NOTIFICATIONS</a>
    </div>
    </div>
    </body>
</html>