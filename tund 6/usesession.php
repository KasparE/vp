<?php
 
  session_start();
 
  
  //kas on sisse logitud
  if(!isset($_SESSION["userid"])){
		//jõuga suunatakse isselogimise legele
		header("Location: page.php");
		exit();
  }
  
  //logimae välja
  if(isset($_GET["logout"])){
	  //lõpetame sessiooni
	  session_destroy();
	  //jõuga suunatakse sisselogimise lehele
	  header("Location: page.php");
	  exit();
  }
?>