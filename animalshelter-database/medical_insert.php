<!DOCTYPE html>
<html lang="en">
<head>
<body>
<?php	
	$animalid = $_GET['rowid'];
//echo '<h1>'.$animalid.'</h1>';
echo '<ul style="list-style-type:none;margin:0;padding:0;">';
echo '<form name="insert" action="medical_insert.php?rowid='.$animalid.'" method="POST" >';
echo '<li>Record Date:</li><li><input type="date" name="rec_date" required autofocus></li>';
echo '<li>Weight:</li><li><input type="text" name="weight" required></li>';
echo '<li>Spayed/Neutered? (Y/N):</li><li><input type="text" name="spayed_neutered" required maxlength="1" size="1"></li>';
echo '<li>condition:</li><li><input type="text" name="condition" /></li>';
echo '<li>treatments:</li><li><input type="text" name="treatments" /></li>';
echo '<li>vaccinations:</li><li><input type="text" name="vaccinations" /></li>';
echo '<li>allergies:</li><li><input type="text" name="allergies" /></li>';
echo '<li><input type="submit" /></li>';

/*insert into medicalrecord (rec_date, weight, spayed_neutered, condition, treatments, vaccinations, allergies, animal_id) values ('2004-08-20', 40.16, 'Y', NULL, NULL, NULL, NULL, 13);*/

echo '</form>';
echo '</ul>';
	$cond = ''.$_POST['condition'];
	$treatments = ''.$_POST['treatments'];
	$vaccinations = ''.$_POST['vaccinations'];
	$allergies = ''.$_POST['allergies']; 
	if ($cond != '')
		$cond = '\''.$cond.'\'';
	else
		$cond = 'NULL';
	if ($treatments != '')
		$treatments = '\''.$treatments.'\'';
	else
		$treatments = 'NULL';
	if ($vaccinations != '')
		$vaccinations = '\''.$vaccinations.'\'';
	else
		$vaccinations = 'NULL';
	if ($allergies != '')
		$allergies = '\''.$allergies.'\'';
	else
		$allergies = 'NULL';
	if ($_POST[rec_date] != '') {
		$db = pg_connect("host=localhost port=5432 dbname=animalshelter user=Joey password=fluffy");
		$query = "select ins_medicalrecord('$_POST[rec_date]',$_POST[weight], '$_POST[spayed_neutered]',".$cond.",".$treatments.",".$vaccinations.",".$allergies. "," .$animalid .")";
		//echo '<h2>'.$query.'</h2>';
		$result = pg_query($query);
		echo "<script>window.location = 'animals.php'</script>";
	}
?>
</body>
</head>
</html>
