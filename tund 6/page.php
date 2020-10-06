<?php
  
  //käivatame sessiooni
  session_start();
  
  require("../../../config.php");
  require("fnc_common.php");
  require("fnc_user.php");
 
 
  $username = "";
  $fulltimenow = date ("d.m.Y H:i:s");
  $timenow = date ("H:i:s");
  $hournow = date ("H");
  $daynow = date ("d");
  $monthnow = date("m");
  $yearnow = date("Y");
  $partofday = "lihtsalt aeg";
  $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $weekdaynow = date("N");
  //echo $weekdaynow;
  $monthnow = date("m");
  
  if($hournow < 6) {
	$partofday = "uneaeg";
  }// enne 6
  if($hournow >= 8 and $hournow < 11){
	  $partofday = "õppimise aeg";
  }
  if($hournow >= 12 and $hournow < 13){
	$partofday = "lõuna aeg";
  }
  if($hournow >= 14 and $hournow < 17){
	$partofday = "töö aeg";
  }
  if($hournow >= 18 and $hournow < 20){
	$partofday = "vaba aeg";
  }
  if($hournow > 20) {
	$partofday = "õhtune aeg";
  }
  
 
//vaatame semestri kulgemist
  $semesterstart = new DateTime("2020-8-31");
  $semesterend = new DateTime("2020-12-13");
  $semesterduration = $semesterstart->diff($semesterend);
  $semesterdurationdays = $semesterduration->format("%r%a");
  
  $today = new DateTime("now");
  $fromsemesterstart = $semesterstart->diff($today);
  //saime aja erinevuse objektina, seda niisama näidata ei saa
  $fromsemesterstartdays = $fromsemesterstart->format("%r%a");
  $semesterpercentage = 0;
  
  
  
  $semesterinfo = "Semester kulgeb vastavalt akadeemilisele kalendrile.";
  if($semesterstart > $today){
	  $semesterinfo = "Semester pole veel peale hakanud!";
  }
  if($fromsemesterstartdays === 0){
	  $semesterinfo = "Semester algab täna!";
  }
  if($fromsemesterstartdays > 0 and $fromsemesterstartdays < $semesterdurationdays){
	  $semesterpercentage = ($fromsemesterstartdays / $semesterdurationdays) * 100;
	  $semesterinfo = "Semester on täies hoos, kestab juba " .$fromsemesterstartdays ." päeva, läbitud on " .$semesterpercentage ."%.";
  }
  if($fromsemesterstartdays == $semesterdurationdays){
	  $semesterinfo = "Semester lõppeb täna!";
  }
  if($fromsemesterstartdays > $semesterdurationdays){
	  $semesterinfo = "Semester on läbi saanud!";
  }
  
    //annan ette lubatud pildivormingute loedi
  $picfiletypes = ["image/jpeg", "image/png"]; 
  //loeme piltide kataloogi sisu ja näitame pilte
  //$allfiles = scandir("../vp_pics/");
  $allfiles = array_slice(scandir("../vp_pics/"), 2);
  //var_dump =($allfiles);
  //$picfiles = array_slice ($allfiles, 2);
  $picfiles = [];
  //var_dump($picfiles);
  foreach($allfiles as $thing){
	$fileinfo = getImagesize("../vp_pics/" .$thing);
	if(in_array($fileinfo["mime"], $picfiletypes) == true){
		array_push($picfiles, $thing);
	}
  }
  
  
  
  
  //paneme kõik pildid ekraanile
  $piccount = count($picfiles);
  //$picnum = rand(0, 3);
  //$i = $i + 1;
  //$i ++;
  //$i +=2;
  $imghtml = "";
  //<img src="../vp_pics/failinimi.png" alt="tekst">
 

  //siin peab kuidagi selle random sisse panema

  /*for($i = 0; $i < $piccount; $i ++){
	  $imghtml .= '<img src="../vp_pics/' .$picfiles[$i] .'" ';
	  $imghtml .= 'alt="Tallinna Ülikool">';
  }*/
   $imghtml .= '<img src="../vp_pics/' .$picfiles[mt_rand(0, ($piccount - 1))] .'" ';
   $imghtml .= 'alt="Tallinna Ülikool">';
  
  $email = "";
  
  $emailerror = "";
  $passworderror = "";
  $notice = "";
  
  if(isset($_POST["submituserdata"])){
	  if (!empty($_POST["emailinput"])){
		//$email = test_input($_POST["emailinput"]);
		$email = filter_var($_POST["emailinput"], FILTER_SANITIZE_EMAIL);
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		} else {
		  $emailerror = "Palun sisesta õige kujuga e-postiaadress!";
		}		
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
	  
	  if(empty($emailerror) and empty($passworderror)){
		  //echo "Juhhei!" .$email .$_POST["passwordinput"];
		  $notice = signin($email, $_POST["passwordinput"]);
	  }
  }

  
  
  require("header.php");
  
?>
	  

	<img src="../img/vp_banner.png" alt="Veebiprogrameerimise kursuse bänner">
	<h1><?php echo $username; ?></h1>
	<p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>See konkreetne leht on loodud veebiprogrameerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli<a/> Digitehnoloogia instituudis</p> 
	
	<ul>	

		<li><a href="addnewuser.php"> Kasutaja tegemine<a/></li>
	</ul>
	
	<hr>
  <h3>Logi sisse</h3>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="emailinput">E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
	  <br>
	  <label for="passwordinput">Salasõna:</label>
	  <br>
	  <input name="passwordinput" id="passwordinput" type="password"><span><?php echo $passworderror; ?></span>
	  <br>
	  <br>
	  <input name="submituserdata" type="submit" value="Logi sisse"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
  </form>
  <hr>
	
	
	<p>Lehe avamise hetk: <?php echo $weekdaynameset [$weekdaynow - 1].", ".$daynow.". " .$monthnameset [$monthnow - 1]." " .$yearnow.", kell " .$timenow; ?>.</p>
	<p><?php echo "Praegu on " .$partofday ."."; ?></p>
	<p><?php echo $semesterinfo; ?></p>
	<hr>
	<?php echo $imghtml; ?></p>
	<hr>
	



<body>
</html>