<?php
 //var_dump($_POST);
  require("../../../config.php");
  require("fnc_films.php");
  
  //$filmhtml = readfilms();
 
  $username = "Kaspar Eensalu";


  require("header.php");
?>
	<img src="../img/vp_banner.png" alt="Veebiprogrameerimise kursuse bänner">
	<h1><?php echo $username; ?></h1>
	<p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>See konkreetne leht on loodud veebiprogrameerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli<a/> Digitehnoloogia instituudis</p> 
	
	<ul>
	<li> <a href="home.php"> Avaleht<a/></li>
	</ul>
  
	<hr>
	<?php echo readfilms(); ?>
<body>
</html>
