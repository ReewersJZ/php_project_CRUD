<!DOCTYPE html>
<html>
<title>Wypożyczalnia Video</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-teal.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><style>
body {font-family: "Roboto", sans-serif}
.w3-bar-block .w3-bar-item {
  padding: 16px;
  font-weight: bold;
}
</style>
<body>

<nav class="w3-sidebar w3-bar-block w3-collapse w3-card" style="z-index:3;width:250px;" id="mySidebar">
  <a class="w3-bar-item w3-button w3-border-bottom w3-large" href="#"><img src="gfx/Logo.jpg" style="width:80%;"></a>
  <a class="w3-bar-item w3-button w3-hide-large w3-large" href="javascript:void(0)" onclick="w3_close()">Zamknij <i class="fa fa-remove"></i></a>
  <?php include "szablony/menu.php";?>
</nav>

<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

<div class="w3-main" style="margin-left:250px;">

<div id="myTop" class="w3-container w3-top w3-theme w3-large">
  <p><i class="fa fa-bars w3-button w3-teal w3-hide-large w3-xlarge" onclick="w3_open()"></i>
  <span id="myIntro" class="w3-hide">Wypożyczalnia Video</span></p>
</div>

<header class="w3-container w3-theme" style="padding:64px 32px">
  <h1 class="w3-xxxlarge">Wypożyczalnia Video</h1>
</header>

<div class="w3-container" style="padding:32px">
	<?php 
	if (is_array($TRESC)){
		include $TRESC[0];
	}
	else{
		echo $TRESC;
	}
	?>
</div>

<footer class="w3-container w3-theme" style="padding:32px">
  <p>Wszelkie prawa zastrzeżone</p>
</footer>
     
</div>

<script src="js/szablon.js" defer></script>
     
</body>
</html> 