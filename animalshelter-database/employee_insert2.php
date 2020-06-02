<!DOCTYPE html>
<html lang="en">
<head>
<body>
<?php	
	$locationid = $_GET['id'];
echo '<ul style="list-style-type:none;margin:0;padding:0;">';
echo '<form name="insert" action="employee_insert2.php?id='.$locationid.'" method="POST">';
echo '<li>Social Security Num: (no dashes)</li><li><input type="number" name="ssn" maxlength="9" size="9" min="000000001" required autofocus></li>';
echo '<li>Full Name:</li><li><input type="text" name="name" required></li>';
echo '<li>Home Phone: (###-###-####)</li><li><input type="tel" name="home_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required></li>';
echo '<li>Cell Phone: (###-###-####)</li><li><input type="tel" name="cell_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required></li>';
echo '<li>Wage:</li><li><input type="text" name="wage" required></li>';
echo '<li>Position:</li><li><input type="text" name="position" required></li>';
echo '<li><input type="submit" /></li>';


echo '</form>';
echo '</ul>';
	if ($_POST[ssn] != '') {
    $host = 'localhost';
    $user = 'Joey';
    $password = 'fluffy';
    $dbname = 'animalshelter';
    $dsn = 'pgsql:host='. $host .';dbname='. $dbname;
    $pdo = new PDO($dsn, $user, $password);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
		$query = "select ins_employee($_POST[ssn],'$_POST[name]','$_POST[home_phone]','$_POST[cell_phone]',$_POST[wage],'$_POST[position]',".$locationid.")";
		//echo '<h2>'.$query.'</h2>';
		$result = $pdo->query($query);
		echo "<script>window.location = 'employees.php'</script>";
	}
?>
</body>
</head>
</html>
