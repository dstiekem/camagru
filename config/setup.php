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
    username VARCHAR(80),
    email VARCHAR(255),
    emailver BOOL,
    vkey VARCHAR(255),  
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
    commenttext VARCHAR(1024)
);");

//$pdo->exec("DROP TABLE IF EXISTS `camagru`.likes;");
$pdo->exec("CREATE TABLE IF NOT EXISTS `camagru`.likes (
    PRIMARY KEY (imageid, `user_id`),
    `user_id` INT,
    `imageid` INT,
    FOREIGN KEY(imageid) REFERENCES images(imageid) ON DELETE CASCADE,
    FOREIGN KEY(`user_id`) REFERENCES users(`userid`) ON DELETE CASCADE
);");

// $stmt = $pdo->prepare($sql);
?>