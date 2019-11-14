<?php
require (dirname(__FILE__) . '/functions/pagination.php');
pagination(45, 20, 1, 'http://localhost:8080/mvc2/page');
/*Usage:
pagination(
   total amount of item/rows/whatever,
   limit of items per page,
   current page number,
   url
);
Example:*/
?>
<p class="pagination">
   <strong>Pages:</strong>
   <a href="http://localhost:8080/mvc2/page/1.php"><strong>1</strong></a>,
   <a href="http://localhost:8080/mvc2/page/2.php">2</a>,
   <a href="http://localhost:8080/mvc2/page/3.php">3</a>
   | <a href="http://localhost:8080/mvc2/page/2.php">Next</a>
</p>