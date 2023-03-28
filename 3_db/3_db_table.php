<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../style/table.css">
</head>
    <title>Użytkownicy</title>
		<h4>Użytkownicy z db</h4>

	<?php
		require_once "../scripts/connect.php";
		$sql = "SELECT u.id, u.firstName, u.lastName, u.birthday, c.city FROM `users` u INNER JOIN  `cities` c ON `u`.`city_id` = `c`.`id`;;";
		$result = $conn->query($sql);

    if (isset($_GET["deleteUser"])){
      if ($_GET["deleteUser"] == 0){
        echo "Nie udało się usunąć rekordu!<hr>";
      }else{
        echo "Usunięto rekord o id=$_GET[deleteUser]<hr>";
      }
    }

  echo <<< TABLEUSERS
    <table>
      <tr>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Data urodzenia</th>
        <th>Rok urodzenia</th>
        <th>Miasto</th>
      </tr>
TABLEUSERS;

//  echo $result->num_rows;
  if ($result->num_rows == 0){
    echo "<tr><td colspan='5'>Brak rekordów do wyświetlenia</td></tr>";
  }else{
	  while($user = $result->fetch_assoc())
	  {
		  $year = substr($user["birthday"], 0, 4);
		  echo <<< TABLEUSERS
			<tr>
        <td>$user[firstName]</td>
        <td>$user[lastName]</td>
        <td>$user[birthday]</td>
        <td>$year</td>
        <td>$user[city]</td>
        <td><a href="../scripts/delete_user.php?userId=$user[id]">Usuń</a></td>
      </tr>
TABLEUSERS;

	  }
  }

  echo "</table>";
	?>

<body>

</body>
</html>