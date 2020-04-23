<?php
session_start();
if(!isset($_POST['imageid']))
{
    header('Location: ' . str_replace("image.php", "home.php", $_SERVER['REQUEST_URI']));
}
    require (dirname(__FILE__) . '/config/database.php');
    $imageid = $_POST['imageid'];
    try{
        $querim = $pdo->prepare("SELECT imagepath FROM images WHERE imageid = :imid");
        $querim->bindParam(':imid', $imageid);
        $querim->execute();
        $fetchim = $querim->fetch();
        }
        catch (PDOexception $e)
        {
            //throw $th;
            echo $e->getMessage();
        }
    ?>
        <img id="galim" src=<?php echo $fetchim['imagepath']?>>
    <?php
?>