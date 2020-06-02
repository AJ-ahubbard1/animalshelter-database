<!DOCTYPE html>
<html lang="en">
<head>
<body>
<?php	
	$employeeid = $_GET['rowid'];
	$employeename =$_GET['name'];
		#echo '<h1>'.$animalid.'</h1>';
echo '<ul>';
echo '<form name="insert" action="timecard_insert1.php?rowid='.$employeeid.'&name='.$employeename.'" method="POST" >';
echo '<li>Current Date: (YYYY-MM-DD)</li><li><input type="text" name="cur_date" /></li>';
echo '<li></li>Start Time:<li><input type="text" name="start_time" /></li>';
echo '<li>End Time:</li><li><input type="text" name="end_time" /></li>';
echo '<li>rate:</li><li><input type="text" name="rate" /></li>';
echo '<li>Shelter ID:</li><li><input type="text" name="shelter_id" /></li>';
echo '<li><input type="submit" /></li>';

if ($_POST[shelter_id] != '') {
		$db = pg_connect("host=localhost port=5432 dbname=animalshelter user=Joey password=fluffy");
		$query = "select ins_timecard('".$employeename."', '$_POST[cur_date],', '$_POST[start_time]', '$_POST[end_time]', $_POST[rate], ".$employeeid.", $_POST[shelter_id])";
		$result = pg_query($query);
		echo '<h1>'.$query.'</h1>';
		echo "<script>window.location = 'employees.php'</script>";
	}
?>
</body>
</head>
</html>
