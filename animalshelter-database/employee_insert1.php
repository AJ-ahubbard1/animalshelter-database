<!DOCTYPE html>
<html lang="en">
<head>
<body>
<?php	
	$animalid = $_GET['rowid'];
		echo '<h1>'.$animalid.'</h1>';
echo '<ul style="list-style-type:none;margin:0;padding:0;">';
echo '<form name="insert" action="employee_insert1.php" method="POST" >';
echo '<li>Street Number: </li><li><input type="number" name="street_no" min="1" required autofocus></li>';
echo '<li>Street Name:</li><li><input type="text" name="street_name" required></li>';
echo '<li>City:</li><li><input type="text" name="city"></li>';
echo '<li>State: (ex: CA, NV)</li><li><input type="text" name="state" required maxlength="2" size="2" required pattern="[A-Z]{2}"></li>';
echo '<li>Zip:</li><li><input type="text" name="zip" pattern="[0-9]{5}" required maxlength="5" size="5" required></li>';
echo '<li>Apt Number (leave blank if N/A):</li><li><input type="text" name="apt_no" /></li>';
echo '<li><input type="submit" /></li>';


echo '</form>';
echo '</ul>';
	$apt_no = ''.$_POST['apt_no'];
	if ($apt_no == '')
		$apt_no = 'NULL';
	if ($_POST[street_no] != '') {
		$db = pg_connect("host=localhost port=5432 dbname=animalshelter user=Joey password=fluffy");
		$query = "select ins_location($_POST[street_no],'$_POST[street_name]', '$_POST[city]','$_POST[state]',$_POST[zip],".$apt_no.")";
		//echo '<h2>'.$query.'</h2>';
		$result = pg_query($query);

    $host = 'localhost';
    $user = 'Joey';
    $password = 'fluffy';
    $dbname = 'animalshelter';
    $dsn = 'pgsql:host='. $host .';dbname='. $dbname;
    $pdo = new PDO($dsn, $user, $password);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
		$query_id = "select location_id from location where street_no = ".$_POST[street_no]." and street_name = '".$_POST[street_name]."' and zip = ".$_POST[zip];
		$locid = $pdo->query($query_id);
		$row = $locid->fetch();
		$locationid = $row['location_id'];
		//echo '<h1>'.$locationid.'</h1>';
		echo "<script>window.location = 'employee_insert2.php?id=".$locationid."'</script>";
	}
?>
</body>
</head>
</html>
