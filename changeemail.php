<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet2.css">
    	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,700i,800&display=swap" rel="stylesheet">
	</head>
<body>
<?php
session_start();
if(isset($_SESSION['uid']))
{
    if (isset($_POST['email1']) && isset($_POST['email2']))
    {
       $uid = $_SESSION['uid'];
       $enteredoldemail = filter_var($_POST['email1'], FILTER_VALIDATE_EMAIL);
       $enterednewemail = filter_var($_POST['email2'], FILTER_VALIDATE_EMAIL);
       $checkoldemail = $pdo->prepare("SELECT email FROM users WHERE userid = :userid");
       $checkoldemail->bindParam($uid, ":userid");
       $checkoldemail->execute();
       if($fetchedemail = $checkoldemail->fetch())
       {
           email($enterednewemail, );
       }
    }
    ?>
    <div style="width: 100%; position: static;">
        <?php
        $page = "changeemail";
        require (dirname(__FILE__) . '/header.php');
        ?>
    </div>
    <div style="width: 100%; height: auto; margin: 0; overflow: auto;">
        <ul class="box" class="settings" style="float: left; width: 100%;">
            <li><a href=http://localhost:8080/mvc2/changeusern.php>CHANGE USERNAME</a></li>
            <li><a class="active" href=http://localhost:8080/mvc2/changeemail.php>CHANGE EMAIL</a></li>
            <li><a href=http://localhost:8080/mvc2/changepassword.php>CHANGE PASSWORD</a></li>
            <li><a href=http://localhost:8080/mvc2/.php>ENABLE NOTIFICATIONS</a></li>
        </ul>
        <div class="box" style="width: 100%; float: left; height: initial;">
            <p class="title">enter your current email address and your new one</p>
            <div action="changeemail.php" method="post">
                <input type="email" name="email1" placeholder="old email"/>
                <input type="email" name="email2" placeholder="new email"/>
                <input type="submit" name="submit" value="CHANGE EMAIL"/>
            </div>
        </div>
    </div>
<?php
}
else
{
    header('Location: ../mvc2/login.php');
}
?>
</body>
</html>