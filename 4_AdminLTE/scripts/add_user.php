<?php
	session_start();
	print_r($_POST);
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
	echo $pass;
	
	//echo "ok";
	require_once "./connect.php";
	$sql = "INSERT INTO `users` (`id`, `city_id`, `firstName`, `lastName`, `email`, `password`, `birthday`) VALUES (NULL, '1', '$_POST[firstName]', '$_POST[lastName]', '$_POST[email1]', '$pass', '$_POST[birthday]');";
	$conn->query($sql);
	//echo $conn->affected_rows;
	if ($conn->affected_rows){
		//header("location: ../3_db/5_db_table_delete_add_update.php?addUser=1");
	}else{
		//header("location: ../3_db/5_db_table_delete_add_update.php?addUser=0");
	}