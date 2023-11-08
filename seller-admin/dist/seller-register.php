<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Seller Register</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
    <?php
    include '../../connect.php';

    session_start();

    $seller_name = $seller_email =
    $seller_password = $seller_phone =
    $seller_city = $seller_state = "";
    $seller_nameErr = $seller_emailErr = $seller_passwordErr = $seller_phoneErr = $organic_certErr = $allErr = "";

    if (isset($_POST['signup'])) {

        $seller_name = ucwords(strtolower($_POST['seller_name']));
        $seller_email = $_POST['seller_email'];
        $seller_password = $_POST['seller_password'];
        $seller_phone = $_POST['seller_phone'];
        $seller_city = $_POST['seller_city'];
        $seller_state = $_POST['seller_state'];

        //password validation
        $number = preg_match('@[0-9]@', $seller_password);
        $upperCase = preg_match('@[A-Z]@', $seller_password);
        $lowerCase = preg_match('@[a-z]@', $seller_password);
        $specialChars = preg_match('@[^\w]@', $seller_password);

        $okay = true;

        //image
        $organic_cert = $_FILES['organic_cert']['name'];
        $tempname = $_FILES['organic_cert']['tmp_name'];
        $folder = 'cert/' . $organic_cert;

        if (!move_uploaded_file($tempname, $folder)) {
            $organic_certErr = '* Sorry picture cannot upload !' . "<br>";
        }

        $seller_phone = $_POST['seller_phone'];

        if (preg_match('/^0[0-9]*$/', $seller_phone)) {
            // Phone number is valid
        } else {
            $seller_phoneErr = "* Invalid phone number. Please enter a valid phone number starting with '0'." . "<br>";
        }

        //seller name validation
        if (!ctype_alpha(str_replace(' ', '', $seller_name))) {
            $seller_nameErr = "* Only letters and spaces are allowed for Name." . "<br>";
            $okay = false;
        }

        //email validation
        if (!filter_var($seller_email, FILTER_VALIDATE_EMAIL)) {
            $seller_emailErr = "* Invalid E-mail address." . "<br>";
            $okay = false;
        } else {
            $query = "SELECT * FROM seller WHERE seller_email = '$seller_email'";

            if ($result = mysqli_query($db, $query)) {
                if (mysqli_num_rows($result) == 1) {
                    $okay = false;
                    $seller_emailErr = "* Email address is already in use." . "<br>";
                }
            } else {
                echo 'Error: ' . mysqli_error($db);
            }
        }

        //password validation
        if (strlen($seller_password) < 8 || !$number || !$upperCase || !$lowerCase || !$specialChars) {
            $seller_passwordErr = "* Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character." . "<br>";
            $okay = false;
        }
        if ($okay) {
            $hashed_seller_password = password_hash($seller_password, PASSWORD_DEFAULT);

            $query = "INSERT INTO seller (seller_id, seller_name, seller_email, seller_password, seller_phone, seller_city, seller_state, seller_status, organic_cert, reset_token)
          VALUES (0,'$seller_name', '$seller_email', '$hashed_seller_password', '$seller_phone', '$seller_city', '$seller_state', DEFAULT , '$organic_cert', NULL)";

            if (mysqli_query($db, $query)) {

                $query = "SELECT * FROM seller WHERE seller_email = '$seller_email'";

                if ($r = mysqli_query($db, $query)) {
                    $row = mysqli_fetch_array($r);
                    $_SESSION['seller_id'] = $row['seller_id'];
                } else {
                    echo mysqli_error($db);
                }
            } else {
                echo 'Error: ' . mysqli_error($db);
            }
            header('location:seller-login.php');
        }
    }
    ?>
    <div id="app">
        <section class="signup">
            <div class="container mt-2">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <img src="assets/img/orgalogo.svg" alt="logo" width="100" class="shadow-light rounded-circle">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Register</h4>
                            </div>
                            <div class="card-body">
                                <?php echo $seller_nameErr;
                                echo $seller_emailErr;
                                echo $seller_passwordErr;
                                echo $seller_phoneErr;
                                echo $organic_certErr; ?>

                                <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="seller_name">Seller Name</label>
                                            <input id="seller_name" type="text" class="form-control" name="seller_name" autofocus required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="email">Email</label>
                                            <input id="email" type="email" class="form-control" name="seller_email" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password" class="d-block">Password</label>
                                            <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="seller_password" required>
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="phone" class="d-block">Phone</label>
                                            <input id="phone" type="phone" class="form-control" name="seller_phone" required>
                                        </div>
                                    </div>

                                    <div class="form-divider">
                                        Address Information
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>State</label>
                                            <select class="form-control selectric" name="seller_state">
                                                <option value="Penang">Penang</option>
                                                <option value="Sabah">Sabah</option>
                                                <option value="Johor">Johor</option>
                                                <option value="Kedah">Kedah</option>
                                                <option value="Sarawak">Sarawak</option>
                                                <option value="Kelantan">Kelantan</option>
                                                <option value="Melacca">Melacca</option>
                                                <option value="Pahang">Pahang</option>
                                                <option value="Perak">Perak</option>
                                                <option value="Terengganu">Terengganu</option>
                                                <option value="Selangor">Selangor</option>
                                                <option value="Perlis">Perlis</option>
                                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>City</label>
                                            <input type="text" class="form-control" name="seller_city" required>
                                        </div>
                                    </div>

                                    <label>Insert Organic Certificate</label><br>
                                    <input type="file" name="organic_cert" accept="image/png, image/jpg, image/jpeg"><br>
                                    <br>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="agree" class="custom-control-input" id="agree" required>
                                            <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" name="signup" id="signup" class="btn btn-primary btn-lg btn-block" value="Register" />
                                    </div>

                                    <div class="mt-3 text-muted text-center">
                                        Already have an account? <a href="seller-login.php">Login</a>
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
    <script src="assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="assets/js/page/auth-register.js"></script>

    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>