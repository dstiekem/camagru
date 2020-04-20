<?php
if(!isset($_SESSION['uid']))
{
    session_start();
}
require (dirname(__FILE__) . '/config/database.php');
echo json_encode($inserted['imagepath']); 