

<?php
session_start();
require (dirname(__FILE__) . '/config/database.php');
  try
  {
    $impage = $_GET["page"];
    $offset = $impage * 5;
    $images = $pdo->prepare("SELECT * FROM images ORDER BY imagetime DESC LIMIT :offset, 5");
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
          <form action="image.php" method="post">
            <input type="hidden" value="<?php echo ($fetchedim['imageid'])?>" name="imageid">
            <input type="image" id="galim" src="<?php echo ($fetchedim['imagepath']);?>" alt="Submit" />
          </form>
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