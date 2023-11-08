<?php
include '../connect.php';
session_start();
$user_id = $_SESSION['user_id'];
$order_item_id = isset($_GET['order_item_id']) ? intval($_GET['order_item_id']) : 0;

if ($order_item_id == 0) {
    echo "Invalid order ID.";
    exit; // Exit the script
}
if (isset($_POST['submitted'])) {
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0; // Ensure $rating is an integer
    $comment = isset($_POST['comment']) ? mysqli_real_escape_string($db, $_POST['comment']) : '';

    if ($rating < 1 || $rating > 5) {
        echo "Invalid rating value. Please select a rating between 1 and 5.";
    } else {
        $query = "INSERT INTO review (rating, comment, review_datetime, order_item_id) 
        VALUES ('$rating', '$comment', NOW(), (SELECT order_item_id FROM order_items WHERE order_item_id = $order_item_id))";
        $result = mysqli_query($db, $query);

        if ($result) {
            $successMessage = "Review submitted successfully!";
        } else {
            $errorMessage = "Error submitting review. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<meta charset="utf-8">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Review</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Style for the stars */
        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
        }

        .rating>span {
            display: inline-block;
            position: relative;
            width: 1.1em;
        }

        .rating>span:hover:before,
        .rating>span:hover~span:before {
            content: "★";
            position: absolute;
        }
    </style>
</head>

<body>
    <div class="main">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/review.gif" alt="sing up image"></figure>
                    </div>
                    <div class="signin-form">
                        <h2 class="form-title">Review</h2>
                        <form method="POST" class="register-form" action="review.php?order_item_id=<?php echo $order_item_id; ?>">
                            <?php
                            if (isset($successMessage)) {
                                // Display the success message
                                echo '<div class="alert alert-success">' . $successMessage . '</div>';
                            } elseif (isset($errorMessage)) {
                                // Display the error message
                                echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
                            }
                            ?>
                            <p>Write your review here</p> <br>
                            <div class="rating">
                                <span>☆</span>
                                <span>☆</span>
                                <span>☆</span>
                                <span>☆</span>
                                <span>☆</span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="comment" placeholder="Comment" />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="submitted" class="form-submit" value="Submit" />
                            </div>
                            <a href="../order-history.php" class="signup-image-link">Go back</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        const stars = document.querySelectorAll(".rating > span");
        const ratingInput = document.createElement("input");
        ratingInput.type = "hidden";
        ratingInput.name = "rating"; // Set the name to identify in your form
        document.querySelector(".form-group").appendChild(ratingInput);

        // Initialize the rating value to 0
        let selectedRating = 0;

        stars.forEach((star, index) => {
            star.addEventListener("mouseenter", () => {
                // Highlight stars when the mouse enters
                for (let i = 0; i <= index; i++) {
                    stars[i].textContent = "★";
                }
            });

            star.addEventListener("mouseleave", () => {
                // Restore stars to the selected rating when the mouse leaves
                for (let i = 0; i < stars.length; i++) {
                    if (i < selectedRating) {
                        stars[i].textContent = "★";
                    } else {
                        stars[i].textContent = "☆";
                    }
                }
            });

            star.addEventListener("click", () => {
                // Set the selected rating when a star is clicked
                selectedRating = index + 1;
                ratingInput.value = selectedRating;
            });
        });
    </script>

</body>

</html>