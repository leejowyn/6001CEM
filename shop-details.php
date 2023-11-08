<?php
include 'connect.php';

session_start();
$product_id = $_GET['product_id'];
$user_id = null; // Initialize the variable to null

if (isset($_POST['logout'])) {
    session_destroy();

    echo ' <script>
    window.location.href = "user/login.php";
    </script>';
}

$sql = "SELECT
p.product_id,
p.product_name,
p.price,
p.category,
p.image,
p.description,
p.stock,
p.seller_id,
s.seller_name
FROM
product p
JOIN
seller s
ON
p.seller_id = s.seller_id
WHERE
p.product_id = $product_id";

$result = mysqli_query($db, $sql);

if ($result) {
    // Fetch the product details
    $row = mysqli_fetch_assoc($result);

    // define product attributes
    $product_name = $row['product_name'];
    $price = $row['price'];
    $category = $row['category'];
    $image = $row['image'];
    $description = $row['description'];
    $stock = $row['stock'];
    $seller_name = $row['seller_name'];

    

    // Close the result set 
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($db);
}

$countSql = "SELECT COUNT(*) AS review_count FROM review WHERE order_item_id IN (SELECT order_item_id FROM order_items WHERE product_id = $product_id)";
$countResult = mysqli_query($db, $countSql);

if ($countResult) {
    $countRow = mysqli_fetch_assoc($countResult);
    $reviewCount = $countRow['review_count'];
    mysqli_free_result($countResult);
} else {
    $reviewCount = 0; // Default to 0 if there are no reviews
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
    <title><?php echo $product_name; ?></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Lightbox2 CSS -->
    <link rel="stylesheet" href="path-to-lightbox2/css/lightbox.min.css">

    <!-- Lightbox2 JS -->
    <script src="path-to-lightbox2/js/lightbox.min.js"></script>

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
    <?php include 'header.php';    ?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2><?php echo $product_name; ?></h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <a href="./shop-grid.php"><?php echo $product_name; ?></a>
                            <span><?php echo $product_name; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <a href="seller-admin/dist/uploads/<?php echo $image; ?>" data-lightbox="product-image">
                                <img src="seller-admin/dist/uploads/<?php echo $image; ?>" alt="product-image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo $product_name; ?></h3>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $reviewCount) {
                                echo '<i class="fa fa-star-o"></i>';
                            } else {
                                echo '<i class="fa fa-star"></i>';
                            }
                        } ?>
                        <div class="product__details__price">RM <?php echo number_format($price, 2); ?></div>
                        <?php echo "<p>$description </p>"; ?>
                        <form method="post" action="add-cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button type="submit" class="primary-btn">Add to Cart</button>
                        </form>
                        <!-- <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a> -->
                        <ul>
                            <li><b>Availability</b> <span><?php echo $stock; ?> items left</span></li>
                            <li><b>Shipping</b> <span>03 day shipping. <samp>RM 50 Free Shipping</samp></span></li>
                            <li><b>Category</b> <span><?php echo $category; ?></span></li>
                            <li><b>Seller Name</b><span><?php echo $seller_name; ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Reviews <span>(<?php echo $reviewCount; ?>)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <?php echo "<p>$description </p>"; ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Reviews</h6>
                                    <?php
                                    // Query to fetch review details, including username
                                    $reviewSql = "SELECT u.username, r.rating, r.review_datetime, r.comment
                                                    FROM product p
                                                    JOIN order_items oi ON p.product_id = oi.product_id
                                                    JOIN review r ON oi.order_item_id = r.order_item_id
                                                    JOIN orders o ON oi.order_id = o.order_id
                                                    JOIN user u ON u.user_id = o.user_id
                                                    WHERE p.product_id = $product_id";

                                    $reviewResult = mysqli_query($db, $reviewSql);

                                    if ($reviewResult) {
                                        // Check if there are reviews
                                        if (mysqli_num_rows($reviewResult) > 0) {
                                            // Loop through the reviews
                                            while ($reviewRow = mysqli_fetch_assoc($reviewResult)) {
                                                // Display review information for each review
                                                $username = $reviewRow['username'];
                                                $rating = $reviewRow['rating'];
                                                $review_datetime = $reviewRow['review_datetime'];
                                                $comment = $reviewRow['comment'];

                                                // Display the review information
                                                echo "Username: $username<br>";
                                                echo "Rating: $rating<br>";
                                                echo "Review Date: $review_datetime<br>";
                                                echo "Comment: $comment<br>";
                                                echo "<hr>";
                                            }
                                        } else {
                                            echo 'No reviews available.';
                                        }

                                        // Free the review result set
                                        mysqli_free_result($reviewResult);
                                    } else {
                                        echo "Error: " . mysqli_error($db);
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

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