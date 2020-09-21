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
  $picfiles = array_slice ($allfiles, 2);
  //var_dump($picfiles);
  foreach($allfiles as $thing){
	$fileinfo = getImagesize("../vp_pics/" .$thing);
	if(in_array($fileinfo["mime"], $picfiletypes) == true){
		array_push($picfiles, $thing);
	}
  }
  
  
  
  
  //paneme kõik pildid ekraanile
  $piccount = count($picfiles);
  $picnum = rand(0, 3);
  //$i = $i + 1;
  //$i ++;
  //$i +=2;
  $imghtml = "";
  //<img src="../vp_pics/failinimi.png" alt="tekst">
 

  //siin peab kuidagi selle random sisse panema

  for($i = 0; $i < $piccount; $i ++){
	  $imghtml .= '<img src="../vp_pics/' .$picfiles[$i] .'" ';
	  $imghtml .= 'alt="Tallinna Ülikool">';
  }
  require("header.php");
?>
	  


	<img src="../img/vp_banner.png" alt="Veebiprogrameerimise kursuse bänner">
	<h1><?php echo $username; ?></h1>
	<p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>See konkreetne leht on loodud veebiprogrameerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli<a/> Digitehnoloogia instituudis</p> 
	<p>Lehe avamise hetk: <?php echo $weekdaynameset [$weekdaynow - 1].", ".$daynow.". " .$monthnameset [$monthnow - 1]." " .$yearnow.", kell " .$timenow; ?>.</p>
	<p><?php echo "Praegu on " .$partofday ."."; ?></p>
	<p><?php echo $semesterinfo; ?></p>
	<hr>
	<?php echo $imghtml; ?></p>
	<hr>
	<p>Sisesta <a href="http://greeny.cs.tlu.ee/~carleen/vp/tund 3/Home_mote"> siin<a/> oma mõte!</p>
	<p>Loe <a href="http://greeny.cs.tlu.ee/~carleen/vp/tund%203/Home_lugeda.php"> siin<a/> erinevaid mõtteid!</p>



<body>
</html>