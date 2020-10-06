<?php
 
  require("usesession.php");
  require("header.php");
  
  //$username = "Kaspar Eensalu";
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
  
?>
	  

	<img src="../img/vp_banner.png" alt="Veebiprogrameerimise kursuse bänner">
	<h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
	<p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>See konkreetne leht on loodud veebiprogrameerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli<a/> Digitehnoloogia instituudis</p> 
	
	<p><a href="?logout=1">Logi välja!</a></p>
	
	
	<ul>	
		<li><a href="add_ideas">Sisesta siin oma mõte!<a/></li>
		<li><a href="list_ideas.php"> Loe siin mõtteid!<a/></li>
		<li><a href="add_films.php">Filmide list </a></li>
		<li><a href="list_film.php"> Loe siin filme!<a/></li>
		<li><a href="addnewuser.php"> Kasutaja<a/></li>
		<li><a href="page.php"> Page<a/></li>
		<li><a href="userprofile.php">Minu kasutajaprofiil</a></li>
	</ul>
	
	
	<p>Lehe avamise hetk: <?php echo $weekdaynameset [$weekdaynow - 1].", ".$daynow.". " .$monthnameset [$monthnow - 1]." " .$yearnow.", kell " .$timenow; ?>.</p>
	<p><?php echo "Praegu on " .$partofday ."."; ?></p>
	<p><?php echo $semesterinfo; ?></p>
	<hr>
	<?php echo $imghtml; ?></p>
	<hr>
	



<body>
</html>