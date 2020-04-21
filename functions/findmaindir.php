<?php
function findmaindir($serverrequesturi)
{
    $tosub = strrpos($serverrequesturi, "/");
    $requril = strlen($serverrequesturi);
    $offset = $requril - $tosub;
    $page = substr($serverrequesturi, -$offset);
    return($page);
}
?>