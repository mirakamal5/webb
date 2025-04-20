<?php
session_start(); // Start session to manage login state

// Database connection (update with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user data for id=1 (you can update this dynamically if needed)
$user_id = 1;

$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);

// Check for query execution errors
if ($result === false) {
    echo "Error fetching user data: " . $conn->error;
    exit();
}

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Fetch the rating for the current user
$ratingSql = "SELECT AVG(rating) AS avg_rating FROM user_ratings WHERE rated_user_id = $user_id";
$ratingResult = $conn->query($ratingSql);

// Check for query execution errors
if ($ratingResult === false) {
    echo "Error fetching ratings: " . $conn->error;
    exit();
}

// Default to 0 if no rating found
$rating = 0;
if ($ratingResult->num_rows > 0) {
    $ratingRow = $ratingResult->fetch_assoc();
    $rating = round($ratingRow['avg_rating']);  // Get average rating
} 
$fullStars = str_repeat('<span style="color: #dc889a; font-size: 22px; line-height: 0.5;">★</span>', $rating);
$emptyStars = str_repeat('<span style="color: #dc889a; font-size: 22px; line-height: 0 !important;">☆</span>', 5 - $rating);
$ratingStars = $fullStars . $emptyStars;

if (isset($_POST['user_rating']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $ratedUserId = $user_id; // the profile being viewed
    $rating = intval($_POST['user_rating']);

    // Check if user already rated this profile
    $checkStmt = $conn->prepare("SELECT * FROM user_ratings WHERE user_id = ? AND rated_user_id = ?");
    $checkStmt->bind_param("ii", $userId, $ratedUserId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing rating
        $updateStmt = $conn->prepare("UPDATE user_ratings SET rating = ? WHERE user_id = ? AND rated_user_id = ?");
        $updateStmt->bind_param("iii", $rating, $userId, $ratedUserId);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Insert new rating
        $insertStmt = $conn->prepare("INSERT INTO user_ratings (user_id, rated_user_id, rating) VALUES (?, ?, ?)");
        $insertStmt->bind_param("iii", $userId, $ratedUserId, $rating);
        $insertStmt->execute();
        $insertStmt->close();
    }

    $checkStmt->close();
}

// Close the connection
$conn->close();
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
</head>

<body>
    <nav class="navbar custom-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/final.png" alt="Website Logo" width="80" height="50" class="d-inline-block align-text-top">
            </a>
            <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item me-3"><a class="nav-link active" href="index.html">Home</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="about us.html">About Us</a></li>
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Recipes</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="AddYourRecipe.php">Add</a></li>
                        <li><a class="dropdown-item" href="recipes.html">Explore</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <button class="btn btn-outline-danger me-2" onclick="window.location.href='profile.php'"><?php echo $_SESSION['username']; ?>'s Profile</button>
                <?php else: ?>
                    <button id="loginButton" class="btn btn-outline-danger me-2" onclick="window.location.href='loginpage.html'">Log In</button>
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
                <span><?php echo $rating; ?> </span> <!-- Display the rating number -->
                <span><?php echo $ratingStars; ?></span> <!-- This will display the stars -->
            </div>

            <div class="user-rating">
                <h1 class="heading">RATE: </h1>
                <div class="rating" id="user-rating">
                    <i class="far fa-star" data-value="1" style="font-size: 20px; color: #dc889a; cursor: pointer;"></i>
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
                <!-- Warning Message for Unauthenticated Users -->
                <div id="warning-message" style="color: red; margin-top: 10px; display: none; font-size: 14px;">Please log in to rate this page</div>

                <!-- Submit Button -->
                <form id="rating-form" method="POST" action="">
                    <input type="hidden" name="user_rating" id="user_rating_input">
                    <button id="submit-rating" type="submit" style="display: none; background-color: #dc889a; color: white; padding: 10px 20px; border: none; cursor: pointer;">Submit Rating</button>
                </form>
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
                <ul>
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
                    // Fetch recipes posted by this user
                    $recipeSql = "SELECT * FROM recipes WHERE user_id = $userId";
                    $recipeResult = $conn->query($recipeSql);
                    if ($recipeResult->num_rows > 0) {
                        while ($recipe = $recipeResult->fetch_assoc()) {
                            echo "<a href='recipe.php?id=" . $recipe['id'] . "'>
                                    <div class='recipe-card'>
                                        <img src='images/" . $recipe['image'] . "' alt='" . $recipe['title'] . "'>
                                        <div class='recipe-name'>" . $recipe['title'] . "</div>
                                    </div>
                                  </a>";
                        }
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
        const stars = document.querySelectorAll('.star');
        const submitBtn = document.getElementById('submit-rating');
        const warningMsg = document.getElementById('warning-message');
        const ratingInput = document.getElementById('user_rating_input');
        let selectedRating = 0;

        stars.forEach((star, index) => {
            const ratingValue = index + 1;

            // Handle hover effect
            star.addEventListener('mouseover', () => {
                highlightStars(ratingValue);
            });

            // Reset on mouse out
            star.addEventListener('mouseout', () => {
                highlightStars(selectedRating);
            });

            // Handle click to set rating
            star.addEventListener('click', () => {
                selectedRating = ratingValue;
                ratingInput.value = selectedRating;
                highlightStars(selectedRating);

                if (submitBtn && warningMsg) {
                    submitBtn.style.display = 'inline-block';
                    warningMsg.style.display = 'none';
                }
            });
        });

        function highlightStars(rating) {
            stars.forEach((s, i) => {
                s.style.color = i < rating ? '#dc889a' : '#ccc';
            });
        }

    </script>



    

</body>

</html>
