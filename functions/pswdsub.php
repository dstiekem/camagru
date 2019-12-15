<?php
    function pswdsub($passwordsub) 
    {
        $hashed_password = password_hash($passwordsub, PASSWORD_DEFAULT);
        return $hashed_password;
    }
?>
