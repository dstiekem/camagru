<?php
    function pswdsub($passwordsub) 
    {
        $hashed_password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        return $hashed_password;
    }
?>
