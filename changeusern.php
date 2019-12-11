<?php
session_start();
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="stylesheet2.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,700i,800&display=swap" rel="stylesheet">
    </head>
    <body>
    <?php
        $page = "changeusern";
        require (dirname(__FILE__) . '/header.php');
        require (dirname(__FILE__) . '/config/database.php');
        require (dirname(__FILE__) . '/functions/fetchuid.php');
        require (dirname(__FILE__) . '/functions/modal.php');
    if(isset($_SESSION['uid']))
    {
        $uid = $_SESSION['uid'];
        if(isset($_POST['oldusername']) && isset($_POST['newusername']))
        {
            $oldusern = $_POST['oldusername'];
            $newusern = $_POST['newusername'];
            if(!fetchuid($oldusern, $uid))
            {
                $string1 = "error";
                $string2 = "oops! it appears your <b> old username </b> is not the user logged in";
                modal($string1, $string2);
            }
        }
    ?>
    </div>
    <div style="width: 100%; height: auto; margin: 0; overflow: auto;">
        <ul class="box" class="settings" style="float: left; width: 100%;">
            <li><a class="active" href=http://localhost:8080/mvc2/changeusern.php>CHANGE USERNAME</a></li>
            <li><a href=http://localhost:8080/mvc2/changeemail.php>CHANGE EMAIL</a></li>
            <li><a href=http://localhost:8080/mvc2/changepassword.php>CHANGE PASSWORD</a></li>
            <li><a href=http://localhost:8080/mvc2/enablenotif.php>ENABLE NOTIFICATIONS</a></li>
        </ul>
        <div class="box" style="width: 100%; float: left; height: initial;">
            <p class="title">enter your current username and your new one</p>
            <form action="changeusern.php" method="post">
                <input type="text" name="oldusername" placeholder="current username" />
                <input type="text" name="newusername" placeholder="new username" />
                <input type="submit" name="submit" value="CHANGE USERNAME" />
            </form>
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