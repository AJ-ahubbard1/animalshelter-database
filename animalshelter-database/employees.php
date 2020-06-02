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
      <li><a href="animals.php">
        Animals</a></li>
      <li class="active"><a href="employees.php">Employees</a></li>
      <li><a href="inventory.php">Inventory</a></li>
    </ul><br>
  </div> <!-- End of side nav -->

  <div class="col-sm-9" id="main-body">
    
    <div class="well"><h1>MANAGER VIEW</h1></div>
    
    <!--Each row inside of main-body will be 9 wide, cols must add up to 12-->
    <div class="row">
      <div class="col-sm-12"><a href="employee_insert1.php"  
        class="btn btn-primary btn-block" role="button">
        Add Employee/Volunteer</a>
      </div>  
    </div>
    
    <div class="row search-bar">
      <form class="form-inline" action="employees.php" method="get">
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
          <div class="form-group">
            <label for="searchby">Search By</label>
            <select class="form-control" name="searchby">
              <option>name</option>
              <option>ssn</option>
              <option>home_phone</option>
              <option>cell_phone</option>
              <option>position</option>
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
      $page = 'employees.php?';
      $cur_url = $page;
      if ($table != '')
        $cur_url .= 'searchby='.$table.'&search='.$string.'&';
      
      $employeeid = ''.$_GET['rowid'];
      $employeename = ''.$_GET['name'];
      $sdate = ''.$_GET['sdate'];
      $edate = ''.$_GET['edate'];

      // Set DSN
      $dsn = 'pgsql:host='. $host .';dbname='. $dbname;
      // Create a PDO instance
      $pdo = new PDO($dsn, $user, $password);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
      $first_query = 'SELECT * FROM employee';
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
        "'.$cur_url .'orderby=ssn"</a>SSN</th>';
      echo '<th><a class="formtitellink" href= 
        "'.$cur_url .'orderby=home_phone"</a>HOME</th>';
      echo '<th><a class="formtitellink" href= 
        "'.$cur_url .'orderby=cell_phone"</a>CELL</th>';
      echo '<th><a class="formtitellink" href= 
        "' .$cur_url .'orderby=wage"</a>WAGE</th>';
      echo '<th><a class="formtitellink" href= 
        "' .$cur_url .'orderby=position"</a>POSITION</th>';
      echo '</tr>';
        while($row = $stmt->fetch()){
          echo '<tr><td> <a class="formtitellink" href="'.$page.'rowid='.$row['employee_id'].'&name='.$row['name'].'"</a>'.$row['name'].'</td><td>' .$row['ssn'] .'</td><td>' .$row['home_phone'] .'</td><td>' .$row['cell_phone'] .'</td><td>' .$row['wage'] .'</td><td>' .$row['position'] .'</td></tr>'; 
        }
      echo '</table>';
      echo '</div>';
      echo '</div>';
    }  

    if ($employeename != '') {
      $second_query = "SELECT * from employees_earnings where name = '".$employeename."'";
      if ($sdate != '')
        $second_query .= " AND cur_date >= '".$sdate."'";
      if ($edate != '')
        $second_query .= " AND cur_date <= '".$edate."'";
      
      $records = $pdo->query($second_query);
      echo '<div class="row">';
        echo '<div class="col-sm-12">';
        echo '<table class="table-3">'; 
          echo '<caption>Timecards for '.$employeename.'</caption>';
          echo '<tr> <th>cur_date</th> <th>start_time</th> <th>end_time</th> <th>time_worked</th> <th>rate</th> <th>wage</th> <th>daily_earnings</th> <th>shelter_id</th></tr>';
          while($row = $records->fetch()){
            echo '<tr><td>'.$row['cur_date'] .'</td><td>' .$row['start_time'] .'</td><td>' .$row['end_time'] .'</td><td>' .$row['time_worked'] .'</td><td>' .$row['rate'] .'</td><td>' .$row['wage'] .'</td><td>' .$row['daily_earnings'] .'</td><td>' .$row['shelter_id'] .'</td></tr>'; 
          }
        echo '</table>';
        echo '</div>';
        echo '</div>';
      
  
      echo '<div class ="col-sm-12">';
      echo '<form class="form-inline" action="employees.php" method="get">';
      echo '<label for="name">Name:</label><br>';
      echo '<input type="text" id="name" name="name" value="'.$employeename.'">';
      echo '<label for="sdate">Start Date:</label>';
      echo '<input type="date" id="sdate" name="sdate">';
      echo '<label for="edate">End Date:</label>';
      echo '<input type="date" id="edate" name="edate">';
      echo '<input type="submit" value="Submit">';
      echo '</form>';
      echo '</div>';

      echo '<div class="col-sm-6">';
      echo '<a href="timecard_insert1.php?rowid='.$employeeid.'&name='.$employeename.'" class="btn btn-primary btn-block" role="button">Add Timecard for '.$employeename.'</a>';
      echo '</div>';

      echo '<div class="col-sm-6">';
      echo '<a href="/fpdf/reports2.php?rowid='.$employeeid.'&name='.$employeename.'&sdate='.$sdate.'&edate='.$edate.'" class="btn btn-primary btn-block" role="button">Generate Report for '.$employeename.'</a>';
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
