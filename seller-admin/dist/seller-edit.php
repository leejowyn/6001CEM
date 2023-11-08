<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Edit Product</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <script src="https://kit.fontawesome.com/a84d485a7a.js" crossorigin="anonymous"></script>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">
    <link rel="stylesheet" href="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
    <?php include 'seller-header.php'; ?>
    <?php include '../../connect.php';

    // Retrieve product details based on the product_id parameter
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        $query = "SELECT * FROM product WHERE product_id = $product_id";
        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
        } else {
            echo "Product not found.";
            exit();
        }
    } else {
        echo "Product ID not provided.";
        exit();
    }

    if (isset($_POST['update'])) {
        $product_id = $_POST['edit_id'];
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $stock = $_POST['stock'];

        if (isset($_FILES['profile']['name']) && ($_FILES['profile']['name'] != "")) {
            $size = $_FILES['profile']['size'];
            $temp = $_FILES['profile']['tmp_name'];
            $type = $_FILES['profile']['type'];
            $profile_name = $_FILES['profile']['name'];
            // unlink("uploads/$old_image");
            move_uploaded_file($temp, "uploads/$profile_name");
        } else {
            $profile_name = $_FILES['profile']['name'];
        }

        $sql = "UPDATE product SET product_name='$product_name',price='$price',
            category='$category',description='$description',stock='$stock',image='$profile_name' WHERE product_id = $product_id";

        mysqli_query($db, $sql);

        $message[] = 'Product updated successfully!';
    }



    ?>

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Products</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="seller-dashbaord.php">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="seller-addproduct.php">Products</a></div>
                    <div class="breadcrumb-item">Edit Products</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Products</h2>
                <p class="section-lead">
                    You can edit products here.
                </p>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            <div class="section-header-back">
                         <a href="seller-showproduct.php" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                             </div>
                                <h4>Edit Products</h4>
                            </div>
                            <?php
                            if (isset($message)) {
                                foreach ($message as $message) {
                                    echo '<div class=" alert alert-info alert-dismissible fade show" role="alert">
                  ' . $message .
                                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                                };
                            };
                            ?>
                            <div class="card-body">
                                <div class="clearfix mb-3"></div>
                                    <form action="" method="post" enctype="multipart/form-data">

                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Product Name</b></label>
                                            <div class="col-sm-12 col-md-7">
                                            <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Price</b></label>
                                            <div class="col-sm-12 col-md-7">
                                                <div class="input-group">
                                                    <span class="input-group-text">RM</span>
                                                    <input type="text" name="price" value="<?php echo $product['price']; ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Product Description</b></label>
                                            <div class="col-sm-12 col-md-7">
                                            <input type="text" name="description" value="<?php echo $product['description']; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Stock</b></label>
                                            <div class="col-sm-12 col-md-7">
                                            <input type="number" name="stock" value="<?php echo $product['stock']; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Category</b></label>
                                            <div class="col-sm-12 col-md-7">
                                            <input type="text" name="category" value="<?php echo $product['category']; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Insert Image</b></label>
                                            <div class="col-sm-12 col-md-7">
                                            <input type="file" name="profile" class="form-control form-control-sm" accept="image/png, image/jpg, image/jpeg">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                            <div class="col-sm-12 col-md-7">
                                            <input type="hidden" name="edit_id" value="<?php echo $product_id; ?>">
                                            <button type="submit" class="btn btn-primary" name="update">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
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