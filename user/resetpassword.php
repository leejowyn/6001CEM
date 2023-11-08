<!DOCTYPE html>
<meta charset="utf-8">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>

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
                        <figure><img src="images/forgotp.gif" alt="sing up image"></figure>
                    </div>
                    <div class="signin-form">
                        <h2 class="form-title">Reset Password</h2>

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
                        <form method="POST" class="register-form" action="resetpassword-code.php">
                            <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {
                                                                                    echo $_GET['token'];
                                                                                } ?>">
                            <p> Enter your new password </p> <br>
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="email" name="email" value="<?php if (isset($_GET['email'])) {
                                                                            echo $_GET['email'];
                                                                        } ?>" placeholder="Email" />
                            </div>
                            <div class="form-group">
                                <label for="new_password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="text" name="new_password" id="new_password" placeholder="New Password" />
                            </div>
                            <div class="form-group">
                                <label for="confirm_password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="text" name="confirm_password" id="confirm_password" placeholder="Confirm Password" />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="password_update" class="form-submit" value="Submit" />
                            </div>
                            <a href="forgetpassword.php" class="signup-image-link">Go back</a>
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