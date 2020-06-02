<!DOCTYPE html>
<html lang="en">
<head>
<body>
<form name="insert" action="animal_insert.php" method="POST" >
  <label for="name">Name of Animal:</label><br>
	<input type="text" name="name" autofocus required><br>
	<label for="dob">DOB:</label><br>
	<input type="date" name="dob" required><br>
  <input type="radio" id="male" name="sex" value="M" required>
  <label for="male">Male</label><br>
  <input type="radio" id="female" name="sex" value="F">
  <label for="female">Female</label><br>
  <label for="color">Color:</label><br>
	<input type="text" name="color" multiple required><br>
  <label for="breed">Breed:</label><br>
	<input type="text" name="breed" required><br>
  <label for="species">Species:</label><br>
	<input type="text" name="species" required><br>
  <label for="description">Description:</label><br>
	<input type="text" name="description"><br>
  <label for="shelter_id">Shelter_ID:</label><br>
	<input type="number" name="shelter_id" min="1" max="10" required><br>
<input type="submit" >

</form>
</ul>
<?php 
	if ($_POST[name] != '') {
		$db = pg_connect("host=localhost port=5432 dbname=animalshelter user=Joey password=fluffy");
		$query = "select ins_animal('$_POST[name]','$_POST[dob]', '$_POST[sex]','$_POST[color]','$_POST[breed]',
		'$_POST[species]','$_POST[description]','$_POST[shelter_id]')";
		$result = pg_query($query);
		echo "<script>window.location = 'animals.php'</script>";
	}
?>
</body>
</head>
</html>
