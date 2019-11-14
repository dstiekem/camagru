-- CREATE DATABASE IF NOT EXISTS camagru;

DROP TABLE IF EXISTS `camagru`.`users`;
CREATE TABLE `camagru`.`users` (
    username VARCHAR(80) PRIMARY KEY,
    email VARCHAR(255),
    emailver BOOL,
    passwd VARCHAR(255)
);

DROP TABLE IF EXISTS `camagru`.`images`;
CREATE TABLE `camagru`.`images` (
    imageid INT PRIMARY KEY, 
    imagepath VARCHAR(260),
    imagetime DATETIME(),
    FOREIGN KEY (username)
    
);

DROP TABLE IF EXISTS `camagru`.comments;
CREATE TABLE `camagru`.comments (
    commentid INT PRIMARY KEY,
    FOREIGN KEY (username),
    FOREIGN KEY (imageid),
    commenttime DATETIME(),
    commenttext TEXT()
);

DROP TABLE IF EXISTS `camagru`.likes;
CREATE TABLE `camagru`.likes (
    PRIMARY KEY (imageid, username),
    FOREIGN KEY(imageid) REFERENCES images(imageid) ON DELETE CASCADE,
    FOREIGN KEY(username) REFERENCES users(username) ON DELETE CASCADE
);

