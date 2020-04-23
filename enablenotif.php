<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet2.css">
    	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,700i,800&display=swap" rel="stylesheet">
	</head>
<body>
<div>
<?php
session_start();
if(isset($_SESSION['uid']))
{
    $userid = $_SESSION['uid'];
    $page = "enablenotif";
    require (dirname(__FILE__) . '/config/database.php');
    require (dirname(__FILE__) . '/header.php');
    require (dirname(__FILE__) . '/functions/setnotif.php');
?>
</div>
    <div class="gridsettings">
        <ul class="boxsettings" class="settings" style="float: left; width: 100%; box-shadow: none;">
            <li><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("enablenotif.php", "changeusern.php", $_SERVER['REQUEST_URI'])?>>CHANGE USERNAME</a></li>
            <li><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("enablenotif.php", "changeemail.php", $_SERVER['REQUEST_URI'])?>>CHANGE EMAIL</a></li>
            <li><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("enablenotif.php", "changepassword.php", $_SERVER['REQUEST_URI'])?>>CHANGE PASSWORD</a></li>
            <li id="selected"><a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>>ENABLE NOTIFICATIONS</a></li>
        </ul>
        <div style=" padding: 1%; background-color: #17141d;">
            <div class="box" class="settings" id="othersettings" style="background-color: #17141d;">
                <p>Enable or disable notification emails sent for likes and comments on your images</p>
            </div>
            <div class="box2" id="othersettings">
                <div action="enablenotif.php" method="post" style="position: inherit;">
                    <label class="switch">
                    <input type="checkbox" name="notif" checked id="toggle">
                    <span class="slider"></span>
                    <input type="submit" name="submit" value="SAVE" />
                    </label>
                </div>
                <?php
                    try{
                        $checknotif = $pdo->prepare("SELECT notif FROM users WHERE userid = :userid");
                        $checknotif->bindParam(':userid', $userid);
                        $checknotif->execute();
                        $fetchednotif = $checknotif->fetch();
                        if($fetchednotif['notif'] == 1)
                        {
                            ?>
                            <script>document.getElementById('toggle').checked = true;</script>
                            <?php
                        }
                        else if($fetchednotif['notif'] == 0)
                        {
                            ?>
                            <script>document.getElementById('toggle').checked = false;</script>
                            <?php
                        }
                    }
                    catch (PDOexception $e) {
                        //throw $th;
                        echo $e->getMessage();
                    }
                ?>
            </div>
        </div>        
    </div>
</div>
<script>
    window.addEventListener('load', (e)=>{
        var notif = document.getElementById("toggle");
        var check = "is";
        notif.addEventListener('change', (e)=>{
            console.log(e.target.checked);
            var request = new XMLHttpRequest();
            request.open("POST", "<?php echo str_replace("enablenotif.php", "functions/setnotif.php", $_SERVER['REQUEST_URI'])?>");
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            request.send("notif=" + e.target.checked + "&iset=" + check);
            console.log(e.target.checked);
        });
    });
</script>
</body>
<?php
}
else
{
    header('Location: ' . str_replace("enablenotif.php", "loggedout.php", $_SERVER['REQUEST_URI']));
}
?>
</html>