<?php
include '../../connect.php';
session_start();
$user_id = $_SESSION['user_id'];
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0; // Ensure $order_id is an integer

if ($order_id == 0) {
  echo "Invalid order ID.";
  exit; // Exit the script
}

// Add your database connection code here

$query = "SELECT o.order_id, u.username, u.address, o.payment_method, o.order_date, 
          p.product_name, p.price, oi.quantity, o.total_amount, oi.order_item_id
          FROM orders o
          JOIN order_items oi ON o.order_id = oi.order_id
          JOIN user u ON o.user_id = u.user_id
          JOIN product p ON oi.product_id = p.product_id
          WHERE o.order_id = $order_id";

$result = mysqli_query($db, $query);

if ($result) {
  $orderDetails = array(); // Array to store order details
  $orderItems = array();   // Array to store order items

  while ($row = mysqli_fetch_assoc($result)) {
    if (empty($orderDetails)) {
      // Populate order details only once
      $orderDetails['order_id'] = $row['order_id'];
      $orderDetails['username'] = $row['username'];
      $orderDetails['address'] = $row['address'];
      $orderDetails['payment_method'] = $row['payment_method'];
      $orderDetails['order_date'] = $row['order_date'];
      $orderDetails['total_amount'] = $row['total_amount'];
      $orderDetails['order_item_id'] = $row['order_item_id'];
    }
    // Populate order items
    $product_name = $row['product_name'];
    $price = $row['price'];
    $quantity = $row['quantity'];
    $order_item_id = $row['order_item_id'];

    // Calculate the total for this item
    $total = $price * $quantity;

    $orderItems[] = array(
      'product_name' => $product_name,
      'price' => $price,
      'quantity' => $quantity,
      'total' => $total,
      'order_item_id' => $order_item_id
    );
  }
} else {
  echo "Error fetching order details.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Receipt</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <!-- Main Content -->
  <div class="main-content">
    <section class="section">

      <div class="section-body">
        <div class="invoice">
          <div class="invoice-print">
            <div class="row">
              <div class="col-lg-12">
                <div class="invoice-title">
                  <div class="section-header-back">
                    <a href="../../order-history.php" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                  </div>
                  <h2>Order</h2>
                  <?php
                  // Receive the order_id from the URL
                  $order_id = $_GET['order_id'];

                  // Print order details
                  echo '<div class="invoice-number">Order: ' . $orderDetails['order_id'] . '</div>';
                  echo '</div>';
                  echo '<hr>';
                  echo '<div class="row">';
                  echo '<div class="col-md-6">';
                  echo '</div>';
                  echo '<div class="col-md-6 text-md-right">';
                  echo '<address>';
                  echo '<strong>Shipped To:</strong><br>';
                  echo $orderDetails['username'] . '<br>';
                  echo $orderDetails['address'] . '<br>';
                  echo '</address>';
                  echo '</div>';
                  echo '</div>';
                  echo '<div class="row">';
                  echo '<div class="col-md-6">';
                  echo '<address>';
                  echo '<strong>Payment Method:</strong><br>';
                  echo $orderDetails['payment_method'];
                  echo '</address>';
                  echo '</div>';
                  echo '<div class="col-md-6 text-md-right">';
                  echo '<address>';
                  echo '<strong>Order Date:</strong><br>';
                  echo $orderDetails['order_date'];
                  echo '</address>';
                  echo '</div>';
                  echo '</div>';

                  // Print order items
                  echo '<div class="row mt-4">';
                  echo '<div class="col-md-12">';
                  echo '<div class="section-title">Order Summary</div>';
                  echo '<div class="table-responsive">';
                  echo '<table class="table table-striped table-hover table-md">';
                  echo '<tr>';
                  echo '<th data-width="40">#</th>';
                  echo '<th>Item</th>';
                  echo '<th class="text-center">Price</th>';
                  echo '<th class="text-center">Quantity</th>';
                  echo '<th class="text-center">Total</th>';
                  echo '<th class="text-center"></th>';
                  echo '</tr>';

                  foreach ($orderItems as $index => $item) {
                    echo '<tr>';
                    echo '<td>' . ($index + 1) . '</td>';
                    echo '<td>' . $item['product_name'] . '</td>';
                    echo '<td class="text-center">' . $item['price'] . '</td>';
                    echo '<td class="text-center">' . $item['quantity'] . '</td>';
                    echo '<td class="text-center">' . $item['total'] . '</td>';
                    // Check if a review exists for the order_item_id
                    $existingReviewCheckSql = "SELECT COUNT(*) AS review_count FROM review WHERE order_item_id = " . $item['order_item_id'];
                    $existingReviewCheckResult = mysqli_query($db, $existingReviewCheckSql);

                    if ($existingReviewCheckResult) {
                        $existingReviewCheckRow = mysqli_fetch_assoc($existingReviewCheckResult);
                        $reviewCount = $existingReviewCheckRow['review_count'];
                        mysqli_free_result($existingReviewCheckResult);

                        if ($reviewCount > 0) {
                            // A review already exists, so disable the link
                            echo '<td class="text-center">Review</td>';
                        } else {
                            // No existing review, provide the link to review
                            echo '<td class="text-center"><a href="../../user/review.php?order_item_id=' . $item['order_item_id'] . '">Review</a></td>';
                        }
                    } else {
                        echo 'Error checking for existing reviews: ' . mysqli_error($db);
                    }

                    echo '</tr>';
                  }
                  echo '</table>';
                  echo '</div>';
                  echo '<div class="col-lg-12 text-right">';

                  echo '<div class="invoice-detail-item">';
                  echo '<div class="invoice-detail-name">Total</div>';
                  echo '<div class="invoice-detail-value invoice-detail-value-lg">' . $orderDetails['total_amount'] . '</div>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                  ?>
                  <hr>
                  <div class="text-md-right">
                    <button class="btn btn-warning btn-icon icon-left" onclick="window.print();"><i class="fas fa-print"></i> Print</button>
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

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>

</html>