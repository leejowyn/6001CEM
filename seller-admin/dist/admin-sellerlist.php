<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>List of Seller</title>

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

    // Retrieve all sellers
    $result = mysqli_query($db, "SELECT * FROM seller");

    if (isset($_GET['approve'])) {
        $seller_id = $_GET['approve'];

        // Update the seller's status to "Approved" in the database
        $sql = "UPDATE seller SET seller_status = 'Approved' WHERE seller_id = '$seller_id'";
        if (mysqli_query($db, $sql)) {
            // Success message or redirection
            echo 'Seller status updated to Approved successfully.';
            // You can add a redirection header here if needed
        } else {
            // Error message
            echo 'Error updating seller status.';
        }
    }

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        mysqli_query($db, "DELETE FROM seller WHERE seller_id = '$delete_id'");
        header('location:admin-sellerlist.php');
    }

    $totalCount = mysqli_num_rows($result);

    ?>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Seller's Listing</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="seller-dashboard.php">Dashboard</a></div>
                    <div class="breadcrumb-item">All Seller</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Seller's Listing</h2>
                <p class="section-lead">
                    Manage all seller, such as view, approved, and deleting.
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">All<span class="badge badge-white"><?php echo $totalCount; ?></span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="true">Pending<span class="badge badge-white"></span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#contact3" role="tab" aria-controls="contact" aria-selected="false">Approved<span class="badge badge-white"></span></a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                                        <div class="card-header">
                                            <h4>All Sellers</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="clearfix mb-3"></div>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Organic Certificate</th>
                                                        <th>Address (State)</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <?php
                                                    while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $row['seller_name']; ?></td>
                                                            <td><?php echo $row['seller_email']; ?></td>
                                                            <td>
                                                                <a href="cert/<?php echo $row['organic_cert']; ?>" data-lightbox="organic-cert-gallery">
                                                                    <img src="cert/<?php echo $row['organic_cert']; ?>" alt="Organic Certification" width="100px" height="100px">
                                                                </a>
                                                            </td>
                                                            <td><?php echo $row['seller_state']; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($row['seller_status'] === 'Pending') {
                                                                    echo '<div class="badge badge-warning">Pending</div>';
                                                                } elseif ($row['seller_status'] === 'Approved') {
                                                                    echo '<div class="badge badge-primary">Approved</div>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="location.href='admin-sellerlist.php?delete=<?php echo $row['seller_id']; ?>'">
                                                                    <i class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                                        <div class="card-header">
                                            <h4>Seller's waiting for Approved</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="clearfix mb-3"></div>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Organic Certificate</th>
                                                        <th>Address (State)</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <?php
                                                    // Retrieve sellers with 'Pending' status
                                                    $pendingSellers = mysqli_query($db, "SELECT * FROM seller WHERE seller_status = 'Pending'");

                                                    while ($row = $pendingSellers->fetch_assoc()) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $row['seller_name']; ?></td>
                                                            <td><?php echo $row['seller_email']; ?></td>
                                                            <td>
                                                                <a href="cert/<?php echo $row['organic_cert']; ?>" data-lightbox="organic-cert-gallery">
                                                                    <img src="cert/<?php echo $row['organic_cert']; ?>" alt="Organic Certification" width="100px" height="100px">
                                                                </a>
                                                            </td>
                                                            <td><?php echo $row['seller_state']; ?></td>
                                                            <td>
                                                                <div class="badge badge-warning">Pending</div>
                                                            </td>
                                                            <td><a class="btn btn-success btn-action" data-toggle="tooltip" title="Approve" data-confirm="Change status from Pending to Approved?" data-confirm-yes="location.href='admin-sellerlist.php?approve=<?php echo $row['seller_id']; ?>'">
                                                                    <i class="fas fa-check"></i>
                                                                </a>


                                                                <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="location.href='admin-sellerlist.php?delete=<?php echo $row['seller_id']; ?>'">
                                                                    <i class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact-tab3">
                                        <div class="card-header">
                                            <h4>Approved's Seller</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="clearfix mb-3"></div>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Organic Certificate</th>
                                                        <th>Address (State)</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <?php
                                                    // Retrieve sellers with 'Approved' status
                                                    $approvedSellers = mysqli_query($db, "SELECT * FROM seller WHERE seller_status = 'Approved'");

                                                    while ($row = $approvedSellers->fetch_assoc()) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $row['seller_name']; ?></td>
                                                            <td><?php echo $row['seller_email']; ?></td>
                                                            <td>
                                                                <a href="cert/<?php echo $row['organic_cert']; ?>" data-lightbox="organic-cert-gallery">
                                                                    <img src="cert/<?php echo $row['organic_cert']; ?>" alt="Organic Certification" width="100px" height="100px">
                                                                </a>
                                                            </td>
                                                            <td><?php echo $row['seller_state']; ?></td>
                                                            <td>
                                                                <div class="badge badge-primary">Approved</div>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="location.href='admin-sellerlist.php?delete=<?php echo $row['seller_id']; ?>'">
                                                                    <i class="fas fa-trash"></i></a>
                                                            </td>
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