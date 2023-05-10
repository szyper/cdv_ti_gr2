<?php
	session_start();
	//print_r($_POST);
	$error = 0;
	foreach ($_POST as $key => $value){
		//echo "$key: $value<br>";
		if (empty($value)){
			//echo "$key<br>";
			//echo "error";
			$_SESSION["error"] = "Wypełnij wszystkie pola!";
			echo "<script>history.back();</script>";
			exit();
		}
	}

	if (!isset($_POST["term"])){
		$_SESSION["error"] = "Wypełnij regulamin!";
		$error = 1;
	}

	if ($_POST["pass1"] != $_POST["pass2"]){
		$_SESSION["error"] = "Hasła są różne!";
		$error = 1;
	}

	if ($_POST["email1"] != $_POST["email2"]){
		$_SESSION["error"] = "Adresy email są różne!";
		$error = 1;
	}

	if ($error != 0){
		echo "<script>history.back();</script>";
		exit();
	}

	$pass = password_hash($_POST["pass1"], PASSWORD_ARGON2ID);
	//echo $pass;

	require_once "./connect.php";
//	$sql = "INSERT INTO `users` (`id`, `city_id`, `firstName`, `lastName`, `email`, `password`, `birthday`) VALUES (NULL, '$_POST[city_id]', '$_POST[firstName]', '$_POST[lastName]', '$_POST[email1]', '$pass', '$_POST[birthday]');";

$stmt = $conn->prepare("INSERT INTO `users` (`city_id`, `firstName`, `lastName`, `email`, `password`, `birthday`) VALUES ( ?, ?, ?, ?, ?, ?);");

$stmt->bind_param('ssssss', $_POST["city_id"], $_POST["firstName"], $_POST["lastName"], $_POST["email1"], $pass, $_POST["birthday"]);

$stmt->execute();

//echo $stmt->affected_rows;
	if ($stmt->affected_rows){
		header("location: ../pages/login.php?addUser=1");
	}else{
		header("location: ../pages/login.php?addUser=0");
	}