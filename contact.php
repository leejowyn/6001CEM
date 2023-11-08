<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

$mail = new PHPMailer(true);
$alert = '';

if (isset($_POST['submit'])) {
  $username = ($_POST['username']);
  $email = $_POST['email'];
  $message = $_POST['message'];
  $okay = true;
  if (empty($username) && empty($email) && empty($message)) {
    $alert = '<div class="alert alert-danger" role="alert">Please fill out all the fields</div>';
    $okay = false;
  } else {
    if (empty($username)) {
      $alert = '<div class="alert alert-danger" role="alert">Fill in your name</div>';
      $okay = false;
    } else if (ctype_alpha(str_replace(' ', '', $username)) == false) {
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
      $mail->Body = '<h3>Name: ' . $username . '<br>Message: ' . $message . '</h3>';

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
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <?php include 'header.php'; ?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Contact Us</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <span>Contact Us</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_phone"></span>
                        <h4>Phone</h4>
                        <p>+60 194 459 223</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_pin_alt"></span>
                        <h4>Address</h4>
                        <p>60 Road 14000 Johor</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_clock_alt"></span>
                        <h4>Open time</h4>
                        <p>support 24/7 time</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_mail_alt"></span>
                        <h4>Email</h4>
                        <p>orgacare@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->


    <!-- Contact Form Begin -->
    <div class="contact-form spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2>Leave Message</h2>
                        <?php echo $alert; ?>
                    </div>
                </div>
            </div>
            <form action="contact.php" method="post" id="contact" novalidate="novalidate">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <input type="text" name="username" id="username" placeholder="Your name">
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <input type="email" name="email" id="email" placeholder="Your Email">
                    </div>
                    <div class="col-lg-12 text-center">
                        <textarea name="message" id="message" placeholder="Your message"></textarea>
                        <button type="submit" name="submit" class="site-btn">SEND MESSAGE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Contact Form End -->

    <?php include 'footer.php'; ?>


    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>



</body>

</html>