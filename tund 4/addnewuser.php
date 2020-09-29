<?php
 require("../../../config.php");
 require("fnc_common.php");
 
 $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
 
 $firstname= "";
 $lastname = "";
 $gender = "";
 $email = "";

 $firstnameinput = "";
 $lastnameinput = "";
 $genderinput = "";
 $emailinput = "";
 $passwordinput = "";
 $confirmpasswordinput = "";
 
 $notice = "";
 
 $storeinfo = "";
 
  // kui klikiti submit, siis...
  
  // if(! $a) is the same as if($a == false)
	
  if(isset($_POST["submituserdata"])){
	  
	  if (!empty($_POST["firstnameinput"])){
		$firstname = test_input($_POST["firstnameinput"]);
	  } else {
		  $firstnameerror = "Palun sisesta eesnimi!";
	  }
	  if (!empty($_POST["lastnameinput"])){
		$lastname = test_input($_POST["lastnameinput"]);
	  } else {
		  $lastnameerror = "Palun sisesta perekonnanimi!";
	  }
	  
	  if(isset($_POST["genderinput"])){
		$gender = intval($_POST["genderinput"]);
		//$gender = $_POST["genderinput"];
	  } else {
		  $gendererror = "Palun märgi sugu!";
	  }
      if (!empty($_POST["emailinput"])){
		$email = test_input($_POST["emailinput"]);
	  } else {
		  $emailerror = "Palun sisesta e-postiaadress!";
	  }
	  
	  if (empty($_POST["passwordinput"])){
		$passworderror = "Palun sisesta salasõna!";
	  } else {
		  if(strlen($_POST["passwordinput"]) < 8){
			  $passworderror = "Liiga lühike salasõna (sisestasite ainult " .strlen($_POST["passwordinput"]) ." märki).";
		  }
	  }
	  
	  if (empty($_POST["confirmpasswordinput"])){
		$confirmpassworderror = "Palun sisestage salasõna kaks korda!";  
	  } else {
		  if($_POST["confirmpasswordinput"] != $_POST["passwordinput"]){
			  $confirmpassworderror = "Sisestatud salasõnad ei olnud ühesugused!";
		  }
	  }
	   if(empty($firstnameerror) and empty($lastnameerror) and empty($gendererror) and empty($emailerror) and empty($passworderror) and empty($confirmpassworderror)){
		
		
		$notice = "Kõik korras!";
		$firstname= "";
		$lastname = "";
		$gender = "";
		$email = "";
		}
	  
  }
	

	  

	
	
  
  
$username = "Kaspar Eensalu";

?>

<img src="../img/vp_banner.png" alt="Veebiprogrameerimise kursuse bänner">
	<h1><?php echo $username; ?></h1>
	<p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>See konkreetne leht on loodud veebiprogrameerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli<a/> Digitehnoloogia instituudis</p> 
	
	<ul>
	<li> <a href="home.php"> Avaleht<a/></li>
	</ul>
  
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="firstnameinput">Eesnimi:</label>
	<br>
	<input type="text" name="firstnameinput" id="firstnameinput" placeholder="Eesnimi">
	<!--<span><?php echo $firstnameerror; ?></span>-->
	<br>
	<br>
	<label for="lastnameinput">Perekonnanimi</label>
	<br>
	<input type="text" name="lastnameinput" id="lastnameinput" placeholder="Perekonnanimi">
	<!--<span><?php echo $lastnameerror; ?></span>-->
	<br>
	<br>
	
    <input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo "checked";} ?>>
	<label for="gendermale">Mees</label>
	<input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo "checked";} ?>>
	<label for="genderfemale">Naine</label>
    
	<!--<span><?php echo $gendererror; ?></span>-->
	<br>
	<br>
	
	<label for="emailinput">email</label>
	<input type="email" name="emailinput" id="emailinput" placeholder="email">
	<!--<span><?php echo $emailerror; ?></span>-->
	<br>
	<label for="passwordinput">Salasõna (min 8 tähemärki):</label>
	<input name="passwordinput" id="passwordinput" type="password"><span><?php echo $passworderror; ?></span>
	<br>
	<br>
	<label for="confirmpasswordinput">Korrake salasõna:</label>
	<br>
	<input name="confirmpasswordinput" id="confirmpasswordinput" type="password"><span><?php echo $confirmpassworderror; ?></span>
	<!--<span><?php echo $passworderror; ?></span>-->
	<br>
	
	<input type="submit" name="submituserdata" value="Salvesta konto info">
  </form>
  <p><?php echo $firstnameerror; ?></p>
  <p><?php echo $lastnameinput; ?></p>
  <p><?php echo $genderinput; ?></p>
  <p><?php echo $emailinput; ?></p>
  <p><?php echo $passwordinput; ?></p>
  <p><?php echo $confirmpasswordinput; ?></p>
  
</body>
</html>





