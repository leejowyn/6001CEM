<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Profile</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">

  <!-- Lightbox2 CSS -->
  <link rel="stylesheet" href="path-to-lightbox2/css/lightbox.min.css">

  <!-- Lightbox2 JS -->
  <script src="path-to-lightbox2/js/lightbox.min.js"></script>


</head>

<body>
  <?php
  include 'seller-header.php';
  include '../../connect.php';

  if (isset($_POST['update'])) {
    $seller_id = $_POST['edit_id'];
    $seller_name = $_POST['seller_name'];
    $seller_phone = $_POST['seller_phone'];
    $seller_city = $_POST['seller_city'];
    $seller_state = $_POST['seller_state'];

    $sql = "UPDATE seller SET seller_name='$seller_name',
        seller_phone='$seller_phone',seller_city='$seller_city',seller_state='$seller_state' WHERE seller_id = $seller_id";

    mysqli_query($db, $sql);

    $message[] = 'Updated successfully!';
  }

  // Add this code to retrieve data from the database
  $seller_id = $_SESSION['seller_id']; 

  // Retrieve additional seller data
  $query = "SELECT seller_name, seller_email, seller_phone, seller_city, seller_state, seller_status, organic_cert FROM seller WHERE seller_id = $seller_id";
  $result = mysqli_query($db, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $seller_name = $row['seller_name'];
    $seller_email = $row['seller_email'];
    $seller_phone = $row['seller_phone'];
    $seller_city = $row['seller_city'];
    $seller_state = $row['seller_state'];
    $seller_status = $row['seller_status'];
    $organic_cert = $row['organic_cert'];
  } else {
    // Handle the case where the seller is not found
    echo 'Seller not found.';
  }
  ?>


  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="seller-dashboard.php">Dashboard</a></div>
          <div class="breadcrumb-item">Profile</div>
        </div>
      </div>
      <div class="section-body">
        <h2 class="section-title">Hi, <?php
                                      $seller_id = $_SESSION['seller_id'];

                                      if ($seller_id) {
                                        $query = "SELECT seller_name FROM seller WHERE seller_id = $seller_id";

                                        $result = mysqli_query($db, $query);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                          $row = mysqli_fetch_assoc($result);
                                          $seller_name = $row['seller_name'];

                                          echo $seller_name;
                                        } else {
                                          echo 'Seller not found.';
                                        }
                                      } else {
                                        echo '<a href="seller-login.php">Login</a>';
                                      }
                                      ?></h2>
        <p class="section-lead">
          Change information on this page.
        </p>
        <div class="row mt-sm-4">
          <div class="col-7 col-md-5 col-lg-3">
            <div class="card profile-widget">
              <a href="cert/<?php echo $organic_cert; ?>" data-lightbox="organic-cert-gallery">
                <img src="cert/<?php echo $organic_cert; ?>" alt="Organic Certification" width="225px" height="260px">
              </a>
            </div>
          </div>

          <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
              <form method="post" class="needs-validation" novalidate="">
                <div class="card-header">
                  <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-5 col-12">
                      <label>Seller Name</label>
                      <input type="text" name="seller_name" value="<?php echo $seller_name; ?>" class="form-control" required="">
                      <div class="invalid-feedback">
                        Please fill in the name
                      </div>
                    </div>
                    <div class="form-group col-md-5 col-12">
                      <label>Email</label>
                      <input type="text" name="seller_email" value="<?php echo $seller_email; ?>" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-5 col-12">
                      <label>City</label>
                      <input type="text" name="seller_city" value="<?php echo $seller_city; ?>" class="form-control" required="">
                      <div class="invalid-feedback">
                        Please fill in the City
                      </div>
                    </div>
                    <div class="form-group col-md-5 col-12">
                      <label>State</label>
                      <select class="form-control selectric" name="seller_state" required="">
                        <option value="Penang" <?php echo ($seller_state === 'Penang') ? 'selected' : ''; ?>>Penang</option>
                        <option value="Sabah" <?php echo ($seller_state === 'Sabah') ? 'selected' : ''; ?>>Sabah</option>
                        <option value="Johor" <?php echo ($seller_state === 'Johor') ? 'selected' : ''; ?>>Johor</option>
                        <option value="Kedah" <?php echo ($seller_state === 'Kedah') ? 'selected' : ''; ?>>Kedah</option>
                        <option value="Sarawak" <?php echo ($seller_state === 'Sarawak') ? 'selected' : ''; ?>>Sarawak</option>
                        <option value="Kelantan" <?php echo ($seller_state === 'Kelantan') ? 'selected' : ''; ?>>Kelantan</option>
                        <option value="Melacca" <?php echo ($seller_state === 'Melacca') ? 'selected' : ''; ?>>Melacca</option>
                        <option value="Pahang" <?php echo ($seller_state === 'Pahang') ? 'selected' : ''; ?>>Pahang</option>
                        <option value="Perak" <?php echo ($seller_state === 'Perak') ? 'selected' : ''; ?>>Perak</option>
                        <option value="Terengganu" <?php echo ($seller_state === 'Terengganu') ? 'selected' : ''; ?>>Terengganu</option>
                        <option value="Selangor" <?php echo ($seller_state === 'Selangor') ? 'selected' : ''; ?>>Selangor</option>
                        <option value="Perlis" <?php echo ($seller_state === 'Perlis') ? 'selected' : ''; ?>>Perlis</option>
                        <option value="Negeri Sembilan" <?php echo ($seller_state === 'Negeri Sembilan') ? 'selected' : ''; ?>>Negeri Sembilan</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-5 col-12">
                      <label>Seller Status</label>
                      <input type="text" name="seller_status" value="<?php echo $seller_status; ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-5 col-12">
                      <label>Phone</label>
                      <input type="text" name="seller_phone" value="<?php echo $seller_phone; ?>" class="form-control" required="">
                      <div class="invalid-feedback">
                        Please fill in the phone
                      </div>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <input type="hidden" name="edit_id" value="<?php echo $seller_id; ?>">
                    <button type="submit" class="btn btn-primary" name="update">Save Changes</button>
                    <a href="sellerforgetpassword.php" class="btn btn-danger">Reset Password</a>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
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

  <!-- JS Libraies -->
  <script src="assets/modules/summernote/summernote-bs4.js"></script>

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>

</html>
