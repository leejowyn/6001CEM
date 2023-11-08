<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Admin Page</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body>
<?php  
    include 'admin-nav.php'; 
    include '../../connect.php';

    // Total number of users
$userQuery = "SELECT COUNT(user_id) AS totalUsers FROM user";
$userResult = mysqli_query($db, $userQuery);
$totalUsers = mysqli_fetch_assoc($userResult)['totalUsers'];

// Total number of orders
$orderQuery = "SELECT COUNT(order_id) AS totalOrders FROM orders";
$orderResult = mysqli_query($db, $orderQuery);
$totalOrders = mysqli_fetch_assoc($orderResult)['totalOrders'];

// Total number of sellers
$sellerQuery = "SELECT COUNT(seller_id) AS totalSellers FROM seller";
$sellerResult = mysqli_query($db, $sellerQuery);
$totalSellers = mysqli_fetch_assoc($sellerResult)['totalSellers'];

// Total order amount
$totalAmountQuery = "SELECT SUM(total_amount) AS totalAmount FROM orders";
$totalAmountResult = mysqli_query($db, $totalAmountQuery);
$totalAmount = mysqli_fetch_assoc($totalAmountResult)['totalAmount'];

// Get today's sales
$todayQuery = "SELECT SUM(total_amount) AS todaySales FROM orders WHERE DATE(order_date) = CURDATE()";
$todayResult = mysqli_query($db, $todayQuery);
$todaySales = mysqli_fetch_assoc($todayResult)['todaySales'];

// Get this week's sales
$weekQuery = "SELECT SUM(total_amount) AS weekSales FROM orders WHERE YEARWEEK(order_date) = YEARWEEK(CURDATE())";
$weekResult = mysqli_query($db, $weekQuery);
$weekSales = mysqli_fetch_assoc($weekResult)['weekSales'];

// Get this month's sales
$monthQuery = "SELECT SUM(total_amount) AS monthSales FROM orders WHERE MONTH(order_date) = MONTH(CURDATE())";
$monthResult = mysqli_query($db, $monthQuery);
$monthSales = mysqli_fetch_assoc($monthResult)['monthSales'];

// Get this year's sales
$yearQuery = "SELECT SUM(total_amount) AS yearSales FROM orders WHERE YEAR(order_date) = YEAR(CURDATE())";
$yearResult = mysqli_query($db, $yearQuery);
$yearSales = mysqli_fetch_assoc($yearResult)['yearSales'];

?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total User</h4>
                  </div>
                  <div class="card-body">
                  <?php echo $totalUsers; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Seller</h4>
                  </div>
                  <div class="card-body">
                  <?php echo $totalSellers; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Order</h4>
                  </div>
                  <div class="card-body">
                  <?php echo $totalOrders; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Sales</h4>
                  </div>
                  <div class="card-body">
                  RM <?php echo $totalAmount; ?>
                  </div>
                </div>
              </div>
            </div>                  
          </div>
          <div class="col-lg-12 col-md-10 col-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4>Statistic</h4>
            </div>
            <div id="salesChart" style="width: 100%; height: 300px;">
              <?php
              $query = "SELECT MONTH(order_date) AS month, SUM(total_amount) AS total_sales
                        FROM orders
                        WHERE YEAR(order_date) = YEAR(CURDATE())
                        GROUP BY MONTH(order_date)
                        ORDER BY MONTH(order_date)";

              $result = mysqli_query($db, $query);

              // Fetch the data into an array
              $data = array();
              while ($row = mysqli_fetch_assoc($result)) {
                $data[] = array($row['month'], (int)$row['total_sales']);
              }
              ?>
              <script type="text/javascript">
                google.charts.load('current', {
                  'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                  // Create an array to hold the sales data for each month
                  var salesData = [
                    ['Month', 'Sales'],
                    <?php
                    // Create an array to store the sales data
                    $salesArray = array(
                      'January' => 0,
                      'February' => 0,
                      'March' => 0,
                      'April' => 0,
                      'May' => 0,
                      'June' => 0,
                      'July' => 0,
                      'August' => 0,
                      'September' => 0,
                      'October' => 0,
                      'November' => 0,
                      'December' => 0
                    );

                    // Populate the sales data from your database
                    foreach ($data as $row) {
                      $month = date("F", mktime(0, 0, 0, $row[0], 1));
                      $salesArray[$month] = $row[1];
                    }

                    // Generate the data points for each month
                    foreach ($salesArray as $month => $sales) {
                      echo "['$month', $sales],";
                    }
                    ?>
                  ];

                  var data = google.visualization.arrayToDataTable(salesData);

                  var options = {
                    title: 'Amount (RM)',
                    curveType: 'function',
                    legend: {
                      position: 'bottom'
                    },
                  };

                  var chart = new google.visualization.LineChart(document.getElementById('salesChart'));

                  chart.draw(data, options);

                }
              </script>

            </div>
          </div>
        
          <div class="row">
            <div class="col-lg-12 col-md-10 col-12 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="statistic-details mt-sm-4">
                    <div class="statistic-details-item">
                      <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>
                      <div class="detail-value"><?php echo '$' . number_format($todaySales, 2); ?></div>
                      <div class="detail-name">Today's Sales</div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
                      <div class="detail-value"><?php echo '$' . number_format($weekSales, 2); ?></div>
                      <div class="detail-name">This Week's Sales</div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span>
                      <div class="detail-value"><?php echo '$' . number_format($monthSales, 2); ?></div>
                      <div class="detail-name">This Month's Sales</div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span>
                      <div class="detail-value"><?php echo '$' . number_format($yearSales, 2); ?></div>
                      <div class="detail-name">This Year's Sales</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>
      </div>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->
  <script src="assets/modules/jquery.sparkline.min.js"></script>
  <script src="assets/modules/chart.min.js"></script>
  <script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
  <script src="assets/modules/summernote/summernote-bs4.js"></script>
  <script src="assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/index.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>