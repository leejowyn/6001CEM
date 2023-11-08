<!DOCTYPE html>
<meta charset="utf-8">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>

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
                        <h2 class="form-title">Forgot Password</h2>
                        <form method="POST" class="register-form" action="resetpassword-code.php">

                        <?php
                            session_start();
                            if(isset($_SESSION['status']))
                            {
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
                            <p> We will send a link to reset your password </p> <br>
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="email" name="email" placeholder="Email" />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="password_reset" class="form-submit" value="Forgot Password" />
                            </div>
                            <a href="login.php" class="signup-image-link">Go back</a>
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