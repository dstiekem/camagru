<?php
include (dirname(__FILE__) . '/database.php');


//$file = fopen("./database.sql", "r");

//$stmt = fread($file,filesize("./database.sql"));

//$thing = $pdo->prepare($stmt);
//$thing->execute();

$pdo->exec("DROP DATABASE IF EXISTS camagru;");
$pdo->exec("CREATE DATABASE IF NOT EXISTS camagru;");

//$pdo->exec("DROP TABLE IF EXISTS `camagru`.`users`;");
$pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.`users` (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80) CHARACTER SET utf8,
    email VARCHAR(255) CHARACTER SET utf8,
    emailver BOOL,
    notif BOOL,
    vkey VARCHAR(255) CHARACTER SET utf8,  
    passwd VARCHAR(255)
);");


//$pdo->exec("DROP TABLE IF EXISTS `camagru`.`images`;");
$pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.`images` (
    imageid INT AUTO_INCREMENT PRIMARY KEY, 
    imagepath VARCHAR(260),
    imagetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    userid INT,
    FOREIGN KEY(userid) REFERENCES `camagru`.users(userid)
    
);");

//$pdo->exec("DROP TABLE IF EXISTS `camagru`.comments;");
$pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.comments (
    commentid INT  AUTO_INCREMENT PRIMARY KEY,
    `imageid` INT,
    `user_id` INT,
    FOREIGN KEY (`user_id`) REFERENCES users(`userid`) ON DELETE CASCADE,
    FOREIGN KEY (imageid) REFERENCES images(imageid) ON DELETE CASCADE,
    commenttime DATETIME DEFAULT CURRENT_TIMESTAMP,
    commenttext VARCHAR(1024) CHARACTER SET utf8
);");

//$pdo->exec("DROP TABLE IF EXISTS `camagru`.likes;");
$pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.likes (
    PRIMARY KEY (imageid, `user_id`),
    `user_id` INT,
    `imageid` INT,
    FOREIGN KEY(imageid) REFERENCES images(imageid) ON DELETE CASCADE,
    FOREIGN KEY(`user_id`) REFERENCES users(`userid`) ON DELETE CASCADE
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
    (01, '../stickers/1.png', 'hangerb'),
    (02, '../stickers/g1699.png', 'washmachw'),
    (04, '../stickers/g1708.png', 'washmachb'),
    (05, '../stickers/g1779.png', 'greenshirtb'),
    (06, '../stickers/g1783.png', 'orangeshirtb'),
    (07, '../stickers/g1754.png', 'orangesparkw'),
    (08, '../stickers/g1899.png', 'orangeshirtw'),
    (09, '../stickers/g1903.png', 'greenshirtw'),
    (10, '../stickers/g1908.png', 'coathangerw'),
    (11, '../stickers/g1955-2-8.png', 'greenpoofw'),
    (12, '../stickers/g1955-2.png', 'orangepoofw'),
    (13, '../stickers/g1955.png', 'orangepoofb'),
    (14, '../stickers/g2147.png', 'orangecrownw'),
    (15, '../stickers/g2154.png', 'blackcrownog'),
    (16, '../stickers/g2161.png', 'whitecrowng'),
    (17, '../stickers/g3922.png', 'eyeballb'),
    (18, '../stickers/g4035.png', 'footb'),
    (19, '../stickers/g4108.png', 'footw'),
    (20, '../stickers/g4243.png', 'handw'),
    (21, '../stickers/g4252.png', 'handb'),
    (22, '../stickers/g4258.png', 'greenfistw'),
    (23, '../stickers/g4263.png', 'orangefistw'),
    (24, '../stickers/g4268.png', 'orangefistb'),
    (25, '../stickers/g4274.png', 'greenfistb'),
    (26, '../stickers/g4416.png', 'greensparkb'),
    (27, '../stickers/g4463.png', 'orangetearw');
):");

$pdo->exec("INSERT INTO `camagru`.assets (asskey, asspath, assname) VALUES
    (01, '../graphics/logo_trans.png', 'logo'),
    (02, '../graphics/underline1.png'),
    (03, '../graphics/underline2.png'),
    (04, '../graphics/underline3.png'),
    (05, '../graphics/underline4.png');

):");

/* $pdo->exec("INSERT INTO `camagru`.users (username, email, emailver, notif, passwd)
 
    (, '../graphics/underline4.png');

):");
 */
// $stmt = $pdo->prepare($sql);
?>