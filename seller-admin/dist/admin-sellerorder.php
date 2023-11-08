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

    <!-- Lightbox2 CSS -->
    <link rel="stylesheet" href="path-to-lightbox2/css/lightbox.min.css">

    <!-- Lightbox2 JS -->
    <script src="path-to-lightbox2/js/lightbox.min.js"></script>

</head>

<body>
    <?php include 'admin-nav.php'; ?>
    <?php include '../../connect.php';

    $query = "SELECT o.order_id, s.seller_name, o.order_date, o.total_amount, o.status
    FROM orders o
    JOIN order_items oi ON oi.order_id = o.order_id
    JOIN product p ON oi.product_id = p.product_id
    JOIN seller s ON p.seller_id = s.seller_id";

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

    ?>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Order List</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="seller-dashboard.php">Dashboard</a></div>
                    <div class="breadcrumb-item">Order List</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Order List</h2>
                <p class="section-lead">
                    See al the seller's orders
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
                                            <h4>Order Details</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="clearfix mb-3"></div>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Seller Name</th>
                                                        <th>Order Date</th>
                                                        <th>Total Amount</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    <?php
                                                    while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $row['order_id']; ?></td>
                                                            <td><?php echo $row['seller_name']; ?></td>
                                                            <td><?php echo $row['order_date']; ?></td>
                                                            <td><?php echo $row['total_amount']; ?></td>
                                                            <td><?php echo $row['status']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
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
    <footer class="main-footer">
        <div class="footer-right">
        </div>
    </footer>
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

    <!-- JS Libraries -->
    <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="assets/js/page/features-posts.js"></script>

    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>