<?php
    function userExists()
    {
        $checkuser = $pdo->prepare("SELECT username FROM users WHERE username = :username");
        $checkuser = $pdo->bindParam(':username', $username);
        $checkuser = $pdo->execute();
    }
?>