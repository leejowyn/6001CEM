<?php
session_start();

if (isset($_POST['logout'])) {
    session_destroy();

    echo ' <script>
    window.location.href = "user/login.php";
    </script>';
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
    <title>OrgaCare Shop</title>

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
</head>
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

<body>
    <?php
    include 'connect.php';
    $sql = "SELECT * FROM product";
    $result = $db->query($sql);
    ?>

    <?php include 'header.php'; ?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Organi Shop</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <?php
                            // Assuming you have a database connection established, perform the SQL query
                            $query1 = "SELECT DISTINCT category FROM product";
                            $result1 = mysqli_query($db, $query1);

                            // Check if the query was successful
                            if ($result1) {
                                echo '<h4>Category</h4>';
                                echo '<ul>';
                                while ($row = mysqli_fetch_assoc($result1)) {
                                    $category = $row['category'];
                                    echo '<li><a href="#" class="category-link" data-category="' . $category . '">' . $category . '</a></li>';
                                }
                                echo '</ul>';
                            } else {
                                echo 'Error: ' . mysqli_error($db);
                            }
                            ?>


                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span><?php
                                                $query = "SELECT * FROM product";
                                                $result = mysqli_query($db, $query);

                                                if ($result) {
                                                    $total_count = mysqli_num_rows($result);
                                                    echo $total_count;
                                                }
                                                ?></span> Products found</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start list -->
                    <?php
                    // Retrieve success and error messages from query parameters
                    $successMessage = isset($_GET['success']) ? urldecode($_GET['success']) : '';
                    $errorMessage = isset($_GET['error']) ? urldecode($_GET['error']) : '';

                    if (!empty($successMessage)) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo $successMessage;
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';
                    }

                    if (!empty($errorMessage)) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo $errorMessage;
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';
                    }
                    ?>

                        <div id="product-list" class="row">
                            <?php
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <div class="col-lg-4 col-md-6 col-sm-6 product-category <?php echo $row['category']; ?>">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="seller-admin/dist/uploads/<?php echo $row['image']; ?>">
                                        <ul class="product__item__pic__hover">
                                            <form action="add-cart.php" Method="POST">
                                                <li><button type="submit" class="add_to_cart_button"><i class="fa fa-shopping-cart"></i></button></li>
                                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                            </form>

                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="shop-details.php?product_id=<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a> </h6>
                                        <h5>RM<?php echo $row['price']; ?></h5>
                                    </div>
                                </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const categoryLinks = document.querySelectorAll(".category-link");
    const productList = document.getElementById("product-list");

    categoryLinks.forEach(function (link) {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const category = link.getAttribute("data-category");

            // Hide all products
            productList.querySelectorAll(".product-category").forEach(function (product) {
                product.style.display = "none";
            });

            // Show products of the selected category
            productList.querySelectorAll(".product-category." + category).forEach(function (product) {
                product.style.display = "block";
            });
        });
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const categoryLinks = document.querySelectorAll(".category-link");
    const productList = document.getElementById("product-list");
    const searchForm = document.getElementById("search-form");
    const searchInput = document.getElementById("search-input");
    const selectedCategoryInput = document.getElementById("selected-category");

    // Handle category filtering
    categoryLinks.forEach(function (link) {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const category = link.getAttribute("data-category");
            selectedCategoryInput.value = category;

            // Update product display based on both search query and category
            updateProductDisplay();
        });
    });

    // Handle search
    const searchButton = document.getElementById("search-button");
    searchButton.addEventListener("click", function () {
        updateProductDisplay();
    });

    // Function to update product display based on search query and category
    function updateProductDisplay() {
        const searchQuery = searchInput.value.toLowerCase();
        const selectedCategory = selectedCategoryInput.value.toLowerCase();

        productList.querySelectorAll(".product-category").forEach(function (product) {
            const productCategory = product.classList[4].toLowerCase();
            const productName = product.querySelector("h6 a").textContent.toLowerCase();

            // Check if the product matches the search query and the selected category
            const matchCategory = selectedCategory === "" || productCategory === selectedCategory;
            const matchQuery = productName.includes(searchQuery);

            if (matchCategory && matchQuery) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }
        });
    }
});
</script>


</body>

</html>