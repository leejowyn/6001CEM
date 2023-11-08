<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>All Product</title>

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
    <?php include 'seller-header.php'; ?>
    <?php include '../../connect.php';

    // Add this code to retrieve data from the database
    $result = mysqli_query($db, "SELECT * FROM product WHERE seller_id= ' $seller_id'");

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        mysqli_query($db, "DELETE FROM product WHERE product_id = '$delete_id'");
        header('location:seller-showproduct.php');
    }

    ?>

    <!-- Main Content -->
    <div class="main-content">

        <section class="section">
            <div class="section-header">
                <h1>Products</h1>
                <div class="section-header-button">
                    <a href="seller-addproduct.php" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="seller-dashbaord.php">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="seller-addproduct.php">Products</a></div>
                    <div class="breadcrumb-item">All Products</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Products</h2>
                <p class="section-lead">
                    You can manage all products, such as editing, deleting, and more.
                </p>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Products</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">All <span class="badge badge-white"><?php
                                                                                                                    $query = "SELECT * FROM product WHERE seller_id = '$seller_id'";
                                                                                                                    $result = mysqli_query($db, $query);

                                                                                                                    if ($result) {
                                                                                                                        $total_count = mysqli_num_rows($result);
                                                                                                                        echo $total_count;
                                                                                                                    }
                                                                                                                    ?></span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="float-right">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr>
<td>
    <a href="uploads/<?php echo $row['image']; ?>" data-lightbox="product-images">
        <img src="uploads/<?php echo $row['image']; ?>" width="100px" height="100px">
    </a>
</td>
                                                <td><?php echo $row['product_name']; ?><br><a href="#"><?php echo $row['category']; ?></a></td>
                                                <td> RM <?php echo $row['price']; ?></td>
                                                <td><?php echo $row['description']; ?></td>
                                                <td><?php echo $row['stock']; ?></td>
                                                <td>
                                                    <a class="btn btn-primary btn-action mr-1" href="seller-edit.php?product_id=<?php echo $row['product_id']; ?>" data-toggle="tooltip" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="location.href='seller-showproduct.php?delete=<?php echo $row['product_id']; ?>'">
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
        </section>
    </div>
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

    <!-- JS Libraries -->
    <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
    <script src="assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
    <script src="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="assets/js/page/features-posts.js"></script>

    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>