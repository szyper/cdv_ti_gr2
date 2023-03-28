<?php
//	print_r($_GET);
//	var_dump($_GET);

//echo $_GET["userId"];
require_once "./connect.php";
//$sql = "DELETE FROM users WHERE `users`.`id` = 1";
//$sql = "DELETE FROM users WHERE `users`.`id` = $_GET[userId]";
//$sql = "DELETE FROM users WHERE `users`.`firstName` = 'Janusz'";
$sql = "DELETE FROM users WHERE `users`.`id` = $_GET[userId]";
$conn->query($sql);
//echo $conn->affected_rows;

if ($conn->affected_rows == 0){
	$deleteUser = 0;
}else{
	$deleteUser = $_GET["userId"];
}

header("location: ../3_db/3_db_table.php?deleteUser=$deleteUser");