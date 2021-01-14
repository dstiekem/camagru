<?php
include (dirname(__FILE__) . '/database.php');
session_start();
session_destroy();
/* try {
    $pdo = new PDO($db_dsn , $db_user, $db_password);
    echo "i come in peace\n";
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->query("USE camagru");
} catch (PDOexception $e) {
    //throw $th;
    echo $e->getMessage();
} */
try{
    $pdo = new PDO($db_dsn , $db_user, $db_password);
    echo "i come in peace\n";
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->query("USE camagru");
    //$pdo->exec("DROP DATABASE IF EXISTS camagru;");
    //$pdo->exec("CREATE DATABASE IF NOT EXISTS camagru;");

    //$pdo->exec("DROP TABLE IF EXISTS `camagru`.`users`;");
    $pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.`users` (
        userid INT(5) ZEROFILL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(80) CHARACTER SET utf8,
        email VARCHAR(255) CHARACTER SET utf8,
        emailver BOOL,
        notif BOOL NOT NULL,
        vkey VARCHAR(255) CHARACTER SET utf8,  
        passwd VARCHAR(255)
    );");

    //$pdo->exec("DROP TABLE IF EXISTS `camagru`.`images`;");
    $pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.`images` (
        imageid INT(5) ZEROFILL AUTO_INCREMENT PRIMARY KEY, 
        imagepath VARCHAR(260),
        imagetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `user_id` INT(5) ZEROFILL REFERENCES `camagru`.users(`userid`) ON DELETE CASCADE
    );");

    //$pdo->exec("DROP TABLE IF EXISTS `camagru`.comments;");
    $pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.comments (
        commentid INT  AUTO_INCREMENT PRIMARY KEY,
        `imageid` INT(5) ZEROFILL,
        `user_id` INT(5) ZEROFILL,
        FOREIGN KEY (`user_id`) REFERENCES users(`userid`) ON DELETE CASCADE,
        FOREIGN KEY (imageid) REFERENCES images(imageid) ON DELETE CASCADE,
        commenttime DATETIME DEFAULT CURRENT_TIMESTAMP,
        commenttext VARCHAR(1024) CHARACTER SET utf8
    );");

    //$pdo->exec("DROP TABLE IF EXISTS `camagru`.likes;");
    $pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.likes (
        PRIMARY KEY (imageid, `user_id`),
        `imageid` INT(5) ZEROFILL,
        `user_id` INT(5) ZEROFILL,
        FOREIGN KEY(imageid) REFERENCES images(imageid) ON DELETE CASCADE,
        FOREIGN KEY(`user_id`) REFERENCES users(`userid`) ON DELETE CASCADE
        /* likeswitch BOOL INT */
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.stickers (
        stickey INT PRIMARY KEY,
        stickpath VARCHAR(255) CHARACTER SET utf8,
        stickname VARCHAR(255) CHARACTER SET utf8
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.assets (
        asskey INT PRIMARY KEY,
        asspath VARCHAR(255) CHARACTER SET utf8,
        assname VARCHAR(255) CHARACTER SET utf8
    );");

    $pdo->exec("INSERT INTO `camagru`.stickers (stickey, stickpath, stickname) VALUES
        (01, 'http://localhost:8080/camagru/stickers/1.png', 'hangerb'),
        (02, 'http://localhost:8080/camagru/stickers/g1699.png', 'washmachw'),
        (04, 'http://localhost:8080/camagru/stickers/g1708.png', 'washmachb'),
        (05, 'http://localhost:8080/camagru/stickers/g1779.png', 'greenshirtb'),
        (06, 'http://localhost:8080/camagru/stickers/g1783.png', 'orangeshirtb'),
        (07, 'http://localhost:8080/camagru/stickers/g1854.png', 'orangesparkw'),
        (08, 'http://localhost:8080/camagru/stickers/g1899.png', 'orangeshirtw'),
        (09, 'http://localhost:8080/camagru/stickers/g1903.png', 'greenshirtw'),
        (10, 'http://localhost:8080/camagru/stickers/g1908.png', 'coathangerw'),
        (11, 'http://localhost:8080/camagru/stickers/g1955-2-8.png', 'greenpoofw'),
        (12, 'http://localhost:8080/camagru/stickers/g1955-2.png', 'orangepoofw'),
        (13, 'http://localhost:8080/camagru/stickers/g1955.png', 'orangepoofb'),
        (14, 'http://localhost:8080/camagru/stickers/g2147.png', 'orangecrownw'),
        (15, 'http://localhost:8080/camagru/stickers/g2154.png', 'blackcrownog'),
        (16, 'http://localhost:8080/camagru/stickers/g2161.png', 'whitecrowng'),
        (17, 'http://localhost:8080/camagru/stickers/g3922.png', 'eyeballb'),
        (18, 'http://localhost:8080/camagru/stickers/g4035.png', 'footb'),
        (19, 'http://localhost:8080/camagru/stickers/g4108.png', 'footw'),
        (20, 'http://localhost:8080/camagru/stickers/g4243.png', 'handw'),
        (21, 'http://localhost:8080/camagru/stickers/g4252.png', 'handb'),
        (22, 'http://localhost:8080/camagru/stickers/g4258.png', 'greenfistw'),
        (23, 'http://localhost:8080/camagru/stickers/g4263.png', 'orangefistw'),
        (24, 'http://localhost:8080/camagru/stickers/g4268.png', 'orangefistb'),
        (25, 'http://localhost:8080/camagru/stickers/g4274.png', 'greenfistb'),
        (26, 'http://localhost:8080/camagru/stickers/g4416.png', 'greensparkb'),
        (27, 'http://localhost:8080/camagru/stickers/g4463.png', 'orangetearw');
    ):");

    $pdo->exec("INSERT INTO `camagru`.assets (asskey, asspath, assname) VALUES
        (01, '../graphics/logo_trans.png', 'logo'),
        (02, '../graphics/underline1.png', 'underline1'),
        (03, '../graphics/underline2.png', 'underline2'),
        (04, '../graphics/underline3.png', 'underline3'),
        (05, '../graphics/underline4.png', 'underline4');
    ):");

    $pdo->exec("INSERT INTO `camagru`.users (userid, username, email, emailver, notif) VALUES
        (00001, 'asd', 'dominique.stiekema@gmail.com', 1, 1),
        (00002, 'sock', 'domd.sock@gmail.com', 1, 1),
        (00003, 'dstiekem', 'dstiekem@student.wethinkcode.co.za', 1, 1);
    ):");

    $pdo->exec("INSERT INTO `camagru`.images (`user_id`, imagepath) VALUES
        (00002, 'http://localhost:8080/camagru/images/838a4811507903.560f8cf785d58.jpeg'),
        (00003, 'http://localhost:8080/camagru/images/679e0787804929.5dc31a3438525.jpg'),
        (00001, 'http://localhost:8080/camagru/images/7929b487816657.5dc36c0fb6e3d.jpg'), 
        (00002, 'http://localhost:8080/camagru/images/a893f411507903.560f8cc727176.jpeg'), 
        (00002, 'http://localhost:8080/camagru/images/15e3c811507903.560f8cd13e70c.jpeg'), 
        (00001, 'http://localhost:8080/camagru/images/166bbc87766383.5dc2255c5bf74.jpg'),
        (00002, 'http://localhost:8080/camagru/images/eqpbw0ccwhwNx0IS.png'),
        (00003, 'http://localhost:8080/camagru/images/IKouqECwL7JutMb.png'),
        (00001, 'http://localhost:8080/camagru/images/JnkoRZrdoZY3na.png'),
        (00001, 'http://localhost:8080/camagru/images/X0eJTQdkRVGkXpTf.png'),
        (00003, 'http://localhost:8080/camagru/images/YeuBWaQ2XnGYW3tt.png'),
        (00002, 'http://localhost:8080/camagru/images/C2SPJ4Ipga55ltuN.png'),
        (00003, 'http://localhost:8080/camagru/images/WXtVU452Z2XOMpnt.png'),
        (00003, 'http://localhost:8080/camagru/images/ZcccqIru0Ddq4t5X.png'),
        (00002, 'http://localhost:8080/camagru/images/lHLRU4dMlDjswY0e.png');
    ):");

    $pdo->exec("INSERT INTO `camagru`.likes (`imageid`, `user_id`) VALUES
    (3, 00001),
    (4, 00002),
    (1, 00003);
    ):");
    ?>
    <html>
    <body style="background-color: #0f0d14">
    <div style="display: grid; grid-template-columns: 30% auto 30%; margin: 300px 0 0 0; text-align: center;">
        <div></div>
        <div><h1 style="font-family: 'Open Sans', sans-serif; color: white;">ALL SET</h1></div>
        <div></div>
        <div></div>
        <div><a style="text-decoration: none;" href='<?php echo "http://" . $_SERVER['HTTP_HOST'] . str_replace("config/setup.php", "index.php", $_SERVER['REQUEST_URI']);?>'><h4 style="font-family: 'Open Sans', sans-serif; color: #342d3d;">GO TO CAMAGRU</h4></a></div>
        <div></div>
    </div>
    </body>
    </html>
    <?php
}
catch (PDOexception $e) {
    //throw $th;
    
    ?>
    <html>
    <body style="background-color: #0f0d14">
    <div style="display: grid; grid-template-columns: 30% auto 30%; margin: 300px 0 0 0; text-align: center;">
        <div></div>
        <div><h1 style="font-family: 'Open Sans', sans-serif; color: white;">OOPS</h1></div>
        <div></div>
        <div></div>
        <div><h4 style="font-family: 'Open Sans', sans-serif; color: #342d3d;">FIX THIS:</h4></div>
        <div></div>
        <div></div>
        <div><h4 style="font-family: 'Open Sans', sans-serif; color: #342d3d;"><?php echo $e->getMessage();?></h4></div>
        <div></div>
    </div>
    </body>
    </html>
    <?php
}
// $stmt = $pdo->prepare($sql);
?>