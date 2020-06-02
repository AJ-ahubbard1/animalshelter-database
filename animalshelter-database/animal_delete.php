<?php 
  $animalid = ''.$_GET['rowid'];
	if ($animalid != '') {
		$db = pg_connect("host=localhost port=5432 dbname=animalshelter user=Joey password=fluffy");
		$query1 = "select del_medicalrecord('$animalid')";
		$query2 = "select del_specializedcare('$animalid')";
		$query3 = "select del_animal('$animalid')";

		$result1 = pg_query($query1);
		$result2 = pg_query($query2);
		$result3 = pg_query($query3);

	}
	header("location:animals.php");
?>

