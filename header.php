<?php
     /* session_start(); */
    require (dirname(__FILE__) . '/functions/findmaindir.php');
    $page = (isset($page)) ? $page : "home";
    $page2 = findmaindir($_SERVER['HTTP_HOST']);
    $loginout = (isset($_SESSION['uid'])) ? "LOGOUT" : "LOGIN";

    /* if(isset($_SESSION['uid']))
    { */
    ?>
    <ul class="navi">
        <li style="float:left"><a id="home" href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace($page.".php", "home.php", $_SERVER['REQUEST_URI']);?>'><img id="active" src= <?php echo ".." . str_replace($page . ".php", "graphics/logo_trans.png", $_SERVER['REQUEST_URI'])?>></a></li>
        <li><a class="navlinks active" id="newimage" href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace($page.".php", "newimage.php", $_SERVER['REQUEST_URI']);?>'>NEW IMAGE</a></li>
        <li><a class="navlinks active" id="loginout" href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace($page.".php", "loggedout.php", $_SERVER['REQUEST_URI']);?>'><?php echo $loginout;?></a></li>
        <li><a class="navlinks active" id="setting" href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace($page.".php", "settings.php", $_SERVER['REQUEST_URI']);?>'>SETTINGS</a></li> 
    </ul>
    <?php
    if(!isset($_SESSION['uid']))
    {
       
        ?>
        <script>  
            var a = document.getElementById("newimage").href = '<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace($page.".php", "loggedout.php", $_SERVER['REQUEST_URI']);?>';
            var b = document.getElementById("setting").href = '<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace($page.".php", "loggedout.php", $_SERVER['REQUEST_URI']);?>';
            var c = document.getElementById("loginout").href = '<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace($page.".php", "loggedout.php", $_SERVER['REQUEST_URI']);?>';
        </script>
        <?php
    }
    ?>