<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>

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

    <style>
        #logout-button {
            color: white;
            /* Set the initial text color */
            transition: color 0.3s;
            /* Add a smooth transition for color changes */
        }

        #logout-button:hover {
            color: black;
            /* Change the text color to black on hover */
        }

        .form-group {
            width: 50%;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <?php
    session_start();

    if (isset($_POST['logout'])) {
        session_destroy();
        echo '<script>window.location.href = "user/login.php";</script>';
    }

    include 'connect.php';
    include 'header.php';

    $messages = []; // Create an array for messages

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        if (isset($_POST['update'])) {
            $username = $_POST['username'];
            $address = $_POST['address'];

            $sql = "UPDATE user SET username='$username', address='$address' WHERE user_id = $user_id";

            if (mysqli_query($db, $sql)) {
                $messages[] = 'Updated successfully!';
            } else {
                $messages[] = 'Update failed: ' . mysqli_error($db);
            }
        }

        // Retrieve user data
        $query = "SELECT username, email, address FROM user WHERE user_id = $user_id";
        $result = mysqli_query($db, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username = $row['username'];
            $email = $row['email'];
            $address = $row['address'];
        } else {
            $messages[] = 'User not found.';
        }
    } else {
        $messages[] = 'User not logged in.';
    }
    ?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>User Profile</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <span>User Profile</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <!-- Form Begin -->
    <div class="contact-form spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2>User Profile</h2>
                    </div>
                </div>
            </div>
            <form method="POST">
                <div class="form-group">
                    <?php
                    if (!empty($messages)) {
                        foreach ($messages as $message) {
                            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                        ' . $message . '</div>';
                        }
                    }
                    ?>
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="username" value="<?php echo $username; ?>" placeholder="Enter your name" class="form-control" required="">
                </div>

                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter your email" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label for="address">Your Address</label>
                    <input type="text" id="address" name="address" value="<?php echo $address; ?>" placeholder="Enter your address" class="form-control">
                </div>

                <div class="text-center">
                    <input type="hidden" name="edit_id" value="<?php echo $user_id; ?>">
                    <button type="submit" class="site-btn" name="update">Update</button>
                    <button type="button" class="site-btn" onclick="redirectToForgetPassword()">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Form End -->


    <?php include 'footer.php'; ?>

    <script>
        function redirectToForgetPassword() {
            // Redirect to the forgetpassword.php file
            window.location.href = "user/forgetpassword.php";
        }
    </script>


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