<!DOCTYPE html>
<html lang="en">
<head>
  <title>Animal Shelter - Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
<div class="row content">
  
  <div class="col-sm-3 sidenav">
    <div id="myCarousel" class="carousel slide" data-ride="carousel"> 
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <div class="item active">
          <img src="images/cutedog.jpg" alt="cute puppy">

        </div>
        <div class="item">
          <img src="images/hi-puppy.jpg" alt="Hi puppy!">
        </div>
        <div class="item">
          <img src="images/kittens.jpg" alt="kittens">
        </div>
        <div class="item">
          <img src="images/big-mac.jpg" alt="big-mac">
        </div>
        <div class="item">
          <img src="images/cool-cats.jpg" alt="cool cats!">
        </div>
      </div>
    </div>  

    <ul class="nav nav-pills nav-stacked inverted left-aside">
      <li><a href="#home.html">Home</a></li>
      <li class="active"><a href="animals.php">
        Animals</a></li>
      <li><a href="employees.php">Employees</a></li>
      <li><a href="inventory.php">Inventory</a></li>
     
    </ul><br>
  </div> <!-- End of side nav -->

  <div class="col-sm-9" id="main-body">
    
    <div class="well"><h1>MANAGER VIEW</h1></div>
    
    <!--Each row inside of main-body will be 9 wide, cols must add up to 12-->
    <div class="row">
      <div class="col-sm-12"><a href="animal_insert.php"  
        class="btn btn-primary btn-block" role="button">
        Add Animal</a>
      </div> 
    </div>
    
    <div class="row search-bar">
      <form class="form-inline" action="animals.php" method="get">
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
          <div class="form-group">
            <label for="searchby">Search By</label>
            <select class="form-control" name="searchby">
              <option>name</option>
              <option>breed</option>
              <option>shelter</option>
            </select>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="search">
            <div class="input-group-btn">
              <button class="btn btn-default" type="submit">
                <i class="glyphicon glyphicon-search"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="col-sm-3"></div>
      </form>
    </div>
    
    <?php 
      $host = 'localhost';
      $user = 'Joey';
      $password = 'fluffy';
      $dbname = 'animalshelter';
      $table = '' .$_GET["searchby"];
      $string = $_GET["search"];
      $orderby = '' .$_GET["orderby"];
      $page = 'animals.php?';
      $cur_url = $page;
      if ($table != '')
        $cur_url .= 'searchby='.$table.'&search='.$string.'&';
      // Set DSN
      $dsn = 'pgsql:host='. $host .';dbname='. $dbname;
      
      // Create a PDO instance
      $pdo = new PDO($dsn, $user, $password);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
      $first_query = 'SELECT * FROM animal_main';
      if ($table == 'shelter_id') 
        $first_query .= ' WHERE ' .$table .' = '.(int)$string;
      else if ($table != '') 
        $first_query .= ' WHERE ' .$table .' like \'%' .$string .'%\'';
      if ($orderby != '') 
        $first_query .= ' ORDER BY ' .$orderby;
      //troubleshooting first query
      //echo '<h3>'.$first_query.'</h3>';
      $stmt = $pdo->query($first_query); 
    if (!is_null($stmt)) {
      echo '<div class="row" id="main_table_container">';
      echo '<div class="col-sm-12">';
      echo '<table class="table-1">';
      echo '<tr><th><a class="formtitellink" href= 
        "'.$cur_url .'orderby=name"</a>NAME</th>';
      echo '<th><a class="formtitellink" href= 
        "'.$cur_url .'orderby=dob"</a>DOB</th>';
      echo '<th><a class="formtitellink" href= 
        "'.$cur_url .'orderby=sex"</a>SEX</th>';
      echo '<th><a class="formtitellink" href= 
        "'.$cur_url .'orderby=species"</a>SPECIES</th>';
      echo '<th><a class="formtitellink" href= 
        "'.$cur_url .'orderby=breed"</a>BREED</th>';
      echo '<th><a class="formtitellink" href= 
        "'.$cur_url .'orderby=shelter"</a>SHELTER</th>
        </tr>';
        while($row = $stmt->fetch()){
          echo '<tr><td> <a class="formtitellink" href="'.$page.'rowid='.$row['animal_id'] .'"</a>'.$row['name'].'</td><td>' .$row['dob'] .'</td><td>' .$row['sex'] .'</td><td>' .$row['species'] .'</td><td>' .$row['breed'] .'</td><td>' .$row['shelter'] .'</td></tr>'; 
        }
      echo '</table>';
      echo '</div>';
      echo '</div>';
    }  
    $animalid = ''.$_GET['rowid'];
    if ($animalid != '') {
      $records = $pdo->query('SELECT * FROM medicalrecord WHERE animal_id = '.$animalid);
      $name = $pdo->query('SELECT name from animal where animal_id = '.$animalid);
      $row = $name->fetch();
      $animalname = $row['name'];
      echo '<div class="row">';
        echo '<div class="col-sm-12">';
        echo '<table class="table-2">'; 
          echo '<caption>Medical Records for '.$animalname.'</caption>';
          echo '<tr> <th>rec_date</th> <th>weight</th> <th>neutered</th> <th>condition</th> <th>treatments</th> <th>vaccinations</th> <th>allergies</th></tr>';
          while($row = $records->fetch()){
            echo '<tr><td>'.$row['rec_date'] .'</td><td>' .$row['weight'] .'</td><td>' .$row['spayed_neutered'] .'</td><td>' .$row['condition'] .'</td><td>' .$row['treatments'] .'</td><td>' .$row['vaccinations'] .'</td><td>' .$row['allergies'] .'</td></tr>'; 
          }
        echo '</table>';
        echo '</div>';
      echo '</div>';
      $care = $pdo->query('SELECT * FROM specializedcare WHERE animal_id = '.$animalid);
      echo '<div class="row">';
      echo '<div class="col-sm-12">';
        echo '<table class="table-2">'; 
          echo '<caption>Specialized Care for '.$animalname.'</caption>';
          echo '<tr> <th>care type</th> <th>description</th> <th>amount</th> <th>frequency</th> <th>units of time</th></tr>';
          while($row = $care->fetch()){
            echo '<tr><td>'.$row['ctype'] .'</td><td>' .$row['description'] .'</td><td>' .$row['amount'] .'</td><td>' .$row['frequency'] .'</td><td>' .$row['time_units'] .'</td></tr>'; 
          }
        echo '</table>';
        echo '</div>';
      echo '</div>';
      echo '<div class="row">';
      echo '<div class="col-sm-4">';
      echo '<a href="medical_insert.php?rowid='.$animalid.'" class="btn btn-primary btn-block" role="button">Add Medical Record for '.$animalname.'</a>';
      echo '</div>';

      echo '<div class="col-sm-4">';
      echo '<a href="specialized_insert.php?rowid='.$animalid.'" class="btn btn-primary btn-block" role="button">Add Specialized Care for '.$animalname.'</a>';
      echo '</div>';
      
      echo '<div class="col-sm-4">';
      echo '<a href="animal_delete.php?rowid='.$animalid.'" class="btn btn-primary btn-block" role="button">Delete '.$animalname.' from Database?</a>';
      echo '</div>';
      echo '</div>';
    }
    ?>
    <div class="row">
    <div class="col-sm-12">
      <img src="images/background.jpg" alt="pet family" id ="footer-image">
    </div></div>
  </div> <!-- End of main-body-->
</div>
</div>
</body>
</html>
