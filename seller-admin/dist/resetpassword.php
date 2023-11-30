<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Forget Password</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">

</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/orgalogo.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Reset Password</h4></div>
              <?php
                        session_start();
                        if (isset($_SESSION['status'])) {
                        ?>
                            <div class="alert alert-success">
                                <h5>
                                    <?= $_SESSION['status']; ?>
                                </h5>
                            </div>
                        <?php
                            unset($_SESSION['status']);
                        }
                        ?>
            <form method="POST" class="register-form" action="resetpassword-seller.php">
            <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {
                                                                                    echo $_GET['token'];
                                                                                } ?>">
              <div class="card-body">
                <p class="text-muted">Enter your new password</p>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="seller_email" tabindex="1" value="
                    <?php if (isset($_GET['seller_email'])) {echo $_GET['seller_email'];} ?>"  />
                  </div>

                  <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input id="new_password" type="text" class="form-control pwstrength" data-indicator="pwindicator" name="new_password" tabindex="2" required>
                    <div id="pwindicator" class="pwindicator">
                      <div class="bar"></div>
                      <div class="label"></div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input id="confirm_password" type="text" class="form-control" name="confirm_password" tabindex="2" required>
                  </div>

                  <div class="form-group">
                    <input type="submit" name="password_update" class="btn btn-primary btn-lg btn-block" value="Submit" tabindex="4">
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
