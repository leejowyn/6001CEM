<?php
include 'connect.php';
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    echo '<script>window.location.href = "user/login.php";</script>';
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
    <title>Order History</title>

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

        /* Tab Styles */
        ul.nav.nav-pills {
            display: flex;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        ul.nav.nav-pills .nav-item {
            flex: 1;
        }

        ul.nav.nav-pills .nav-link {
            text-align: center;
            padding: 7px 0;
            color: #333;
            text-decoration: none;
            background-color: #f7f7f7;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        ul.nav.nav-pills .nav-link.active {
            background-color: #7fad39;
            color: #fff;
            border: none;
            border-radius: 5px 5px 0 0;
        }

        ul.nav.nav-pills .nav-link:hover {
            background-color: #7fad39;
            color: #fff;
        }

        /* Badge Styles */
        ul.nav.nav-pills .nav-link .badge {
            margin-left: 5px;
            background-color: #fff;
            color: #7fad39;
            border-radius: 50%;
            padding: 3px 7px;
            font-weight: bold;
        }


        /* Card Styles */
        .card-header h4 {
            margin: 0;
            font-size: 18px;
        }

        .card-body table {
            width: 100%;
        }

        table.table.table-striped {
            border: 1px solid #dee2e6;
            text-align: center;
        }

        table.table.table-striped th {
            text-transform: uppercase;
        }

        table.table.table-striped th,
        table.table.table-striped td {
            padding: 10px;
        }

        table.table.table-striped select.form-control.selectric {
            width: 100%;
            border: none;
            background-color: transparent;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include 'header.php';
    $user_id = $_SESSION['user_id'];

    $user_id = $_SESSION['user_id'];
    $query = "SELECT o.order_id, o.total_amount, o.order_date, o.status
    FROM orders o
    JOIN user u ON u.user_id = $user_id WHERE o.user_id = $user_id
    ";

    // Create a prepared statement
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        // Execute the query
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            // Get the result
            $result = mysqli_stmt_get_result($stmt);
        } else {
            echo "Error executing the query: " . mysqli_error($db);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the statement: " . mysqli_error($db);
    }

    ?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Order History</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Order History</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                                        <div class="card-body">
                                            <div class="clearfix mb-3"></div>
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Total Amount</th>
                                                    <th>Order Date</th>
                                                    <th>Status</th>
                                                    <th>Details</th>
                                                </tr>
                                                <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['order_id']; ?></td>
                                                        <td><?php echo $row['total_amount']; ?></td>
                                                        <td><?php echo $row['order_date']; ?></td>
                                                        <td><?php echo $row['status']; ?></td>
                                                        <td><a href ="seller-admin/dist/order-details.php?order_id=<?php echo $row['order_id']; ?>" data-toggle="tooltip" title="Receipt"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- End -->
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