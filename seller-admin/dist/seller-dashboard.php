<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Seller Page</title>

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
  <?php include 'seller-header.php'; ?>
  <?php include '../../connect.php';
  $seller_id = $_SESSION['seller_id'];
  ?>
  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="card card-statistic-2">
            <div class="card-stats">
              <div class="card-stats-title">Order Statistics
              </div>
              <div class="card-stats-items">
                <?php
                $seller_id = $_SESSION['seller_id'];

                $query = "SELECT
    SUM(CASE WHEN o.status = 'Pending' THEN 1 ELSE 0 END) AS pending_count,
    SUM(CASE WHEN o.status = 'Approved' THEN 1 ELSE 0 END) AS approved_count,
    SUM(CASE WHEN o.status = 'Shipped' THEN 1 ELSE 0 END) AS shipped_count,
    SUM(1) AS total_orders
    FROM orders o
    JOIN user u ON o.user_id = u.user_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN product p ON oi.product_id = p.product_id
    WHERE p.seller_id = $seller_id";

                // Create a prepared statement
                $stmt = mysqli_prepare($db, $query);

                if ($stmt) {
                  // Execute the query
                  $success = mysqli_stmt_execute($stmt);

                  if ($success) {
                    // Get the result
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);

                    // Get the counts
                    $pending_count = $row['pending_count'];
                    $approved_count = $row['approved_count'];
                    $shipped_count = $row['shipped_count'];
                    $total_orders = $row['total_orders'];

                    // Close the result and statement
                    mysqli_free_result($result);
                    mysqli_stmt_close($stmt);
                  } else {
                    echo "Error executing the query: " . mysqli_error($db);
                  }
                } else {
                  echo "Error preparing the statement: " . mysqli_error($db);
                }
                ?>

                <!-- Display the counts -->
                <div class="card-stats-item">
                  <div class="card-stats-item-count"><?php echo $pending_count; ?></div>
                  <div class="card-stats-item-label">Pending</div>
                </div>
                <div class="card-stats-item">
                  <div class="card-stats-item-count"><?php echo $approved_count; ?></div>
                  <div class="card-stats-item-label">Approved</div>
                </div>
                <div class="card-stats-item">
                  <div class="card-stats-item-count"><?php echo $shipped_count; ?></div>
                  <div class="card-stats-item-label">Shipped</div>
                </div>
              </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
              <i class="fas fa-archive"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Orders</h4>
              </div>
              <div class="card-body">
                <?php echo $total_orders; ?>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="card card-statistic-2">
            <div class="card-stats">
              <div>
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Amount Earn</h4>
                    <?php
                    $seller_id = $_SESSION['seller_id'];

                    $totalRevenue = 0;

                    // Create a SQL query to calculate total revenue
                    $totalRevenueQuery = "SELECT SUM(o.total_amount) AS totalRevenue
                      FROM orders AS o
                      JOIN order_items AS oi ON o.order_id = oi.order_id
                      JOIN product AS p ON oi.product_id = p.product_id
                      WHERE p.seller_id = ?";

                    // Create a prepared statement
                    $stmt = mysqli_prepare($db, $totalRevenueQuery);

                    if ($stmt) {
                      // Bind the seller_id as a parameter
                      mysqli_stmt_bind_param($stmt, "i", $seller_id);

                      // Execute the query
                      $success = mysqli_stmt_execute($stmt);

                      if ($success) {
                        // Get the result
                        $result = mysqli_stmt_get_result($stmt);

                        if ($result && mysqli_num_rows($result) > 0) {
                          // Fetch the total revenue
                          $row = mysqli_fetch_assoc($result);
                          $totalRevenue = $row['totalRevenue'];
                        } else {
                          // No results found for the product_id
                          $totalRevenue = 0; // or any other default value
                        }

                        // Close the result and statement
                        mysqli_free_result($result);
                        mysqli_stmt_close($stmt);
                      } else {
                        // Handle query execution error
                        echo "Error executing the query: " . mysqli_error($db);
                      }
                    } else {
                      // Handle statement preparation error
                      echo "Error preparing the statement: " . mysqli_error($db);
                    }
                    ?>
                  </div>
                  <div class="card-body">
                    RM <?php echo $totalRevenue; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Monthly Average Sales</h4>
                <?php
                $seller_id = $_SESSION['seller_id'];
                $averageMonthlySales = 0;

                // Create a SQL query to calculate the average monthly sales
                $averageMonthlySalesQuery = "SELECT AVG(totalMonthlySales) AS averageMonthlySales
                            FROM (
                                SELECT SUM(o.total_amount) / 12 AS totalMonthlySales
                                FROM orders AS o
                                JOIN order_items AS oi ON o.order_id = oi.order_id
                                JOIN product AS p ON oi.product_id = p.product_id
                                WHERE p.seller_id = ?
                                GROUP BY YEAR(o.order_date), MONTH(o.order_date)
                            ) AS monthlySales";

                // Create a prepared statement
                $stmt = mysqli_prepare($db, $averageMonthlySalesQuery);

                if ($stmt) {
                  // Bind the seller_id as a parameter
                  mysqli_stmt_bind_param($stmt, "i", $seller_id);

                  // Execute the query
                  $success = mysqli_stmt_execute($stmt);

                  if ($success) {
                    // Get the result
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result && mysqli_num_rows($result) > 0) {
                      // Fetch the average monthly sales
                      $row = mysqli_fetch_assoc($result);
                      $averageMonthlySales = $row['averageMonthlySales'];
                    } else {
                      // No results found for the seller_id
                      $averageMonthlySales = 0; // or any other default value
                    }

                    // Close the result and statement
                    mysqli_free_result($result);
                    mysqli_stmt_close($stmt);
                  } else {
                    // Handle query execution error
                    echo "Error executing the query: " . mysqli_error($db);
                  }
                } else {
                  // Handle statement preparation error
                  echo "Error preparing the statement: " . mysqli_error($db);
                }

                ?>
              </div>
              <div class="card-body">
                RM <?php echo number_format($averageMonthlySales, 2); ?>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="card card-statistic-2">
            <div class="card-stats">
              <?php
              $seller_id = $_SESSION['seller_id'];

              // Calculate weekly sales
              $weeklySalesQuery = "SELECT SUM(o.total_amount) AS weeklySales
                                  FROM orders AS o
                                  JOIN order_items AS oi ON o.order_id = oi.order_id
                                  JOIN product AS p ON oi.product_id = p.product_id
                                  WHERE p.seller_id = ? AND WEEK(o.order_date) = WEEK(CURDATE())";

              $stmt = mysqli_prepare($db, $weeklySalesQuery);

              if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $seller_id);
                $success = mysqli_stmt_execute($stmt);

                if ($success) {
                  $result = mysqli_stmt_get_result($stmt);
                  $row = mysqli_fetch_assoc($result);
                  $weeklySales = $row['weeklySales'] ?? 0;
                } else {
                  // Handle query execution error (if necessary)
                }

                mysqli_stmt_close($stmt);
              }

              // Calculate today's sales
              $todaySalesQuery = "SELECT SUM(o.total_amount) AS todaySales
                                  FROM orders AS o
                                  JOIN order_items AS oi ON o.order_id = oi.order_id
                                  JOIN product AS p ON oi.product_id = p.product_id
                                  WHERE p.seller_id = ? AND DATE(o.order_date) = CURDATE()";

              $stmt = mysqli_prepare($db, $todaySalesQuery);

              if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $seller_id);
                $success = mysqli_stmt_execute($stmt);

                if ($success) {
                  $result = mysqli_stmt_get_result($stmt);
                  $row = mysqli_fetch_assoc($result);
                  $todaySales = $row['todaySales'] ?? 0;
                } else {
                  // Handle query execution error (if necessary)
                }

                mysqli_stmt_close($stmt);
              }
              ?>
              <div>
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Weekly Sales</h4>
                  </div>
                  <div class="card-body">
                    RM <?php echo number_format($weeklySales, 2); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Today's Sales</h4>
              </div>
              <div class="card-body">
                RM <?php echo number_format($todaySales, 2); ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-7">
          <div class="card">
            <div class="card-header">
              <h4>Sales 2023</h4>
            </div>
            <div id="salesChart" style="width: 100%; height: 300px;">
              <?php
              $seller_id = $_SESSION['seller_id'];

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

              // Create a SQL query to calculate monthly total sales
              $monthlySalesQuery = "SELECT DATE_FORMAT(o.order_date, '%Y-%m') AS month, SUM(o.total_amount) AS total_sales
    FROM orders AS o
    JOIN order_items AS oi ON o.order_id = oi.order_id
    JOIN product AS p ON oi.product_id = p.product_id
    WHERE p.seller_id = ?
    GROUP BY DATE_FORMAT(o.order_date, '%Y-%m')";

              // Create a prepared statement
              $stmt = mysqli_prepare($db, $monthlySalesQuery);

              if ($stmt) {
                // Bind the seller_id as a parameter
                mysqli_stmt_bind_param($stmt, "i", $seller_id);

                // Execute the query
                $success = mysqli_stmt_execute($stmt);

                if ($success) {
                  // Get the result
                  $result = mysqli_stmt_get_result($stmt);

                  // Fetch the data into an array
                  while ($row = mysqli_fetch_assoc($result)) {
                    $month = date("F", strtotime($row['month'] . "-01")); // Convert month to full month name
                    $salesArray[$month] = (int)$row['total_sales'];
                  }

                  // Close the result and statement
                  mysqli_free_result($result);
                  mysqli_stmt_close($stmt);
                } else {
                  // Handle query execution error
                  echo "Error executing the query: " . mysqli_error($db);
                }
              } else {
                // Handle statement preparation error
                echo "Error preparing the statement: " . mysqli_error($db);
              }
              ?>

              <!-- HTML and JavaScript for Google Chart -->
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
                    // Generate the data points for each month
                    foreach ($salesArray as $month => $sales) {
                      echo "['$month', $sales],";
                    }
                    ?>
                  ];

                  var data = google.visualization.arrayToDataTable(salesData);

                  var options = {
                    title: 'Monthly Sales (Amount in RM)',
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
        </div>
        <div class="col-lg-5">
          <div class="card">
            <div class="card-header">
              <h4>Review</h4>
            </div>
            <div class="card-body">
              <div id="products-carousel">
                <div>
                  <div class="product-item pb-3">
                    <div class="product-details">
                      <?php
                      $reviewSql = "SELECT p.product_name, u.username, r.rating, r.review_datetime, r.comment
                                    FROM product p
                                    JOIN order_items oi ON p.product_id = oi.product_id
                                    JOIN review r ON oi.order_item_id = r.order_item_id
                                    JOIN orders o ON oi.order_id = o.order_id
                                    JOIN user u ON u.user_id = o.user_id
                                    WHERE p.seller_id = $seller_id";

                      $reviewResult = mysqli_query($db, $reviewSql);

                      if ($reviewResult) {
                        // Check if there are reviews
                        if (mysqli_num_rows($reviewResult) > 0) {
                          // Loop through the reviews
                          while ($reviewRow = mysqli_fetch_assoc($reviewResult)) {
                            // Inside the loop, retrieve review information for each review
                            $product_name = $reviewRow['product_name'];
                            $username = $reviewRow['username'];
                            $rating = $reviewRow['rating'];
                            $review_datetime = $reviewRow['review_datetime'];
                            $comment = $reviewRow['comment'];

                            // Display review information for each review
                            echo '<div class="product-item">';
                            echo '<div class="product-details">';
                            echo '<div class="product-name">Product Name: ' . $product_name . '</div>';
                            echo '<div class="product-name">Username: ' . $username . '<br>Review Date: ' . $review_datetime . '</div>';
                            echo '<div class="product-review">Rating: ' . $rating . '</div>';
                            echo '<div class="text-muted text-small">Comment: ' . $comment . '</div><br>';
                            echo '</div>';
                            echo '</div>';
                          }
                        } else {
                          echo 'No reviews available.';
                        }

                        // Free the review result set
                        mysqli_free_result($reviewResult);
                      } else {
                        echo "Error: " . mysqli_error($db);
                      }
                      ?>



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