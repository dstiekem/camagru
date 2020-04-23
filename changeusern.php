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
        /* require (dirname(__FILE__) . '/functions/fetchuid.php'); */
        require (dirname(__FILE__) . '/functions/modal.php');
    if(isset($_SESSION['uid']))
    {
        $uid = $_SESSION['uid'];
        if(isset($_POST['oldusername']) && isset($_POST['newusername']))
        {
            $oldusern = $_POST['oldusername'];
            $newusern = $_POST['newusername'];
            try{
                $checkuid = $pdo->prepare("SELECT userid FROM users WHERE username = :username");
                $checkuid->bindParam(':username', $oldusern);
                $checkuid->execute();
                $fetcheduid = $checkuid->fetch();
                if($fetcheduid['userid'] === $uid)
                {
                    try{
                        $updusername = $pdo->prepare("UPDATE users SET username = :newusername WHERE userid = :userid");
                        $updusername->bindParam("newusername", $newusern);
                        $updusername->bindParam("userid", $uid);
                        $updusername->execute();
                        $string1 = "success";
                        $string2 = "Please loggout to set changes";
                        modal($string1, $string2);
                    }
                    catch (PDOexception $e) {
                        //throw $th;
                        echo $e->getMessage();
                    }
                }
                else
                {
                    $string1 = "error";
                    $string2 = "oops! it appears your <b> old username </b> is not the user logged in";
                    modal($string1, $string2);
                }
            }
            catch (PDOexception $e) {
                //throw $th;
                echo $e->getMessage();
            }      
        }
    ?>
    </div>
    <div class="gridsettings">
        <ul class="boxsettings" class="settings" style="float: left; width: 100%; box-shadow: none;">
            <li id="selected"><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>>CHANGE USERNAME</a></li>
            <li><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("changeusern.php", "changeemail.php", $_SERVER['REQUEST_URI'])?>>CHANGE EMAIL</a></li>
            <li><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("changeusern.php", "changepassword.php", $_SERVER['REQUEST_URI'])?>>CHANGE PASSWORD</a></li>
            <li><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("changeusern.php", "enablenotif.php", $_SERVER['REQUEST_URI'])?>>ENABLE NOTIFICATIONS</a></li>
        </ul>
        <div class=settingsfield style="background-color: #17141d;">
            <div class="box" class="settings" id="othersettings" style="background-color: #17141d;">
                <p class="title">Enter your current username and your new one</p>
                <form action="changeusern.php" method="post">
                    <input type="text" name="oldusername" placeholder="current username" />
                    <input type="text" name="newusername" placeholder="new username" />
                    <input type="submit" name="submit" value="CHANGE USERNAME" />
                </form>
            </div>
        </div>
    </div>
    </body>
</html>
<?php
}
else
{
    header('Location: ' . str_replace("changeusern.php", "loggedout.php", $_SERVER['REQUEST_URI']));
}
?>