    <html>
        <?php
        require (dirname(__FILE__) . '/functions/findmaindir.php');
        $page = findmaindir($_SERVER['REQUEST_URI']);
        ?>
    <body style="background-color: #0f0d14">
    <div style="display: grid; grid-template-columns: 30% auto 30%; margin: 100px 0 0 0; text-align: center;">
        <div></div>
        <div><h1 style="font-family: 'Open Sans', sans-serif; color: white;">SOZ BRUH</h1></div>
        <div></div>

        <div></div>
        <div><img src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace($page, "/graphics/giphy.gif", $_SERVER['REQUEST_URI'])?>">></div>
        <div></div>

        <div></div>
        <div><h4 style="font-family: 'Open Sans', sans-serif; color: #342d3d;"><?php echo $_SERVER['REQUEST_URI'] . " doesn't exist. try:" ;?></h4></div>
        <div></div>

        <div></div>
        <div><a style="text-decoration: none;" href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace($page, "/home.php", $_SERVER['REQUEST_URI']);?>'><h4 style="font-family: 'Open Sans', sans-serif; color: #342d3d;">GO TO CAMAGRU</h4></a></div>
        <div></div>
    </div>
    </body>
    </html>