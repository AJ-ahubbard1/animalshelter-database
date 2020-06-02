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
      <li><a href="employees.php">Employees</a></li>
      <li class="active"><a href="inventory.php">Inventory</a></li>
    </ul><br>
  </div> <!-- End of side nav -->

  <div class="col-sm-9" id="main-body">
    
    <div class="well"><h1>MANAGER VIEW</h1></div>
    
    <!--Each row inside of main-body will be 9 wide, cols must add up to 12-->
    <div class="row">
      <div class="col-sm-12"><a href="purchase_insert.php"  
        class="btn btn-primary btn-block" role="button" target="blank">
        Add Purchase</a>
      </div>
      <!-- uncomment buttons as needed
      <div class="col-sm-3"><button type="button" class="btn btn-primary btn-block">button2</button></div>
      <div class="col-sm-3"><button type="button" class="btn btn-primary btn-block">button3</button></div>
      <div class="col-sm-3"><button type="button" class="btn btn-primary btn-block">button4</button></div>
      -->   
    </div>
    
    <div class="row search-bar">
      <form class="form-inline" action="inventory.php" method="get">
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
          <div class="form-group">
            <label for="searchby">Search By</label>
            <select class="form-control" name="searchby">
              <option>name</option>
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
     
      $table = '' .$_GET["searchby"];
      $string = $_GET["search"];
      $orderby = '' .$_GET["orderby"];
      $page = 'inventory.php?';
      $sdate = ''.$_GET['sdate'];
      $edate = ''.$_GET['edate'];
      $cur_url = $page;
      if ($table != '')
        $cur_url .= 'searchby='.$table.'&search='.$string.'&';
      // Set DSN
       $host = 'localhost';
      $user = 'Joey';
      $password = 'fluffy';
      $dbname = 'animalshelter';
      $dsn = 'pgsql:host='. $host .';dbname='. $dbname;
      
      // Create a PDO instance
      $pdo = new PDO($dsn, $user, $password);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
      $first_query = 'SELECT * FROM purchases_main';
      $whereadded = false;
      if ($table != '') {
        $first_query .= ' WHERE ' .$table .' like \'%' .$string .'%\'';
        $whereadded = true;
      }
      if ($sdate != '') {
        if ($whereadded)
          $first_query .= " AND cur_date >= '".$sdate."'";
        else {
          $first_query .= " WHERE cur_date >= '".$sdate."'";
          $whereadded = true;
        }
      }
      if ($edate != '') {
        if ($whereadded)
          $first_query .= " AND cur_date <= '".$edate."'";
        else {
          $first_query .= " WHERE cur_date <= '".$edate."'";
        }
      }

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
        "'.$cur_url .'orderby=shelter"</a>SHELTER</th>';
      echo '<th><a class="formtitellink" href= 
        "'.$cur_url .'orderby=cur_date"</a>DATE</th>';
      echo '<th><a class="formtitellink" href= 
        "'.$cur_url .'orderby=quantity"</a>QUANTITY</th>';
      echo '<th><a class="formtitellink" href= 
        "' .$cur_url .'orderby=price"</a>PRICE</th>';
      echo '</tr>';
        while($row = $stmt->fetch()){
          echo '<tr><td>' .$row['name'] .'</td><td>' .$row['shelter'] .'</td><td>' .$row['cur_date'] .'</td><td>' .$row['quantity'] .'</td><td>' .$row['price'] .'</td></tr>'; 
        }
      echo '</table>';
      echo '</div>';
      echo '</div>';
    }  
    $records = $pdo->query('SELECT * FROM supply');
    echo '<div class="row">';
    echo '<div class="col-sm-12">';
      echo '<table class="table-3">'; 
      echo '<caption>Total Supply</caption>';
          echo '<tr> <th>supply id</th> <th>name</th> <th>description</th> <th>quantity</th></tr>';
          while($row = $records->fetch()){
            echo '<tr><td>'.$row['supply_id'] .'</td><td>' .$row['name'] .'</td><td>' .$row['description'] .'</td><td>' .$row['quantity'] .'</td></tr>'; 
          }
        echo '</table>';
        echo '</div>';
        echo '</div>';

      echo '<div class ="col-sm-12">';
      echo '<form class="form-inline" action="inventory.php" method="get">';
      echo '<label for="sdate">Start Date:</label>';
      echo '<input type="date" id="sdate" name="sdate">';
      echo '<label for="edate">End Date:</label>';
      echo '<input type="date" id="edate" name="edate">';
      echo '<input type="submit" value="Submit">';
      echo '</form>';
      echo '</div>';

      echo '<div class="col-sm-12">';
      echo '<a href="/fpdf/reports.php?sdate='.$sdate.'&edate='.$edate.'" class="btn btn-primary btn-block" role="button">Generate Report</a>';
      echo '</div>';
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
