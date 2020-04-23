   
    <a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("loggedin.php", "newimage.php", $_SERVER['REQUEST_URI'])?>>NEW IMAGE<a>;
    <a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("loggedin.php", "loggedout.php", $_SERVER['REQUEST_URI'])?>>LOG OUT<a>;
    <a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("loggedin.php", "settings.php", $_SERVER['REQUEST_URI'])?>>SETTINGS<a>
    <div>
    </div>
<?php
session_start();
if(isset($_SESSION['uid']))
{
  echo "loggedin";
  require (dirname(__FILE__) . '/config/database.php');
  try
  {
    $images = $pdo->prepare("SELECT imagepath FROM images");
    $images->bindParam();
    $images->execute();
    $fetchedim = $images->fetch();
    foreach($fetchedim as $value)
    {
      echo $value;
    }
  }
  catch (PDOexception $e)
  {
    echo $e->getMessage();
  }
}
else
{
  header('Location: ' . str_replace("changeemail.php", "loggedout.php", $_SERVER['REQUEST_URI']));
}
?>