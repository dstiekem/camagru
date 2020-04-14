<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
$thisuser = $_SESSION['uid'];
require (dirname(__FILE__) . '/config/database.php');
if(isset($_POST["`imageid`"]))
{
    echo "sent image id";
}
if(isset($_POST["`user_id`"]))
{
    echo "sent user id";
}
?>