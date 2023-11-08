<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include '../connect.php';

    session_start();

    $username = $email = $password = $address = "";
    $usernameErr = $emailErr = $passwordErr = $allErr = "";

    if (isset($_POST['signup'])) {

        $username = ucwords(strtolower($_POST['username']));
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];

        //password validation
        $number = preg_match('@[0-9]@', $password);
        $upperCase = preg_match('@[A-Z]@', $password);
        $lowerCase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        $okay = true;

        //username validation
        if (!ctype_alpha(str_replace(' ', '', $username))) {
            $usernameErr = "* Only letters and spaces are allowed" . "<br>";
            $okay = false;
        }

        //email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "* Invalid E-mail address" . "<br>";
            $okay = false;
        } else {
            $query = "SELECT * FROM user WHERE email = '$email'";

            if ($result = mysqli_query($db, $query)) {
                if (mysqli_num_rows($result) == 1) {
                    $okay = false;
                    $emailErr = "* Email address is already in use." . "<br>";
                }
            } else {
                echo 'Error: ' . mysqli_error($db);
            }
        }

        //password validation
        if (strlen($password) < 8 || !$number || !$upperCase || !$lowerCase || !$specialChars) {
            $passwordErr = "* Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character." . "<br>";
            $okay = false;
        }
        if ($okay) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO user (user_id, username, email, password, address, reset_token )
          VALUES (0,'$username', '$email', '$hashed_password', '$address', NULL )";

            if (mysqli_query($db, $query)) {

                $query = "SELECT * FROM user WHERE email = '$email'";

                if ($r = mysqli_query($db, $query)) {
                    $row = mysqli_fetch_array($r);
                    $_SESSION['user_id'] = $row['user_id'];
                } else {
                    echo mysqli_error($db);
                }
            } else {
                echo 'Error: ' . mysqli_error($db);
            }
            header('location:login.php');
        }
    }
    ?>
    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>

                        <?php echo $usernameErr;
                        echo $emailErr;
                        echo $passwordErr; ?><br>

                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="name" placeholder="Your Name" />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="text" name="address" id="address" placeholder="Address" />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup.gif" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">I am already member</a>
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