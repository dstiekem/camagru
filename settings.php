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
            try{
                $fetchusers = $pdo->prepare("SELECT * FROM users WHERE userid = :userid");
                $fetchusers->bindParam("userid", $_SESSION['uid']);
                $fetchusers->execute();
                $users = $fetchusers->fetch();
            }
            catch (PDOexception $e)
            {
                //throw $th;
                echo $e->getMessage();
            }
        ?>
        
        <div class="gridsettings">
            <ul class="boxsettings" class="settings" style="float: left; width: 100%; box-shadow: none;">
                <li><a href=http://localhost:8080/mvc2/changeusern.php>CHANGE USERNAME</a></li>
                <li><a href=http://localhost:8080/mvc2/changeemail.php>CHANGE EMAIL</a></li>
                <li><a href=http://localhost:8080/mvc2/changepassword.php>CHANGE PASSWORD</a></li>
                <li><a href=http://localhost:8080/mvc2/enablenotif.php>ENABLE NOTIFICATIONS</a></li>
            </ul>
            <div class=settingsfield>
                <div class="box" class="settings" id="othersettings">
                    <p class="title">Hello <?php echo $users['username'];?></p>
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