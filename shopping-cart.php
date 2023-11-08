<?php

include 'connect.php';
session_start();

if (isset($_POST['logout'])) {
    session_destroy();

    echo ' <script>
    window.location.href = "user/login.php";
    </script>';
}

// Check if the user is logged in and get their user_id from the session
if (!isset($_SESSION['user_id'])) {
    echo '<script>
    alert("Please login to continue");
    window.location.href = "user/login.php"; 
    </script>';
    exit();
}

$user_id = $_SESSION['user_id'];

$total_amount = 0.00; // Initialize the total_amount variable

if (isset($_GET['product_id']) && isset($_GET['qty_selected'])) {
    $qty_selected = $_GET['qty_selected'];
    $product_id = $_GET['product_id'];

    if ($qty_selected == 0) {
        // If quantity is zero, delete the item from the cart and database
        $delete_query = "DELETE FROM cart 
                         WHERE product_id = $product_id 
                         AND user_id = $user_id";

        if (mysqli_query($db, $delete_query)) {
            // Redirect to the cart page or update as needed
            header("Location: shopping-cart.php");
            exit();
        } else {
            echo mysqli_error($db) . "The query was: " . $delete_query;
        }
    } else {
        // Update the quantity
        $query = "UPDATE cart SET quantity = $qty_selected 
                    WHERE product_id = $product_id 
                    AND user_id = $user_id";

        if (!mysqli_query($db, $query)) {
            echo mysqli_error($db) . "The query was: " . $query;
        }
    }
}

if (isset($_GET['delete'])) {
    $query = "DELETE FROM cart 
                WHERE cart_id = {$_GET['cart_id']} 
                AND user_id = $user_id";
    if (mysqli_query($db, $query)) {
?>
        <script>
            window.location = 'shopping-cart.php';
        </script>
<?php
    } else {
        echo mysqli_error($db) . "The query was: " . $query;
    }
}

if (isset($_GET['clear'])) {
    // Clear all items from the user's cart
    $clear_query = "DELETE FROM cart WHERE user_id = $user_id";
    if (mysqli_query($db, $clear_query)) {
        // Redirect to the cart page
        header("Location: shopping-cart.php");
        exit();
    } else {
        echo mysqli_error($db) . "The query was: " . $clear_query;
    }
}

// Fetch cart data for the user from the database
$query = "SELECT c.cart_id, c.quantity, p.*, s.seller_name 
FROM cart c 
JOIN product p ON c.product_id = p.product_id 
JOIN seller s ON p.seller_id = s.seller_id 
WHERE c.user_id = ?";

$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text.css">
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

        /* Hide the checkboxes in the shopping cart table */
        table input[type="checkbox"] {
            display: none;
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
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                        ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Seller</th>
                                        <th class="shoping__product">Products</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $result->fetch_assoc()) :
                                        $cart_id = $row['cart_id'];
                                        $seller_name = $row['seller_name'];
                                        $product_id = $row['product_id'];
                                        $product_name = $row['product_name'];
                                        $product_image = $row['image'];
                                        $product_price = $row['price'];
                                        $qty_selected = $row['quantity'];
                                        $total_amount += ($qty_selected * $product_price); // Update total amount
                                    ?>
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="checkbox" value="<?php echo $product_id; ?>" onclick="calcTotalPrice(this.id, <?php echo $qty_selected; ?>, <?php echo $product_price; ?>)" id="cart<?php echo $product_id; ?>">
                                            </td>
                                            <td><?php echo $seller_name; ?></td>
                                            <td class="shoping__cart__item">
                                                <img src="seller-admin/dist/uploads/<?php echo $product_image; ?>" style="height:100px; width:100px;" alt="">
                                                <h5><?php echo $product_name; ?></h5>
                                            </td>
                                            <td class="shoping__cart__price">
                                                <?php echo $product_price; ?>
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <a href="shopping-cart.php?product_id=<?php echo $product_id; ?>&qty_selected=<?php echo $qty_selected - 1; ?>">
                                                            <span class="dec qtybtn">-</span>
                                                        </a>
                                                        <input type="text" value="<?php echo $qty_selected; ?>" aria-label="Disabled input example" disabled readonly>
                                                        <a href="shopping-cart.php?product_id=<?php echo $product_id; ?>&qty_selected=<?php echo $qty_selected + 1; ?>">
                                                            <span class="inc qtybtn">+</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="shoping__cart__item__close">
                                                <a href="shopping-cart.php?delete=true&cart_id=<?php echo $cart_id; ?>" class="btn btn-danger rounded-circle" onclick="return confirmDelete();">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <div class="row mt-5">
                                <div class="col-lg-2">
                                    <div class="shoping__cart__btns">
                                        <a href="shopping-cart.php?clear=true" class="primary-btn cart-btn">CLEAR ALL</a>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="shoping__cart__btns">
                                        <a href="./index.php" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="shoping__checkout">
                                        <h5>Cart Total</h5>
                                        <div id="total-price-container">
                                            <ul>
                                                <li> Total: &nbsp; RM <span id="totalprice"><?php echo number_format($total_amount, 2); ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <form action="checkout.php" method="POST">
                                            <input type="hidden" name="total_amount" value="<?php echo number_format($total_amount, 2); ?>">
                                            <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <button type="submit" class="primary-btn" style="border: none; width: 100%;">
                                                PROCEED TO CHECKOUT
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                <?php } else {
                            // Display a message when the cart is empty
                            echo '<div class="alert alert-info" role="alert">
                                The cart is empty. Please shop around.
                              </div>';
                        }
                ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

    <?php include 'footer.php'; ?>

    <script>
        // Function to show the clear message
        function showClearMessage() {
            var clearMessage = document.getElementById("clearMessage");
            clearMessage.style.display = "block";
        }

        var totalprice = document.getElementById("totalprice");
        var total = parseFloat(totalprice.innerHTML);

        window.onload = function() {
            var checkbox = document.getElementsByTagName("input");

            for (var i = 0; i < checkbox.length; i++) {
                if (checkbox[i].type == "checkbox") {
                    checkbox[i].checked = false;
                }
            }
        }

        function calcTotalPrice(checkbox_id, qty_selected, product_price) {
            var checkbox = document.getElementById(checkbox_id);

            if (checkbox.checked == true) {
                total = total + (qty_selected * product_price);
                totalprice.innerHTML = total.toFixed(2);
                $total_amount = total.toFixed(2); // Set the total_amount variable
            } else {
                total = total - (qty_selected * product_price);
                totalprice.innerHTML = total.toFixed(2);
                $total_amount = total.toFixed(2); // Set the total_amount variable
            }
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