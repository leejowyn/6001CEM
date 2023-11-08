<?php include 'connect.php'; ?>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Mobile View Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="img/logo.png" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="./shopping-cart.php"><i class="fa fa-shopping-bag"></i></a></li>
        </ul>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__auth">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '
                                    <div class="header__top__right__language">
                                    <i class="fa fa-user"></i>                                 
                                    <div>Profile</div>
                                    <span class="arrow_carrot-down"></span>
                                    <ul>
                                        <li><a class="dropdown-item" href="user-profile.php">User Profile</a></li>
                                        <li><a class="dropdown-item" href="order-history.php">Order History</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <form action="index.php" method="post">
                                        <input class="dropdown-item" type="submit" value="Logout" id="logout-button">
										<input type="hidden" name="logout" value="true">
									</form>
                                    </ul>
                                </div>';
            } else {
                echo '<a href="user/login.php"><i class="fa fa-user"></i>Login</a>';
            }
            ?>
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="./index.php">Home</a></li>
            <li><a href="./shop-grid.php">Shop</a></li>
            <li><a href="./shopping-cart.php">Shopping Cart</a></li>
            <li><a href="./contact.php">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> orgacare@gmail.com</li>
            <li>Free Shipping for all Order of over RM50</li>
        </ul>
    </div>
</div>
<!-- Mobile View Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> orgacare@gmail.com</li>
                            <li>Free Shipping for all Order of over RM50</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        </div>
                        <div class="header__top__right__auth">
                            <?php
                            if (isset($_SESSION['user_id'])) {
                                echo '
                                    <div class="header__top__right__language">
                                    <i class="fa fa-user"></i>                                 
                                    <div>Profile</div>
                                    <span class="arrow_carrot-down"></span>
                                    <ul>
                                        <li><a class="dropdown-item" href="user-profile.php">User Profile</a></li>
                                        <li><a class="dropdown-item" href="order-history.php">Order History</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <form action="index.php" method="post">
                                        <input class="dropdown-item" type="submit" value="Logout" id="logout-button">
										<input type="hidden" name="logout" value="true">
									</form>
                                    </ul>
                                </div>';
                            } else {
                                echo '<a href="user/login.php"><i class="fa fa-user"></i> Login</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="./index.php"><img src="img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li><a href="./index.php">Home</a></li>
                        <li><a href="./shop-grid.php">Shop</a></li>
                        <li><a href="./shopping-cart.php">Shopping Cart</a></li>
                        <li><a href="./contact.php">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="./shopping-cart.php"><i class="fa fa-shopping-bag"></i> <span></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->

<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Seller</span>
                        <?php
                        // Assuming you have a database connection established, perform the SQL query
                        $query1 = "SELECT DISTINCT seller_name FROM seller";
                        $result1 = mysqli_query($db, $query1);

                        // Check if the query was successful
                        if ($result1) {
                            echo '<ul>';
                            while ($row = mysqli_fetch_assoc($result1)) {
                                $seller_name = $row['seller_name'];
                                echo '<li><a href="#">' . $seller_name . '</a></li>';
                            }
                            echo '</ul>';
                        } else {
                            echo 'Error: ' . mysqli_error($db);
                        }

                        ?>
                    </div>

                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form id="search-form" action="javascript:void(0);">
                            <input type="text" id="search-input" placeholder="What do you need?">
                            <input type="hidden" id="selected-category" value="">
                            <button type="button" id="search-button" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+60 194 459 223</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->
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
