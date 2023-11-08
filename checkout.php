<?php
include 'connect.php';
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    echo '<script>window.location.href = "user/login.php";</script>';
}

// Check if the user is logged in and get their user_id from the session
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please login to continue"); window.location.href = "user/login.php";</script>';
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['payment'])) {
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : $user_id;
    $payment_method = $_POST['payment_method'];

    // Fetch the list of items ordered
    $query = "SELECT p.product_name, c.quantity, p.product_id, p.price FROM cart c
              JOIN product p ON c.product_id = p.product_id
              WHERE c.user_id = '$user_id'";

    $result = mysqli_query($db, $query);

    $ordered_products = array();

    if ($result && mysqli_num_rows($result) > 0) {
        while ($product_data = mysqli_fetch_assoc($result)) {
            $ordered_products[] = $product_data;
        }
    }

    // Calculate the total amount
    $subtotal = 0;

    // Insert the order into the 'orders' table
    $order_query = "INSERT INTO orders (user_id, order_date, total_amount, payment_method) VALUES ('$user_id', NOW(), 0, '$payment_method')";

    if (mysqli_query($db, $order_query)) {
        $order_id = mysqli_insert_id($db); // Get the order_id

        // Insert order items into the 'order_items' table
        foreach ($ordered_products as $product) {
            $product_id = $product['product_id'];
            $quantity = $product['quantity'];

            // Calculate the product total
            $product_total = $product['price'] * $quantity;
            $subtotal += $product_total;

            // Insert the order item with 'product_id'
            $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity')";
            if (!mysqli_query($db, $order_item_query)) {
                echo "Error inserting order item: " . mysqli_error($db);
                exit();
            }
        }

        // Update the total amount in the 'orders' table
        $total_amount = $subtotal;
        $update_total_query = "UPDATE orders SET total_amount = '$total_amount' WHERE order_id = '$order_id'";
        if (!mysqli_query($db, $update_total_query)) {
            echo "Error updating total amount: " . mysqli_error($db);
            exit();
        }

        header('location: seller-admin/dist/order-info.php?order_id=' . $order_id);
        exit();
    } else {
        echo "Error inserting order: " . mysqli_error($db);
    }

    mysqli_close($db);
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
    <title>Check Out</title>

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
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <?php
                $user_id = $_POST['user_id'];
                $cart_id = $_POST['cart_id'];
                $total_amount = $_POST['total_amount'];

                // Retrieve order details from the database based on user_id and cart_id
                $query = "SELECT product.product_name, product.price, cart.quantity
                                FROM cart
                                INNER JOIN product ON cart.product_id = product.product_id
                                WHERE cart.user_id = '$user_id'";

                $order_result = mysqli_query($db, $query);

                if (!$order_result) {
                    // Handle the database query error
                    echo "Error fetching order details: " . mysqli_error($db);
                } else {
                    // Initialize subtotal
                    $subtotal = 0;
                ?>
                    <form method="POST" action="#">
                        <div class="col-lg-12 col-md-12 d-flex justify-content-center">
                            <div class="custom-width" style="width: 60%; margin: 0 auto;">
                                <div class="checkout__order">
                                    <h4>Your Order</h4>
                                    <?php
                                    $productTotalLabelDisplayed = false; // Initialize a flag variable

                                    while ($row = mysqli_fetch_assoc($order_result)) {
                                        // Calculate the total for each product
                                        $product_total = $row['quantity'] * $row['price'];
                                        $subtotal += $product_total; // Add the product total to the subtotal

                                        // Display "Products" and "Total" labels only once
                                        if (!$productTotalLabelDisplayed) {
                                            echo '<div class="checkout__order__products">Products<span>Total</span>';
                                            $productTotalLabelDisplayed = true; // Set the flag to true
                                        }
                                    ?>
                                        <ul>
                                            <li>
                                                <?php echo $row['product_name']; ?>:
                                                <?php echo $row['quantity']; ?>
                                                (RM <?php echo number_format($row['price'], 2); ?>/ea)
                                                <span>RM <?php echo number_format($product_total, 2); ?></span>
                                            </li>
                                        </ul>
                                    <?php
                                    }

                                    // Close the "Products" and "Total" labels after the loop
                                    if ($productTotalLabelDisplayed) {
                                        echo '</div>';
                                    }

                                    // Shipping fee
                                    $shipping_fee = 5.00;
                                    // If order is above 50, exclude shipping fee
                                    if ($subtotal >= 50) {
                                        $shipping_text = "Free";
                                    } else {
                                        $shipping_text = "RM " . number_format($shipping_fee, 2);
                                        $total_amount = $subtotal + $shipping_fee;
                                    }
                                    ?>

                                    <div class="checkout__order__subtotal">Subtotal<span> <?php echo number_format($subtotal, 2); ?></span></div>
                                    <div class="checkout__order__total">Shipping Fee<span> <?php echo $shipping_text; ?></span></div>
                                    <div class="checkout__order__total">Total<span> <?php echo number_format($total_amount, 2); ?></span></div>
                                    <div class="checkout__input__checkbox">
                                        <div style="font-size: 18px; color: #1c1c1c; font-weight: 700; border-bottom: 1px solid #e1e1e1; padding-bottom: 15px; margin-bottom: 15px; padding-top: 15px;">Check Payment
                                        </div>
                                    </div>
                                    <div class="checkout__input__select">
                                        <select id="payment_method" name="payment_method">
                                            <option value="Paypal">Paypal</option>
                                            <option value="TouchNGo">TouchNGo</option>
                                            <option value="Boost">Boost</option>
                                            <option value="GrabPay">GrabPay</option>
                                        </select>
                                    </div>

                                    <button type="submit" name="payment" class="site-btn">PLACE ORDER</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

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