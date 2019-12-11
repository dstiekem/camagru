

<?php
session_start();
require (dirname(__FILE__) . '/config/database.php');
  try
  {
    $impage = $_GET["page"];
    $offset = $impage * 5;
    $images = $pdo->prepare("SELECT * FROM images LIMIT :offset, 5");
    $images->bindParam(":offset", $offset, PDO::PARAM_INT);
    $images->execute();
    
    if(isset($_SESSION['uid']))
    {
      while($fetchedim = $images->fetch())
      {
  ?>
          <div class="post">
          <form action="comment.php" method="post">
            <input type="hidden" value="<?php echo ($fetchedim['imageid'])?>" name="imageid">
            <input type="image" id="galim" src="<?php echo ($fetchedim['imagepath']);?>" alt="Submit" />
          </form>
        </div>
  <?php
      }
    }
    else
    {
      while($fetchedim = $images->fetch())
      {
?>
        <div class="post">
        <a href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace( "pageofimages.php", "image.php", $_SERVER['REQUEST_URI']);?>'><img id="galim"src="<?php echo ($fetchedim['imagepath']);?>"></a>
        </div>
<?php
      }
    }
  }
  catch (PDOexception $e)
  {
    //throw $th;
    echo $e->getMessage();
  }
  //on click


    //header('location: /newimage.php');

  /* else
  {
    echo "halooo";
    header('Location: ../login.php');
  } */
?>