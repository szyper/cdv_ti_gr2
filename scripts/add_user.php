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

	if ($error != 0){
		echo "<script>history.back();</script>";
		exit();
	}

	//echo "ok";
	require_once "./connect.php";
	$sql = "INSERT INTO `users` (`id`, `city_id`, `firstName`, `lastName`, `birthday`) VALUES (NULL, '$_POST[city_id]', '$_POST[firstName]', '$_POST[lastName]', '$_POST[birthday]');";
	$conn->query($sql);
	//echo $conn->affected_rows;
	if ($conn->affected_rows){
		header("location: ../3_db/4_db_table_delete_add.php?addUser=1");
	}else{
		header("location: ../3_db/4_db_table_delete_add.php?addUser=0");
	}