<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../../phpmailer/Exception.php';
require_once '../../phpmailer/PHPMailer.php';
require_once '../../phpmailer/SMTP.php';

$mail = new PHPMailer(true);
$alert = '';

if (isset($_POST['submit'])) {
  $name = ($_POST['name']);
  $email = $_POST['email'];
  $message = $_POST['message'];
  $okay = true;
  if (empty($name) && empty($email) && empty($message)) {
    $alert = '<div class="alert alert-danger" role="alert">Please fill out all the fields</div>';
    $okay = false;
  } else {
    if (empty($name)) {
      $alert = '<div class="alert alert-danger" role="alert">Fill in your name</div>';
      $okay = false;
    } else if (ctype_alpha(str_replace(' ', '', $name)) == false) {
      $alert = '<div class="alert alert-danger" role="alert">Only letters and spaces are allowed in the Name field</div>';
      $okay = false;
    }

    if (empty($email)) {
      $alert = '<div class="alert alert-danger" role="alert">Fill in email</div>';
      $okay = false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $alertMessages .= '<div class="alert alert-danger" role="alert">Invalid E-mail address.</div>';
      $okay = false;
    }

    if (empty($message)) {
      $alert = '<div class="alert alert-danger" role="alert">Fill in message.</div>';
      $okay = false;
    }
  }
  if ($okay) {
    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'Jowyn2002@gmail.com'; // Email used as SMTP server
      $mail->Password = 'buqrxthlvjcrayoj'; // Secret Gmail pasword
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = '587';

      $mail->setFrom($email);
      $mail->addAddress('Jowyn2002@gmail.com'); // Receiver

      $mail->isHTML(true);
      $mail->Subject = 'Message Received';
      $mail->Body = '<h3>Name: ' . $name . '<br>Message: ' . $message . '</h3>';

      $mail->send();
      $alert = '<div class="alert alert-success" role="alert">
              Your Message has been sent, Thank you for contacting us
            </div>';
    } catch (Exception $e) {
      $alert = '<div class="alert-error">
              ' . $e->getMessage() . '
            </div>';
    }
  }
}
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Contact</title>

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
          <div class="section-header-back">
              <a href="seller-dashboard.php" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
          <div class="col-12 col-md-10 offset-md-1 col-lg-10 offset-lg-1">
            <div class="login-brand">
              OrgaCare
            </div>
            <div class="card card-primary">
              <div class="row m-0">
                <div class="col-12 col-md-12 col-lg-5 p-0">
                  <div class="card-header text-center"><h4>Contact Us</h4></div>
                  <?php echo $alert; ?>
                  <div class="card-body">
                    <form action="seller-contact.php" method="POST" id="contact" novalidate="novalidate">
                      <div class="form-group floating-addon">
                        <label>Name</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="far fa-user"></i>
                            </div>
                          </div>
                          <input id="name" type="text" class="form-control" name="name" autofocus placeholder="Name">
                        </div>
                      </div>

                      <div class="form-group floating-addon">
                        <label>Email</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-envelope"></i>
                            </div>
                          </div>
                          <input id="email" type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" name="message" placeholder="Type your message" data-height="150"></textarea>
                      </div>

                      <div class="form-group text-right">
                        <button type="submit" name="submit" class="btn btn-round btn-lg btn-primary">
                          Send Message
                        </button>
                      </div>
                    </form>
                  </div>  
                </div>
                <div class="col-12 col-md-12 col-lg-7 p-0">
                <figure><img src="assets/img/contact.gif" alt="image"  style="width: 550px; height: 500px;"></figure>
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
  
  <!-- JS Libraies -->
  <script src="http://maps.google.com/maps/api/js?key=AIzaSyB55Np3_WsZwUQ9NS7DP-HnneleZLYZDNw&amp;sensor=true"></script>
  <script src="assets/modules/gmaps.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/utilities-contact.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>