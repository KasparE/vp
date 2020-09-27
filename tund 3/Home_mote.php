<?php
  //var_dump($_POST);
  require("../../../config.php");
  $database = "if20_carleen_1";
  //kui on idee sisestatud ja nupp vajutatud, salvestame selle andmebaasi
  
  if(isset($_POST["ideasubmit"]) and !empty($_POST["ideainput"])){
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
	  //valmistan ette SQL käsu
	  $stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES(?)");
	  echo $conn->error;
	  //seome käsuga päris andmed
	  //i- integer, d- decimal, s- string
	  $stmt ->bind_param("s", $_POST["ideainput"]);
	  $stmt ->execute();
	  echo $stmt->error;
	  $stmt ->close();
	  $conn ->close();
  }
  
  
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

	<form method="POST">
		<label>Sisesta oma pähe tulnud mõte!</label>
			<input type="text" name="ideainput" placeholder="Kirjuta siia mõte!">
			<input type="submit" name="ideasubmit" value="Saada mõte ära!">
	</form>
	<hr>
	<ul>
		<li><a href="http://greeny.cs.tlu.ee/~carleen/vp/tund%203/Home.php"> Siit<a/> saad tagasi koju.
	</ul>

<body>
</html>