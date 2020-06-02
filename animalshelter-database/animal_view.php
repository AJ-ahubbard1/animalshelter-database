<?php 
	$host = 'localhost';
	$user = 'Joey';
	$password = 'fluffy';
	$dbname = 'animalshelter';

	// Set DSN
	$dsn = 'pgsql:host='. $host .';dbname='. $dbname;
	
	// Create a PDO instance
	$pdo = new PDO($dsn, $user, $password);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
	
	// PDO QUERY: view animal table 
	$stmt = $pdo->query('SELECT * FROM animal');
	echo '<table style ="width:100%;text-align:center;">'; 
  echo '<tr> <th>NAME</th> <th>DOB</th> <th>SEX</th> <th>SPECIES</th> <th>BREED</th> <th>SHELTER</th></tr>';
	while($row = $stmt->fetch()){
		echo '<tr><td>' .$row['name'] .'</td><td>' .$row['dob'] .'</td><td>' .$row['sex'] .'</td><td>' .$row['species'] .'</td><td>' .$row['breed'] .'</td><td>' .$row['shelter_id'] .'</td></tr>'; 
	}
  echo '</table>';
?>
