<?php
function RandomString($len, $charset='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $characters = '';
    $randstring = '';
    for ($i = 0; $i < $len; $i++) {
        $randstring .= $charset[rand(0, strlen($charset))];
    }
    return $randstring;
}
?>