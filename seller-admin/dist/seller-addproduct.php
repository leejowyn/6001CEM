<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Add Product</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
  <script src="https://kit.fontawesome.com/a84d485a7a.js" crossorigin="anonymous"></script>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <?php include 'seller-header.php'; ?>
  <?php
include '../../connect.php';

if (isset($_POST['add-product'])) {
  $product_name = $_POST['product_name'];
  $price = $_POST['price'];
  $category = $_POST['category'];
  $description = $_POST['description'];
  $stock = $_POST['stock'];
  $image = $_FILES['image']['name'];
  $tempname = $_FILES['image']['tmp_name'];
  $folder = 'uploads/' . $image;


  $query = mysqli_query($db, 'SELECT * FROM product WHERE product_name="' . $product_name . '"');

  if (empty($_POST['product_name']) || empty($_POST['price']) || empty($_POST['category']) || empty($_POST['stock']) || empty($_POST['description'])) {
    echo "<script>alert('Please fill in all the details');window.location='seller-addproduct.php';</script>";
  } elseif (empty($_FILES['image']['name'])) {
    echo "<script>alert('Please insert an image');window.location='seller-addproduct.php';</script>";
  } elseif (mysqli_num_rows($query) > 0) {
    $message[] = 'Item already exists';
  } else {
    $seller_id = $_SESSION['seller_id'];
    $sql = "INSERT INTO product (product_name,price,category,description,stock,image,seller_id)VALUES
            ('$product_name','$price','$category','$description','$stock','$image', '$seller_id')";

    // mysqli_query($db,$sql);

    $result = mysqli_query($db, $sql);

    if (!$result) {
      $message[] = mysqli_error($db);
    } else {
      $message[] = "Product added successfully!";
    }


    if (!move_uploaded_file($tempname, $folder)) {
      $message[] = 'Sorry picture cannot upload!';
    }
  }
}
?>
  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Add Product</h1>
        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="seller-dashbaord.php">Dashboard</a></div>
          <div class="breadcrumb-item"><a href="seller-showproduct.php">Products</a></div>
          <div class="breadcrumb-item">Add New Products</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Create New Products</h2>
        <p class="section-lead">
          On this page you can add new products and fill in all fields.
        </p>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Add Your Product</h4>
              </div>
              <div class="card-body">
                <?php
                if (isset($message)) {
                  foreach ($message as $message) {
                  echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                  ' . $message .
                  '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                  };
                };
                ?>
                <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Product Name</label>
                    <div class="col-sm-12 col-md-7">
                      <input type="text" name="product_name" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Product Price</label>
                    <div class="col-sm-12 col-md-7">
                      <div class="input-group">
                        <span class="input-group-text">RM</span>
                        <input type="text" name="price" class="form-control" placeholder="Enter the price">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Product Description</label>
                    <div class="col-sm-12 col-md-7">
                      <textarea name="description" placeholder="Item Description" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="typeNumber">Product Stock</label>
                    <div class="col-sm-12 col-md-7">
                      <input type="number" id="typeNumber" name="stock" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                    <div class="col-sm-12 col-md-7">
                      <select class="form-control selectric" name="category">
                        <option value="Fresh-Meat">Fresh Meat</option>
                        <option value="Vegetables">Vegetables</option>
                        <option value="Fruit">Fruit</option>
                        <option value="Nut">Nut</option>
                        <option value="Grains">Grains</option>
                        <option value="Dairy-Product">Dairy Product</option>
                        <option value="Baby">Baby</option>
                        <option value="Seasoning">Seasoning</option>
                        <option value="Snacks">Snacks</option>
                        <option value="Bake">Bake</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Insert Image</label>
                    <div class="col-sm-12 col-md-7">
                      <div id="image-preview" class="image-preview">
                        <label for="image-upload" id="image-label">Choose File</label>
                        <input type="file" name="image" class="form-control" id="image-upload" accept="image/png, image/jpg, image/jpeg" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7">
                      <input type="submit" name="add-product" value="Add Item" class="btn btn-primary">
                    </div>
                  </div>
                </form>
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

  <script src="assets/modules/summernote/summernote-bs4.js"></script>
  <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
  <script src="assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
  <script src="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/features-post-create.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>

</html>