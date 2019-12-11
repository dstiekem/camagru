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
<div style="width: 100%; position: relative;">
    <div class="box" style="width: 100%; margin: 0;">
        <ul class="settings">
            <li><a href=http://localhost:8080/mvc2/changeusern.php>CHANGE USERNAME</a></li>
            <li><a class="active" href=http://localhost:8080/mvc2/changeemail.php>CHANGE EMAIL</a></li>
            <li><a href=http://localhost:8080/mvc2/changepassword.php>CHANGE PASSWORD</a></li>
            <li><a href=http://localhost:8080/mvc2/enablenotif.php>ENABLE NOTIFICATIONS</a></li>
        </ul>
        <div style="padding:1px 16px;height:1000px;float: left;">
            <div class="box2">
            <div action="enablenotif.php" method="post">
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
                    /* if($fetchednotif['notif'] == 0)
                    {
                        echo "<script>
                            document.getElementsByName(\"notif\").checked = false;
                        </script>";
                    }
                    else if($fetchednotif['notif'] == 1)
                    {
                        echo "<script>
                            document.getElementByName(\"notif\").checked = true;
                        </script>";
                    } */
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
        notif.addEventListener('change', (e)=>{
            console.log(e.target.checked);
            var request = new XMLHttpRequest();
            request.open("POST", "/mvc2/functions/setnotif.php");
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
           /*  request.onreadystatehange = function () {
                if(request.readyState == 4 && request.status == 200){
                    
                }
            } */

            request.send("notif=" + e.target.checked);
        })
    });
</script>
</body>
<?php
}
else
{
    header('Location: ../mvc2/login.php');
}
?>
</html>