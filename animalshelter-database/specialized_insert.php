<!DOCTYPE html>
<html lang="en">
<head>
<body>
<?php	
	$animalid = $_GET['rowid'];
		//echo '<h1>'.$animalid.'</h1>';
echo '<ul style="list-style-type:none;margin:0;padding:0;">';
echo '<form name="insert" action="specialized_insert.php?rowid='.$animalid.'" method="POST" >';
echo '<li>Care type:</li><li><input type="text" name="ctype" required autofocus></li>';
echo '<li>Description:</li><li><input type="text" name="description"></li>';
echo '<li>Amount</li><li><input type="number" name="amount" required></li>';
echo '<li>Frequency</li><li><input type="number" name="frequency" required></li>';
echo '<li>time units</li><li><input type="text" name="time_units" required></li>';
echo '<li><input type="submit" /></li>';
echo '</form>';
echo '</ul>';

	$description = ''.$_POST['description'];
	if ($description != '')
		$description = '\''.$description.'\'';
	else
		$description = 'NULL';
	
	if ($_POST[ctype] != '') {
		$db = pg_connect("host=localhost port=5432 dbname=animalshelter user=Joey password=fluffy");
		$query = "select ins_specializedcare('$_POST[ctype]',".$description.",$_POST[amount],$_POST[frequency],'$_POST[time_units]',".$animalid .")";
		//echo '<h2>'.$query.'</h2>';
		$result = pg_query($query);
		echo "<script>window.location = 'animals.php'</script>";
	}
?>
</body>
</head>
</html>
