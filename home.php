<?php
require (dirname(__FILE__) . '/config/database.php');
require (dirname(__FILE__) . '/functions/randomiseimages.php');
?>
<html>
  <head>
  <link rel="stylesheet" type="text/css" href="stylesheet2.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,700,800&display=swap" rel="stylesheet">
  </head>
  <body>
    <div>
<?php
session_start();
$page = "home";
require (dirname(__FILE__) . '/header.php');
?>
  <div id="list">
  </div>  
    </div>
    <button id="nextpage">next</button>
  </body>
  <script>
    var page = 0;
    function getpage() {
      var listdiv = document.getElementById("list");
      var request = new XMLHttpRequest();
      request.addEventListener("load", (e)=>{
          listdiv.innerHTML += request.responseText;
      });
      request.open("GET", "pageofimages.php?page=" + page);
      request.send();
      page++;
    }
     document.getElementById("nextpage").addEventListener("click", getpage);
     getpage();
  </script>
</html>