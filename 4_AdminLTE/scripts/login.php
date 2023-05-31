<?php
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
	}

	require_once "./connect.php";


