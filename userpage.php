<?php
// Start session to access user data if logged in
session_start();
require_once 'database.php'; // Include database connection file

// Get the user ID from the URL
$userId = $_GET['id'] ?? null;  // Default to null if no 'id' is passed

// Check if a valid user ID is passed
if ($userId) {
    // Query the database for the user details
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    // Redirect to an error page or home page if no valid user ID is passed
    header("Location: error_page.php");
    exit();
}

// Check if the user data exists
if (!$user) {
    echo "User not found!";
    exit();
}

// Rating Logic
$rating = round($user['rating'] ?? 0);
$fullStars = str_repeat('★', $rating);
$emptyStars = str_repeat('☆', 5 - $rating);
$ratingStars = $fullStars . $emptyStars;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style2.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <nav class="navbar custom-navbar sticky-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="images/final.png" alt="Website Logo" width="80" height="50" class="d-inline-block align-text-top">
            </a>
            <!-- Navigation Links -->
            <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="index.html">Home</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="about us.html">About Us</a>
                </li>
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Recipes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="AddYourRecipe.html">Add</a></li>
                        <li><a class="dropdown-item" href="recipes.html">Explore</a></li>
                    </ul>
                </li>
            </ul>

            <div class="d-flex">
                <button id="loginButton" class="btn btn-outline-danger me-2" onclick="window.location.href='loginpage.html'">Log In</button>
                <div id="profileIcon" class="d-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#c42348" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <section class="userDetails card">
            <div class="profile">
                <figure>
                    <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="profile" width="150px" height="200px">
                </figure>
            </div>

            <div class="userName">
                <h1 class="name"><?php echo htmlspecialchars($user['username']); ?></h1>
                <p style="color: #dc889a"><?php echo htmlspecialchars($user['role']); ?></p>
            </div>

            <div class="rank">
                <h1 class="heading">Ratings</h1>
                <span><?php echo $rating; ?></span>
                <div class="rating">
                    <?php
                    for ($i = 0; $i < $rating; $i++) {
                        echo '<i class="fa fa-star rate" aria-hidden="true" style="color:#f5a4b5;"></i>';
                    }
                    for ($i = $rating; $i < 5; $i++) {
                        echo '<i class="fa fa-star rate" aria-hidden="true" style="color:#ccc;"></i>';
                    }
                    ?>
                </div>
            </div>

            <div class="user-rating">
                <h1 class="heading">Submit Rating: </h1>
                <div class="rating" id="user-rating">
                    <i class="fas fa-star" data-value="1"></i>
                    <i class="fas fa-star" data-value="2"></i>
                    <i class="fas fa-star" data-value="3"></i>
                    <i class="fas fa-star" data-value="4"></i>
                    <i class="fas fa-star" data-value="5"></i>
                </div>
                <button id="submit-rating" title="Submit Rating">Rate</button>
                <div id="warning-message" style="color: red; margin-top: 10px;display: none;">Please log in to rate this page</div>
            </div>
        </section>

        <section class="bio card">
            <div class="work">
                <h1 class="heading">Bio</h1>
                <div class="primary">
                    <p><?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
                </div>
            </div>
            <div class="skills">
                <h1 class="heading">Hobbies</h1>
                <ul>
                    <?php
                    $hobbies = explode(',', $user['hobbies']);  // Assuming hobbies are stored as comma-separated values
                    foreach ($hobbies as $hobby) {
                        echo '<li>' . htmlspecialchars($hobby) . '</li>';
                    }
                    ?>
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
                    <!-- Loop through the user's recipes and display them -->
                    <?php
                    $recipeQuery = $conn->prepare("SELECT * FROM recipes WHERE user_id = ?");
                    $recipeQuery->bind_param("i", $userId);
                    $recipeQuery->execute();
                    $recipeResult = $recipeQuery->get_result();

                    while ($recipe = $recipeResult->fetch_assoc()) {
                        echo '<a href="recipe.php?id=' . $recipe['id'] . '">
                                <div class="recipe-card">
                                    <img src="uploads/' . htmlspecialchars($recipe['image']) . '" alt="' . htmlspecialchars($recipe['name']) . '">
                                    <div class="recipe-name">' . htmlspecialchars($recipe['name']) . '</div>
                                </div>
                              </a>';
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
                        <li><a href="about us.html">About us</a></li>
                        <li><a href="contactUs.html">Contact us</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Help & Policies</h4>
                    <ul>
                        <li><a href="faqpage.html">FAQ</a></li>
                        <li><a href="privacy.html">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Explore</h4>
                    <ul>
                        <li><a href="#">My Profile</a></li>
                        <li><a href="recipes.html">All Recipes</a></li>
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
        // JavaScript logic for rating submission
        const stars = document.querySelectorAll('.rating i');
        const ratingValue = document.getElementById('user-rating-value');
        const submitButton = document.getElementById('submit-rating');
        const userStars = document.querySelectorAll('#user-rating i');
        const warningMessage = document.getElementById('warning-message');
        let lastClickTime = 0;
        let userRating = 0;

        let isLoggedIn = false; // Update this based on the session or user login status

        userStars.forEach(star => {
            star.addEventListener('click', function () {
                if (!isLoggedIn) {
                    warningMessage.style.display = 'block';
                } else {
                    warningMessage.style.display = 'none';
                    const value = parseInt(this.dataset.value);
                    userRating = value;
                    userStars.forEach(star => star.style.color = '#ccc');
                    for (let i = 0; i < value; i++) {
                        userStars[i].style.color = '#f5a4b5';
                    }
                }
            });
        });

        submitButton.addEventListener('click', function () {
            if (!isLoggedIn) {
                warningMessage.style.display = 'block';
            } else {
                // Submit the rating to the server
                const formData = new FormData();
                formData.append('rating', userRating);
                formData.append('user_id', <?php echo $userId; ?>);
                fetch('submit_rating.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Rating submitted successfully');
                        } else {
                            alert('There was an error submitting your rating');
                        }
                    });
            }
        });
    </script>
</body>
</html>
