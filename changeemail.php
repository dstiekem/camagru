<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet2.css">
    	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,700i,800&display=swap" rel="stylesheet">
	</head>
<body>
<div style="width: 100%; position: static;">
    <?php
    $page = "changeemail";
    require (dirname(__FILE__) . '/header.php');
    require (dirname(__FILE__) . '/config/database.php');
    require (dirname(__FILE__) . '/functions/email.php');
    require (dirname(__FILE__) . '/functions/modal.php');
    ?>
</div>
<?php
session_start();
if(isset($_SESSION['uid']))
{
    if (isset($_POST['email1']) && isset($_POST['email2']))
    {
       $uid = $_SESSION['uid'];
       $enteredoldemail = filter_var($_POST['email1'], FILTER_VALIDATE_EMAIL);
       $enterednewemail = filter_var($_POST['email2'], FILTER_VALIDATE_EMAIL);

       try{
            $checkoldemail = $pdo->prepare("SELECT * FROM users WHERE userid = :userid");
            $checkoldemail->bindParam("userid", $uid);
            $checkoldemail->execute();
            $fetcheduser = $checkoldemail->fetch();
            if($fetcheduser['email'] === $enteredoldemail)
            {
                try{
                    $checknewemail = $pdo->prepare("SELECT * FROM users WHERE email = :newemail");
                    $checknewemail->bindParam("newemail", $enterednewemail);
                    $checknewemail->execute();
                    if($fetchedrest['email'] = $checknewemail->fetch())
                    {
                        $string1 = "error";
                        $string2 = "That email address has already been taken";
                        modal($string1, $string2);
                    }
                    else
                    {
                        $body = "please click this link to verify your new email address for " . $fetcheduser['username'];
                        if(sendemail($enterednewemail, $fetcheduser, $body))
                        {
                            $string1 = "success";
                            $string2 = 'Thank you email has been sent to ' . htmlentities($enterednewemail, ENT_QUOTES) . ". Click the link to confirm new address.";
                            modal($string1, $string2);
                        }
                    }
                }
                catch (PDOexception $e) {
                    //throw $th;
                    echo $e->getMessage();
                } 
            }
            else
            {
                    $string1 = "error";
                    $string2 ="old email does not match this user's current email address. Are you sure this user is you?";
                    modal($string1, $string2);
            }
       }
        catch (PDOexception $e) {
        //throw $th;
        echo $e->getMessage();
        }
    }
    ?>
    <div class="gridsettings">
        <ul class="boxsettings" class="settings" style="float: left; width: 100%; box-shadow: none;">
            <li><a href=http://localhost:8080/mvc2/changeusern.php>CHANGE USERNAME</a></li>
            <li id="selected"><a href=http://localhost:8080/mvc2/changeemail.php>CHANGE EMAIL</a></li>
            <li><a href=http://localhost:8080/mvc2/changepassword.php>CHANGE PASSWORD</a></li>
            <li><a href=http://localhost:8080/mvc2/enablenotif.php>ENABLE NOTIFICATIONS</a></li>
        </ul>
        <div style="width:100%; padding: 1%; background-color: #17141d;">
            <div class="box" class="settings" style="background-color: #17141d; width: 50%; height: 30%; box-shadow: none; text-align: centre;">
                <p class="title" style="padding: 10px; margin: 10px;">Enter your current email address and your new one</p>
                <form action="changeemail.php" method="post">
                    <input type="email" name="email1" placeholder="old email"/>
                    <input type="email" name="email2" placeholder="new email"/>
                    <input type="submit" name="submit" value="CHANGE EMAIL"/>
                </form>
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