<?php
    require (dirname(__FILE__) . '/config/database.php');
    $image = $_GET["im"];
    ?>
    <img id="galim" src=<?php echo $image?>>
    <?php
?>