<?php
session_start();

// Check if the user is logged in by checking the session variable
$isLoggedIn = isset($_SESSION['user_id']);

// Establish a connection to the database
$conn = new mysqli("localhost", "root", "", "recipe_website");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = intval($_GET['id']); 
// Get the user ID either from the session or the GET parameter
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Get the ID from the URL
} elseif (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Use the ID from the session
} else {
    die("No user specified.");
}

// Fetch the user data from the database
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);
if (!$result || $result->num_rows === 0) {
    echo "User not found."; exit(); // If no user found, display error and exit
}
$user = $result->fetch_assoc(); // Fetch the user details

// Check if the rating form has been submitted
if (isset($_POST['rating']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];  // The logged-in user ID
    $ratedUserId = $_POST['rated_user_id']; // The user being rated (from the hidden input)
    $rating = intval($_POST['rating']); // The rating value

    // Check if the logged-in user has already rated the user
    $checkStmt = $conn->prepare("SELECT * FROM user_ratings WHERE user_id = ? AND rated_user_id = ?");
    $checkStmt->bind_param("ii", $userId, $ratedUserId);
    $checkStmt->execute();
    $existingRating = $checkStmt->get_result();

    if ($existingRating->num_rows > 0) {
        // Update the rating if the user has already rated
        $updateStmt = $conn->prepare("UPDATE user_ratings SET rating = ? WHERE user_id = ? AND rated_user_id = ?");
        $updateStmt->bind_param("iii", $rating, $userId, $ratedUserId);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Insert a new rating if not already rated
        $insertStmt = $conn->prepare("INSERT INTO user_ratings (user_id, rated_user_id, rating) VALUES (?, ?, ?)");
        $insertStmt->bind_param("iii", $userId, $ratedUserId, $rating);
        $insertStmt->execute();
        $insertStmt->close();
    }

    // Redirect back to the same page after rating
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=$ratedUserId");
    exit();
}

// Fetch the average rating for the user being viewed
$ratingSql = "SELECT AVG(rating) AS avg_rating FROM user_ratings WHERE rated_user_id = $user_id";
$ratingResult = $conn->query($ratingSql);
$rating = 0;
if ($ratingResult && $ratingResult->num_rows > 0) {
    $ratingRow = $ratingResult->fetch_assoc();
    $rating = round($ratingRow['avg_rating']); // Round the average rating
}

