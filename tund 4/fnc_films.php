<?php
	$database = "if20_carleen_1";
	//var_dump($GLOBALS);
	//funktsioon mis loeb kõikide filmide infot
	
	function readfilms(){
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	  //$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
	  $stmt = $conn->prepare("SELECT * FROM film");
	  echo $conn->error;
	  //seome tulemuse muutujaga
	  $stmt->bind_result($titlefromdb, $yearfromdb, $durationfromdb, $genrefromdb, $studiofromdb, $directorfromdb);
	  $stmt->execute();
	  
	    $filmhtml = "\t <ol> \n";
	    while($stmt->fetch()){
			  $filmhtml .= "\t \t <li>" .$titlefromdb ."\n";
			  $filmhtml .= "\t \t \t <ul> \n";
			  $filmhtml .= "\t \t \t \t <li>Valmimisaasta: " .$yearfromdb ."</li> \n";
			  $filmhtml .= "\t \t \t \t <li>Kestus minutites: " .$durationfromdb ." minutit</li> \n";
			  $filmhtml .= "\t \t \t \t <li>Žanr: " .$genrefromdb ."</li> \n";
			  $filmhtml .= "\t \t \t \t <li>Tootja/stuudio: " .$studiofromdb ."</li> \n";
			  $filmhtml .= "\t \t \t \t <li>Lavastaja: " .$directorfromdb ."</li> \n";
			  $filmhtml .= "\t \t \t </ul> \n";
			  $filmhtml .= "\t \t </li> \n";
	  }
	  $filmhtml .= "\t </ol> \n";
	  
	  $stmt->close();
	  $conn->close();
	  return $filmhtml;
	} //readfilms lõppeb
	

	function savefilm($titleinput, $yearinput, $durationinput, $genreinput, $studioinput, $directorinput){
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
	echo $conn->error;
	$stmt->bind_param("siisss", $titleinput, $yearinput, $durationinput, $genreinput, $studioinput, $directorinput);
	$stmt->execute();
	$stmt->close();
	$conn->close();
	
  }//savefilm lõppeb
	