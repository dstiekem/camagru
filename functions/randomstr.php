<?php
function RandomString($len, $charset)
{
    $characters = '';
    $randstring = '';
    for ($i = 0; $i < $len; $i++) {
        $randstring .= $charset[rand(0, strlen($charset) - 1)];
    }
    return $randstring;
}
?>