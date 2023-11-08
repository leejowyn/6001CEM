<?php
include('../../connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../../phpmailer/Exception.php';
require_once '../../phpmailer/PHPMailer.php';
require_once '../../phpmailer/SMTP.php';

function send_password_reset($get_name, $get_email, $token){
    $mail = new PHPMailer(true);
    $mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'Jowyn2002@gmail.com'; // Gmail address which you want to use as SMTP server
	$mail->Password = 'buqrxthlvjcrayoj    '; // Gmail address Password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	$mail->Port = '587';

	$mail->setFrom('Jowyn2002@gmail.com', 'OrgaCare'); // Gmail address which you used as SMTP server
	$mail->addAddress($get_email); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

	$mail->isHTML(true);
	$mail->Subject = 'Reset Password';
	
    $email_template = "<p>Click the following link to reset your password: </p>
                        <a href='http://localhost/orgacare/seller-admin/dist/resetpassword.php?token=$token&email=$get_email'>Click Me</a>";

    $mail->Body = $email_template;
    $mail->send();
}

session_start();
if(isset($_POST['password_reset'])){
    $seller_email = mysqli_real_escape_string($db, $_POST['seller_email']);
    $token = md5(rand());

    $check_email = "SELECT seller_name, seller_email FROM seller WHERE seller_email='$seller_email' LIMIT 1";
    $check_email_run = mysqli_query($db, $check_email);
    $row = mysqli_fetch_array($check_email_run);

    if ($row) {
        $get_name = $row['seller_name'];
        $get_email = $row['seller_email'];
        $update_token = "UPDATE seller SET reset_token='$token' WHERE seller_email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($db, $update_token);

        if ($update_token_run) {
            // Assuming send_password_reset() is a valid function that sends reset instructions.
            send_password_reset($get_name, $get_email, $token);
            $_SESSION['status'] = "Password reset instructions sent to your email.";
            header("Location: sellerforgetpassword.php");
            exit(0);
        } else {
            $_SESSION['status'] = "Error updating reset token.";
            header("Location: sellerforgetpassword.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No Email Found";
        header("Location: sellerforgetpassword.php");
        exit(0);
    }
}

if (isset($_POST['password_update'])) {
    $seller_email = mysqli_real_escape_string($db, $_POST['seller_email']);
    $new_password = mysqli_real_escape_string($db, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);

    $token = mysqli_real_escape_string($db, $_POST['password_token']);

    if (!empty($token)) {

        if (!empty($seller_email) && !empty($new_password) && !empty($confirm_password)) {
            // Checking Token is valid or not
            $check_token = "SELECT reset_token FROM seller WHERE reset_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($db, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                if ($new_password == $confirm_password) {
                    // Hash the new password before storing it
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                    $update_password = "UPDATE seller SET seller_password='$hashed_password' WHERE reset_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($db, $update_password);

                    if ($update_password_run) {
                        // Update the token before redirecting
                        $new_token = md5(rand()) . "New Token"; // Generate a new token here
                        $update_to_new_token = "UPDATE seller SET reset_token='$new_token' WHERE reset_token='$token' LIMIT 1";
                        $update_to_new_token_run = mysqli_query($db, $update_to_new_token);

                        header("Location: seller-login.php");
                        exit(0);
                    } else {
                        $_SESSION['status'] = "There is an error. Your password was not updated!" . mysqli_error($db);
                        header("Location: resetpassword.php?token=$token&seller_email=$seller_email");
                        exit(0);
                    }

                } else {
                    $_SESSION['status'] = "Password and Confirm Password do not match";
                    header("Location: resetpassword.php?token=$token&seller_email=$seller_email");
                    exit(0);
                }

            } else {
                $_SESSION['status'] = "Invalid token";
                header("Location: resetpassword.php?token=$token&seller_email=$seller_email");
                exit(0);
            }

        } else {
            $_SESSION['status'] = "Please fill in all the fields";
            header("Location: resetpassword.php?token=$token&seller_email=$seller_email");
            exit(0);
        }

    } else {
        $_SESSION['status'] = "No Token Available";
        exit(0);
    }
}

?>