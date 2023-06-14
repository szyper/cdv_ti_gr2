<?php
	session_start();
	//print_r($_POST);

	$errors = [];
	foreach ($_POST as $key => $value){
		if (empty($value)){
			$errors[] = "Pole <b>$key</b> musi być wypełnione";
		}
	}

	//print_r($errors);

	if (!empty($errors)){
		$error_message = implode("<br>", $errors);
		//echo $error_message;
		header("location: ../pages/login.php?error=".urlencode($error_message));
		exit();
	}

	require_once "./connect.php";
	$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
	$stmt->bind_param("s", $_POST["email"]);
	if ($stmt->execute()){
		$result = $stmt->get_result();
		//echo $result->num_rows;
		if ($result->num_rows == 1){
			//echo "email istnieje";
			$user = $result->fetch_assoc();
			//print_r($user);
			if (password_verify($_POST["pass"], $user["password"])){
				$_SESSION["logged"]["firstName"] = $user["firstName"];
				$_SESSION["logged"]["lastName"] = $user["lastName"];
				$_SESSION["logged"]["session_id"] = session_id();
				//echo session_id();
				$_SESSION["logged"]["role_id"] = $user["role_id"];


				//print_r($_SESSION["logged"]);
				header("location: ../pages/logged/logged.php");


			}else{
				$_SESSION["error"] = "Błędny login lub hasło!";
				echo "<script>history.back();</script>";
				exit();
			}
		}else{
			$_SESSION["error"] = "Błędny login lub hasło!";
			echo "<script>history.back();</script>";
			exit();
		}
	}

