<?php
session_start();
$page = "";
include "../connect.php";

$signinemailErr = $signinpasswordErr = "";
$okay = true;

if (isset($_POST['signin'])) {
    $signinemail = $_POST['email'];
    $signinpassword = $_POST['password'];


    if (!filter_var($signinemail, FILTER_VALIDATE_EMAIL)) {
        $signinemailErr = "* Invalid E-mail address" . "<br>";
        $okay = false;
    }

    if ($okay) {

        //retrieve and check whether this email and password is exist
        $query = "SELECT * FROM user WHERE email = '$signinemail'";

        if ($result = mysqli_query($db, $query)) {
            if (mysqli_num_rows($result) == 0) {
                $signinemailErr = "* Couldn't find that E-mail address. Check the spelling and try again." . "<br>";
                $okay = false;
            } else {
                if ($r = mysqli_query($db, $query)) {
                    if (mysqli_num_rows($r) > 0) {
                        $row = mysqli_fetch_array($r);
                        $hashedPasswordFromDB = $row['password'];

                        if (password_verify($signinpassword, $hashedPasswordFromDB)) {
                            // Password is correct, perform the login actions
                            $_SESSION['user_id'] = $row['user_id'];
        
                            echo "<script>
                                window.setTimeout(function () {
                                    window.location.href = '../index.php';
                                }, 100);
                            </script>";
                        }else {
                            $signinpasswordErr = "The password that you've entered is incorrect. Please try again." . "<br>";
                        }
                    } else {
                        $signinemailErr = "* Couldn't find that E-mail address" . "<br>";
                    }
                }
            }
        }
        //close database
        mysqli_close($db);
    }
}
?>
<!DOCTYPE html>
<meta charset="utf-8">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="main">

    
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/login.gif" alt="sing up image"></figure>
                        <a href="register.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign In</h2>
                        <?php
                        echo $signinemailErr;
                        echo $signinpasswordErr; 
                        ?><br>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="email" placeholder="Email" />
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <a href="forgetpassword.php" class="signup-image-link">Forget Password?</a>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>