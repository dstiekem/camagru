
<!DOCTYPE html>
<html>
<head>
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 10px;
  overflow: hidden;
  background-color: #17141d;
}

li a{
  float: right;
}

li a {
  display: block;
  color: grey;
  text-align: center;
  font-family: sans-serif;
  font-weight: bold;
  padding: 10px;
  text-decoration: none;
}

li a:hover {
  background-color: #07050955;
  background: linear-gradient(to right,#ff8d66ff,#008f62ff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
</style>
</head>
<body>

<div style="background-color: #100e17; width: 100%; height: 500px;">
<ul class="">
  
  <li><div><a href="#newimage"style="float: right;">NEW IMAGE</a></div></li>
  <li><div><a href="#logout"style="float: right;">LOG OUT</a></div></li>
  <li><div><a href="#settings"style="float: right;">SETTINGS</a></div></li>
  <li><a href="#home"><img src="/home/stieky/Documents/camagru/g1280-7.png" style="width: 43%; height: auto; float: left; text-align: center; padding-left: 0px; padding-top: 2px;"></a></li>
</ul>
</div>

</body>
</html>
<?php

echo "logged out!";
//destroy user login session stuff
?>