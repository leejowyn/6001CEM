<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Seller's Order</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <?php include 'seller-header.php'; ?>
  <?php include '../../connect.php';

  $seller_id = $_SESSION['seller_id'];

  $query = "SELECT o.order_id, u.username, u.address, o.order_date, o.total_amount, p.product_id, p.seller_id, oi.quantity, o.status
  FROM orders o
  JOIN user u ON o.user_id = u.user_id
  JOIN order_items oi ON o.order_id = oi.order_id
  JOIN product p ON oi.product_id = p.product_id
  WHERE p.seller_id = $seller_id ";

  // Create a prepared statement
  $stmt = mysqli_prepare($db, $query);

  if ($stmt) {
    // Execute the query
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
      // Get the result
      $result = mysqli_stmt_get_result($stmt);
    } else {
      echo "Error executing the query: " . mysqli_error($db);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
  } else {
    echo "Error preparing the statement: " . mysqli_error($db);
  }


  $totalCount = mysqli_num_rows($result);

  $message = '';
  if (isset($_POST['update'])) {
    foreach ($_POST['order_id'] as $order_id => $value) {
      $status = $_POST['status'][$order_id];

      // Update the order status in the database for each order
      $updateQuery = "UPDATE orders SET status = '$status' WHERE order_id = $order_id";
      if (mysqli_query($db, $updateQuery)) {
        $message = '<div class="alert alert-success alert-dismissible">
                Status updated successfully
            </div>';
      } else {
        $message = '<div class="alert alert-danger alert-dismissible">
                Error updating status: ' . mysqli_error($db) . '
            </div>';
      }
    }
  }

  ?>
  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Orders</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="seller-dashboard.php">Dashboard</a></div>
          <div class="breadcrumb-item">All Orders</div>
        </div>
      </div>
      <div class="section-body">
        <h2 class="section-title">Order's Listing</h2>
        <p class="section-lead">
          Manage all orders, such as pending, approved, and shipped.
        </p>

        <div class="row">
          <div class="col-12">
            <div class="card mb-0">
              <div class="card-body">
                <ul class="nav nav-pills" id="myTab3" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">All<span class="badge badge-white"><?php echo $totalCount; ?></span></a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent2">
                  <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                    <div class="card-header">
                      <h4>All Orders</h4>
                    </div>
                    <div class="card-body">
                      <?php echo $message; ?>
                      <div class="clearfix mb-3"></div>
                      <form method="post" class="needs-validation" action="">
                        <table class="table table-striped">
                          <tr>
                            <th>Order</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                          <?php
                          while ($row = mysqli_fetch_assoc($result)) {
                          ?>
                            <tr>
                              <td><?php echo $row['order_id']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td><?php echo $row['address']; ?></td>
                              <td>RM<?php echo $row['total_amount']; ?></td>
                              <td><?php echo $row['order_date']; ?></td>
                              <td>
                                <select class="form-control selectric" name="status[<?php echo $row['order_id']; ?>]">
                                  <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                  <option value="Approved" <?php echo ($row['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                                  <option value="Shipped" <?php echo ($row['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                </select>

                              </td>
                              <td>
                                <input type="hidden" name="order_id[<?php echo $row['order_id']; ?>]" value="<?php echo $row['order_id']; ?>">

                                <button type="submit" class="btn btn-primary" name="update">Save</button>

                              </td>
                            </tr>
                          <?php
                          }
                          ?>
                        </table>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>