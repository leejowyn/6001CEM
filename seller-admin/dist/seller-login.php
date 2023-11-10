<?php
session_start();
$page = "";
include "../../connect.php";

$signinemailErr = $signinpasswordErr = "";
$okay = true;

if (isset($_POST['signin'])) {
  $signinemail = $_POST['seller_email'];
  $signinpassword = $_POST['seller_password'];

  if (!filter_var($signinemail, FILTER_VALIDATE_EMAIL)) {
    $signinemailErr = "* Invalid E-mail address" . "<br>";
    $okay = false;
  }

  if ($okay) {

    // Retrieve and check whether this email and password exist
    $query = "SELECT * FROM seller WHERE seller_email = '$signinemail'";

    if ($result = mysqli_query($db, $query)) {
      if (mysqli_num_rows($result) == 0) {
        $signinemailErr = "* Couldn't find that E-mail address. Check the spelling and try again." . "<br>";
        $okay = false;
      } else {
        $row = mysqli_fetch_array($result);

        // Check the seller's status (assuming 'seller_status' is the field in the table)
        $sellerStatus = $row['seller_status'];

        if ($sellerStatus == 'Pending') {
          // Seller is pending, don't allow login
          $signinemailErr = "Your seller account is pending approval.". "<br>". "You cannot log in at the moment. Wait for 3-5 days" . "<br>";
        } else {
          // Seller is approved, continue with the password verification
          $hashedPasswordFromDB = $row['seller_password'];

          if (password_verify($signinpassword, $hashedPasswordFromDB)) {
            // Password is correct, perform the login actions
            $_SESSION['seller_id'] = $row['seller_id'];

            echo "<script>
                window.setTimeout(function () {
                    window.location.href = 'seller-dashboard.php';
                }, 100);
            </script>";
          } else {
            $signinpasswordErr = "The password that you've entered is incorrect. Please try again." . "<br>";
          }
        }
      }
    }
    // Close the database
    mysqli_close($db);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="sign-in">
      <div class="container mt-2">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/orgalogo.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <?php
              echo $signinemailErr;
              echo $signinpasswordErr;
              ?>

              <div class="card-body">
                <form method="POST" class="needs-validation" id="login-form" novalidate="">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="seller_email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="sellerforgetpassword.php" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="seller_password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>

                  <div class="form-group">
                    <input type="submit" name="signin" id="signin" class="btn btn-primary btn-lg btn-block" tabindex="4" value="Log in" />
                  </div>

                  <div class="mt-3 text-muted text-center">
                    Don't have an account? <a href="seller-register.php">Create One</a>
                  </div>
                </form>
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

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