$fullStars = str_repeat('<span style="color: #dc889a; font-size: 22px;">★</span>', $rating); // Full stars
$emptyStars = str_repeat('<span style="color: #dc889a; font-size: 22px;">☆</span>', 5 - $rating); // Empty stars
$ratingStars = $fullStars . $emptyStars;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $user['username']; ?> - User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style2.css">
    <style>
        .star {
            font-size: 2rem;
            color: gray;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star.hovered,
        .star.filled {
            color: #f5a4b5;
        }
        .hidden {
            display: none;
        }
        a {
            text-decoration: none;
            color: inherit; 
        }

        a:hover {
            text-decoration: none;
        }
        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .recipe-item {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .recipe-item:hover {
            transform: scale(1.05);
        }

        .recipe-thumbnail {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #f5a4b5;
        }

        .recipe-title {
            padding: 15px;
            text-align: center;
        }

        .recipe-title h2 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .recipe-title a {
            color: inherit;
            text-decoration: none;
        }

        .recipe-title a:hover {
            text-decoration: underline;
        }
        .recipe-grid .recipe-card .recipe-image  {
            height:200px;
        }

    </style>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <nav class="navbar custom-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/final.png" alt="Website Logo" width="80" height="50" class="d-inline-block align-text-top">
            </a>
            <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item me-3"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="about us.php">About Us</a></li>
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Recipes</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="AddYourRecipe.php">Add</a></li>
                        <li><a class="dropdown-item" href="recipes.php">Explore</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex">
                <?php if (!$isLoggedIn): ?>
                    <button class="btn btn-outline-danger me-2" onclick="window.location.href='login.php'">Log In</button>
                <?php else: ?>
                    <div onclick="window.location.href='profile page.php'" style="cursor:pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#c42348" class="bi bi-person-fill">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <section class="userDetails card">
            <div class="profile">
                <img src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : 'images/default.png'; ?>" alt="profile" width="150px" height="200px">
            </div>

            <div class="userName">
                <h1 class="name"><?php echo $user['username']; ?></h1>
                <p style="color: #dc889a"><?php echo $user['Userrole']; ?></p>
            </div>

            <div class="rank">
                <h1 class="heading">Ratings</h1>
                <span><?php echo $rating; ?> </span>
                <span><?php echo $ratingStars; ?></span> 
            </div>

                
            <div class="user-rating">
                <h1 class="heading">RATE:</h1>

                <form id="ratingForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="rating" id="user-rating">
                        <?php 
                        $rating = 0;
                        for ($i = 1; $i <= 5; $i++): 
                            $cls = $i <= $rating ? 'filled' : '';
                        ?>
                            <span class="star <?= $cls ?>" data-value="<?= $i ?>">&#9733;</span>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="<?= $rating ?>" />
                    <input type="hidden" name="rated_user_id" value="<?= $user_id ?>" /> <!-- Hidden field with rated user's ID -->
                    <button type="submit" id="submitRating" class="hidden">Submit</button>
                </form>

                <div id="warning-message" 
                    style="color: red; margin-top: 10px; display: none; font-size: 14px;">
                    Please log in to rate this page
                </div>
            </div>

        </section>

        <section class="bio card">
            <div class="work">
                <h1 class="heading">Bio</h1>
                <div class="primary">
                    <p><?php echo nl2br($user['bio']); ?></p>
                </div>
            </div>
            <div class="skills">
                <h1 class="heading">Hobbies</h1>
                <ul style="list-style: none; padding-left: 0; margin: 0; padding-bottom:5px;">
                    <li><?php echo $user['hobbies']; ?></li>
                </ul>
            </div>
        </section>

        <section class="timeline_about card">
            <div class="tabs">
                <ul>
                    <li class="timeline">
                        <i class="ri-eye-fill ri"></i>
                        <span>Recipes Posted</span>
                    </li>
                </ul>
            </div>

            <div class="basic_info">
                <div class="recipe-grid">
                    <?php
                    $recipeSql = "SELECT * FROM recipe WHERE user_id = $user_id";
                    $recipeResult = $conn->query($recipeSql);
                    if ($recipeResult && $recipeResult->num_rows > 0) {
                        while ($recipe = $recipeResult->fetch_assoc()) {
                            echo "<a href='individual-recipes.php?id=" . $recipe['id'] . "'>
                                    <div class='recipe-card'>
                                        <img src='images/" . $recipe['image'] . "' alt='" . $recipe['name'] . "' class='recipe-image'>
                                        <div class='recipe-name'>" . $recipe['name'] . "</div>
                                    </div>
                                </a>";
                        }
                    } else {
                        echo "<p style='text-align:center; color:#000; padding-left:10px'>Baking in progress...</p>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>

    <footer class="footer">
        <div class="containerf">
            <div class="row">
                <div class="footer-col">
                    <h4>About Us</h4>
                    <ul>
                        <li><a href="about us.php">About us</a></li>
                        <li><a href="contactUs.php">Contact us</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Help & Policies</h4>
                    <ul>
                        <li><a href="faqpage.php">FAQ</a></li>
                        <li><a href="privacy.php">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Explore</h4>
                    <ul>
                        <li><a href="profile page.php">My Profile</a></li>
                        <li><a href="recipes.php">All Recipes</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('ratingInput');
        let selectedRating = parseInt(ratingInput.value) || 0;

        // Highlight saved rating on load
        function updateStars(rating) {
            stars.forEach((s, i) => {
                s.classList.toggle('filled', i < rating);
            });
        }

        // Initial update
        updateStars(selectedRating);

        stars.forEach((star, idx) => {
            star.addEventListener('mouseover', () => {
                stars.forEach((s, i) => {
                    s.classList.toggle('hovered', i <= idx);
                });
            });

            star.addEventListener('mouseout', () => {
                stars.forEach((s) => s.classList.remove('hovered'));
            });

            star.addEventListener('click', () => {
                selectedRating = idx + 1;
                ratingInput.value = selectedRating;
                updateStars(selectedRating);
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const stars = document.querySelectorAll(".star");
            const ratingInput = document.getElementById("ratingInput");
            const submitButton = document.getElementById("submitRating");

            stars.forEach(star => {
                star.addEventListener("click", function () {
                    const value = this.getAttribute("data-value");
                    ratingInput.value = value;

                    stars.forEach(s => s.classList.remove("filled"));
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add("filled");
                    }

                    // Show the submit button
                    submitButton.classList.remove("hidden");
                });

                star.addEventListener("mouseover", function () {
                    const value = this.getAttribute("data-value");
                    stars.forEach((s, index) => {
                        s.classList.toggle("hovered", index < value);
                    });
                });

                star.addEventListener("mouseout", function () {
                    stars.forEach(s => s.classList.remove("hovered"));
                });
            });
        });
    </script>

</body>

</html>
