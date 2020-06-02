<!DOCTYPE html>
<html lang="en">
<head>
<body>
<?php	
	
echo '<ul style="list-style-type:none;margin:0;padding:0;">';
echo '<form name="insert" action="purchase_insert.php" method="POST" >';
echo '<li>Supply Item ID</li><li><input type="number" name="supply_id" min="1" max="18" autofocus required></li>';
echo '<li>Shelter ID</li><li><input type="number" name="shelter_id" min="1" max="10" required></li>';
echo '<li>Date of Purchase</li><li><input type="date" name="cur_date" required></li>';
echo '<li>Time of Purchase</li><li><input type="time" name="time" required></li>';
echo '<li>Quantity:</li><li><input type="number" name="quantity" min="1" required></li>';
echo '<li>Price:</li><li><input type="text" name="price" required></li>';
echo '<li><input type="submit" /></li>';

if ($_POST[shelter_id] != '') {
		$db = pg_connect("host=localhost port=5432 dbname=animalshelter user=Joey password=fluffy");
		$query = "select ins_purchase($_POST[supply_id],$_POST[shelter_id], '$_POST[cur_date] $_POST[time]:00', $_POST[quantity],$_POST[price])";
		$result = pg_query($query);
		//echo '<h1>'.$query.'</h1>';
		echo "<script>window.location = 'inventory.php'</script>";
	}
?>
</body>
</head>
</html>
