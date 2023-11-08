<?php
session_start();

if (isset($_POST['logout'])) {
    session_destroy();

    echo ' <script>
    window.location.href = "user/login.php";
    </script>';
}

include 'connect.php';

$successMessage = "";
$errorMessage = "";

if (isset($_SESSION['user_id']) && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

        // Check if the same product is already in the cart
        $query = 'SELECT cart_id, quantity FROM cart WHERE user_id="' . $user_id . '" AND product_id="' . $product_id . '" ';

        if ($r = mysqli_query($db, $query)){
            if (mysqli_num_rows($r) > 0) {
                $row = mysqli_fetch_array($r);
                $cart_id = $row['cart_id'];
                $current_quantity = $row['quantity'];
                $new_quantity = $current_quantity + 1;
    
                $query = 'UPDATE cart SET quantity = "' . $new_quantity . '" WHERE cart_id = "'. $cart_id . '" ';

                if (mysqli_query($db, $query)) {
                    $successMessage = "Product quantity updated in the cart.";
                } else {
                    $errorMessage = "Error updating product quantity: ". mysqli_error($db) ;
                }
            }else {
            // Insert if the product is not in the cart
            $quantity = 1;
            $query = "INSERT INTO cart (cart_id, user_id, product_id, quantity) VALUES (0,'$user_id', '$product_id', 1)";
            if (mysqli_query($db, $query)) {
                $successMessage = "Product added to the cart.";
            } else {
                $errorMessage = "Error adding product to the cart: " . mysqli_error($db) ;
            }
        }
        }
        else{
            $errorMessage = "Something wrong when adding to cart: ". mysqli_error($db) ;
        }

} else {
    // If the user is not logged in
    $errorMessage = "Please login to add products to the cart.";
}

header('Location: shop-grid.php?success=' . urlencode($successMessage) . '&error=' . urlencode($errorMessage));
exit();
?>
