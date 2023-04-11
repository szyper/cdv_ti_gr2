<?php
  session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>

</body>
</html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../style/table.css">
</head>
<body>
    <title>Użytkownicy</title>
		<h4>Użytkownicy z db cdv_gr2</h4>

	<?php
		require_once "../scripts/connect.php";
		$sql = "SELECT u.id, u.firstName, u.lastName, u.birthday, c.city FROM `users` u INNER JOIN  `cities` c ON `u`.`city_id` = `c`.`id`;";
		$result = $conn->query($sql);

    if (isset($_GET["deleteUser"])){
      if ($_GET["deleteUser"] == 0){
        echo "Nie udało się usunąć rekordu!<hr>";
      }else{
        echo "Usunięto rekord o id=$_GET[deleteUser]<hr>";
      }
    }

    if (isset($_GET["addUser"])){
      if ($_GET["addUser"] == 1){
        echo "<h4>Prawidłowo dodano rekord</h4>";
      }else{
	      echo "<h4>Użytkownik nie został dodany prawidłowo!</h4>";
      }
    }

    if (isset($_SESSION["error"])){
      echo '<br>'.$_SESSION["error"].'<br><br>';
      unset($_SESSION["error"]);
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
        <td><a href="./5_db_table_delete_add_update.php?updateId=$user[id]">Aktualizuj</a></td>
      </tr>
TABLEUSERS;

	  }
  }

  echo "</table>";

//dodawanie użytkownika

  if (isset($_GET["addUser"])){
    echo <<< ADDUSERFORM
      <h4>Dodawanie użytkownika</h4>
      <form action="../scripts/add_user.php" method="post">
        <input type="text" name="firstName" placeholder="Podaj imię"><br><br>
        <input type="text" name="lastName" placeholder="Podaj nazwisko"><br><br>
        <input type="date" name="birthday"> Data urodzenia<br><br>
<!--        <input type="number" name="city_id" placeholder="Podaj id miasta"><br><br>-->
        <select name="city_id">
ADDUSERFORM;
        $sql = "SELECT id, city FROM cities";
        $result = $conn->query($sql);
        while($city = $result->fetch_assoc()){
          echo "<option value=\"$city[id]\">$city[city]</option>";
        }
	  echo <<< ADDUSERFORM
        </select><br><br>
        <input type="checkbox" name="term"> Regulamin<br><br>
        <input type="submit" value="Dodaj użytkownika">
      </form>
ADDUSERFORM;
  }else{
    echo "<hr><a href=\"./5_db_table_delete_add_update.php?addUser=1\">Dodaj użytkownika</a>";
  }

	//aktualizacja użytkownika

	if (isset($_GET["updateId"])){
    $sql = "SELECT * FROM users WHERE users.id=$_GET[updateId]";
    $_SESSION["updateUserId"] = $_GET["updateId"];
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    //echo $user["firstName"];
    //echo $user["city_id"];
		echo <<< UPDATEUSERFORM
      <h4>Aktualizacja użytkownika</h4>
      <form action="../scripts/update_user.php" method="post">
        <input type="text" name="firstName" placeholder="Podaj imię" value="$user[firstName]"><br><br>
        <input type="text" name="lastName" placeholder="Podaj nazwisko" value="$user[lastName]"><br><br>
        <input type="date" name="birthday"  value="$user[birthday]"> Data urodzenia<br><br>
<!--        <input type="number" name="city_id" placeholder="Podaj id miasta"><br><br>-->
        <select name="city_id">
UPDATEUSERFORM;
		$sql = "SELECT id, city FROM `cities`";
		$result = $conn->query($sql);
		while($city = $result->fetch_assoc()){
      if ($city["id"] == $user["city_id"]){
	      echo "<option value=\"$city[id]\" selected>$city[city]</option>";
      }else{
	      echo "<option value=\"$city[id]\">$city[city]</option>";
      }
		}
		echo <<< UPDATEUSERFORM
        </select><br><br>
        <input type="checkbox" name="term"> Regulamin<br><br>
        <input type="submit" value="Aktualizuj użytkownika">
      </form>
UPDATEUSERFORM;
	}

  $conn->close();
	?>

</body>
</html>