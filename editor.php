<html>
    <head>
    </head>
        <link rel="stylesheet" type="text/css" href="stylesheet2.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,700,800&display=swap" rel="stylesheet">
    <body>
    <?php

    ?>
    <body>
        <div>
        <ul class="navi">
        <li id="home" style="float:left"><a href=http://localhost:8080/mvc2/home.php><img class="inactive" src="../mvc2/graphics/logo_trans.png"></a></li>
        <li><a class="active" href=http://localhost:8080/mvc2/newimage.php>NEW IMAGE</a></li>
        <li><a class="inactive" href=http://localhost:8080/mvc2/loggedout.php>LOGOUT</a></li>
        <li><a class="inactive" href=http://localhost:8080/mvc2/settings.php>SETTINGS</a></li>
        </ul>
        </div>
        <div id="galim">
        <img class="gallery" src="<?php echo $fetchedim?>">
        </div>
    </body>
</html>