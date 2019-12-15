<?php
session_start();
require (dirname(__FILE__) . '/config/database.php');
if(isset($_SESSION['uid']))
{
    ?>
    <html>
        <head>
            <link rel="stylesheet" type="text/css" href="stylesheet2.css">
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,700,800&display=swap" rel="stylesheet">
        </head>
        <body>
        <?php
            $page = "settings";
            require (dirname(__FILE__) . '/header.php');
        ?>
        
        <div class="gridsettings">
            <ul class="boxsettings" class="settings" style="float: left; width: 100%; box-shadow: none;">
                <li><a href=http://localhost:8080/mvc2/changeusern.php>CHANGE USERNAME</a></li>
                <li><a href=http://localhost:8080/mvc2/changeemail.php>CHANGE EMAIL</a></li>
                <li><a href=http://localhost:8080/mvc2/changepassword.php>CHANGE PASSWORD</a></li>
                <li><a href=http://localhost:8080/mvc2/enablenotif.php>ENABLE NOTIFICATIONS</a></li>
            </ul>
            <div style="width:100%; padding: 1%;">
                <div class="box" class="settings" style="width: 50%; height: 30%; margin: 10% auto; box-shadow: none; text-align: centre;">
                    <p>Change username, password and email. enable or disable notifications</p>
                </div>
            </div>
        </div>
        
        </body>
    </html>
<?php
}
else
{
    header('Location: ../mvc2/login.php');
}
?>