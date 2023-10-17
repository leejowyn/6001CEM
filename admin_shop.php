<?php
include 'connect.php';

if(isset($_POST['add-product'])){
  $product_name = $_POST['product_name'];
  $price = $_POST['price'];
  $category = $_POST['category'];
  $description = $_POST['description'];
  $stock = $_POST['stock'];
  $image = $_FILES['image']['name'];
  $tempname = $_FILES['image']['tmp_name'];
  $folder = 'uploads/'.$image;

  session_start();

  $query = mysqli_query($db, 'SELECT * FROM product WHERE product_name="'.$product_name.'"');
  
  if(empty($_POST['product_name'])||empty($_POST['price'])||empty($_POST['category'])||empty($_POST['stock'])||empty($_POST['description'])){
    echo "<script>alert('Please fill in all the details');window.location='admin_shop.php';</script>";
  }elseif(empty($_FILES['image']['name'])){
    echo "<script>alert('Please insert an image');window.location='admin_shop.php';</script>";
  }elseif(mysqli_num_rows($query)>0){
      $message[] = 'Item already exists';
  }
  else{
    $sql = "INSERT INTO product (product_name,price,category,description,stock,image,seller_id)VALUES
            ('$product_name','$price','$category','$description','$stock','$image',1)";

    // mysqli_query($db,$sql);

    $result = mysqli_query($db, $sql);

if (!$result) {
  $message[] = mysqli_error($db);
}
else{
  $message[] = "Product added successfully!";
}

    
    if(!move_uploaded_file($tempname,$folder)){
      $message[] = 'Sorry picture cannot upload!';
    }
  }
}

if(isset($_POST['update'])){
  $product_id = $_POST['edit_id'];
  $product_name = $_POST['product_name'];
  $price = $_POST['price'];
  $category = $_POST['category'];
  $description = $_POST['description'];
  $stock = $_POST['stock'];
  
  if(isset($_FILES['profile']['name'])&&($_FILES['profile']['name']!="")){
    $size = $_FILES['profile']['size'];
    $temp = $_FILES['profile']['tmp_name'];
    $type = $_FILES['profile']['type'];
    $profile_name = $_FILES['profile']['name'];
    // unlink("uploads/$old_image");
    move_uploaded_file($temp,"uploads/$profile_name");
  }else{
    $profile_name = $_FILES['profile']['name'];
  }

  $sql = "UPDATE product SET product_name='$product_name',price='$price',
          category='$category',description='$description',stock='$stock',image='$profile_name' WHERE product_id = $product_id";
  
  mysqli_query($db,$sql);

  $message[] = 'Product updated successfully!';
}

if(isset($_GET['delete'])){
	$delete_id = $_GET['delete'];
	mysqli_query($db, "DELETE FROM product WHERE product_id = '$delete_id'");
	header('location:admin_shop.php');
 }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Product</title>
    <script src="https://kit.fontawesome.com/a84d485a7a.js" crossorigin="anonymous"></script>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
  <body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="dashboard.html">Manage Product</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel"><i class="fa-solid fa-cat"></i> OrgaCare</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="admin_shop.php"><i class="fa-solid fa-shop"></i> Manage Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop_profile.php"><i class="fa-solid fa-hand-holding-dollar"></i>Shop Profile</a>
                </li>
              </ul>
              <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
              </form>
            </div>
          </div>
        </div>
      </nav><br><br><br>
      <div class="container col-6">
      <?php
      if(isset($message)){
      foreach($message as $message){
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-bell"></i> '.$message.
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        };
      };
      ?>
      <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
        <div class="">
        <h2><i class="fa-solid fa-cart-plus"></i> Add New Product</h2><br>
        <label>Product Name</label>
        <input type="text" name="product_name" placeholder="Product Name" class="form-control"><br>
        <label>Product Price</label>
        <input type="text" name="price" placeholder="Price" class="form-control"><br>
        <label>Product Description</label>
        <textarea name="description" placeholder="Item Description" rows="4" cols="50" class="form-control"></textarea><br>
        <div class="form-outline">
        <label class="form-label" for="typeNumber">Stock</label>
        <input type="number" id="typeNumber" name="stock"class="form-control" />
        </div><br>
        <label>Category</label><br>
        <select name="category">
          <option value="nuts">Nuts</option>
          <option value="snacks">Snacks</option>
          <option value="fruits">Fruits</option>
          <option value="seasoning">Seasoning</option>
          <option value="bake">Bake</option>
          <option value="baby">Baby</option>
        </select><br><br>
        <label>Insert Image</label>
        <input type="file" name="image" class="form-control" accept="image/png, image/jpg, image/jpeg"><br>
        <input type="submit" name="add-product" value="Add Item" class="btn btn-primary"><br>
      </form>
      <br>
      
      <?php 
      $sql = "SELECT * FROM product";
      $result = $db->query($sql);
      $db->close();
      ?>

      <table class="table table-striped table-hover">
        <tr>
          <th>Image</th>
          <th>Product Name</th>
          <th>Product Price</th>
          <th>Product Description</th>
          <th>Stock</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
        <?php 
        while($row = $result->fetch_assoc()){
        ?>
        <tr>
          <td><img src="uploads/<?php echo $row['image'];?>" width="100px" height="100px"></td>
          <td><?php echo $row['product_name']; ?></td>
          <td><?php echo $row['price']; ?></td>
          <td><?php echo $row['description']; ?></td>
          <td><?php echo $row['stock']; ?></td>
          <td><?php echo $row['category']; ?></td>
          <th>
            <button type="button" class="btn btn-success editBtn" data-bs-toggle="modal" 
            data-bs-target="#editModal<?php echo $row['product_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
            <br><br>
            <a href="admin_shop.php?delete=<?php echo $row['product_id']; ?>" 
            onclick="return confirm('Delete this item?')" class="btn btn-danger">
			      <i class="fas fa-trash"></i></a>
        </th>
        </tr>
      <!--Edit Modal Pop Up-->
      <div class="modal fade" id="editModal<?php echo $row['product_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-pen-to-square"></i> Edits</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
          <form action="" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label><b>Product Name</b></label>
                <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label><b>Price</b></label>
                <input type="text" name="price" value="<?php echo $row['price']; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label><b>Product Description</b></label>
                <input type="text" name="description" value="<?php echo $row['description']; ?>" class="form-control">
              </div><br>
              <div class="form-group">
                <label><b>Stock</b></label>
                <input type="text" name="stock" value="<?php echo $row['stock']; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label><b>Category</b></label>
                <input type="text" name="category" value="<?php echo $row['category']; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label><b>Insert Image</b></label>
                <input type="file" name="profile" class="form-control form-control-sm" accept="image/png, image/jpg, image/jpeg">
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="edit_id" value="<?php echo $row['product_id']; ?>">
              <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="update">Save Changes</button>
            </div>
          </form>
          </div>
        </div>
      </div><?php } ?>
      </table>
      <!--container end-->
    </div>
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>