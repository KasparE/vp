<?php
  //var_dump($_POST);
  require("../../../config.php");
  require("usesession.php");
  $database = "if20_carleen_1";
  //kui on idee sisestatud ja nupp vajutatud, salvestame selle andmebaasi
  

    
  //loen lehele kõik olemasolevad mõtted
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  $stmt = $conn->prepare("SELECT idea FROM myideas");
  echo $conn->error;
  //seome tulemuse muutujaga
  $stmt->bind_result($ideafromdb);
  $stmt->execute();
  $ideahtml = "";
  while($stmt->fetch()){
	  $ideahtml .= "<p>" .$ideafromdb ."</p>";
  }
  $stmt->close();
  $conn->close();
  
  
  $username = "Kaspar Eensalu";


  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>See konkreetne leht on loodud veebiprogrammeerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  
  
  <p><a href="?logout=1">Logi välja!</a></p>
  <ul>
	<li><a href="home.php"> Avaleht<a/></li>
  </ul>
  <hr>
  <?php echo $ideahtml; ?>


<body>
</html>