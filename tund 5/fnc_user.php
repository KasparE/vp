<?php>
$database = "if20_carleen_1";

  function singup($firstname, $lastname, $email, $gender, $birthdate, $password){
	notice = null;
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INto vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
	
	echo $conn->error;
	
	//krüpteerime salasõna
	$options = ["cost" => 12, "salt" => subst (sha1(rand()), 0, 22)];
	$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	
	$stmt->bind_param("sssiss", $firstname, $lastname, $birthdate, $gender, $email, $pwdhash);
	
	if($stmt->execute()){
		$noticce = "ok";
  } else {
	  $notice = $stmt->error;
  }
  
  $stmt->close();
  $conn->close();
  return $notice;
  }
  
  function singin($email, $password){
	notice = null;
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT password FROM vpusers WHERE email = ?)");
	echo $conn->error;
	$stmt->bind_param("s", $email);
	$stmt->bind_result($passwordfromdb);
	
	if($stmt->execute()){
		//kui kõik korras
		if($stmt->fetch()){
			//kui kasutaja leit
			if(password_verify($password, $passwordfromdb)){
				//parool õige
				$stmt->close();
				$conn->close();
				header("Location: home.php");
				exit();
				
				
			} else {
				$notice = "vale salasõna!";
			}	
		} else {
			$notice = "sellist kasutajat (" .$email .") ei leitud!";
		}
	} else {
		//tehniline viga
		$notice = $stmt->error;
	}
	$stmt->close();
	$conn->close();
	return $notice;
  }
  