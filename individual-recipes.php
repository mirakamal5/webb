<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include 'config.php'; 
    include 'individualrecipe.php';
     
    $isLoggedIn = isset($_SESSION['user_id']);
    $user_id = $_SESSION['user_id'];
    $recipe_id = $_GET['id'];  

    if (!is_numeric($recipe_id)) {
        echo "Invalid recipe ID.";
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_favorite'])) {
        toggleFavoriteStatus($user_id, $recipe_id);

        exit("Favorite toggled!");
    }

    $query = "SELECT * FROM recipe WHERE id = :id";  
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $recipe_id, PDO::PARAM_INT);  
    $stmt->execute(); 
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
    $userQuery = $con->prepare("SELECT username, profile_picture FROM users WHERE user_id = ?");
    $userQuery->execute([$recipe['user_id']]);
    $userInfo = $userQuery->fetch();

    if (!$recipe) {
        echo "Recipe not found!";
        exit;
    }

    $ingredients = json_decode($recipe['ingredients'], true);
    $steps = json_decode($recipe['steps'], true);

    $ratingQuery = $con->prepare("SELECT AVG(rating) AS avg_rating FROM reviews WHERE recipe_id = ?");
    $ratingQuery->execute([$recipe_id]);
    $ratingResult = $ratingQuery->fetch();
    $averageRating = $ratingResult['avg_rating'] ? number_format($ratingResult['avg_rating'], 2) : "No ratings yet";

    function checkIfFavorited($user_id, $recipe_id, $con) {
        $stmt = $con->prepare("SELECT * FROM favorites WHERE user_id = :user_id AND recipe_id = :recipe_id");
        
        // Bind parameters using bindParam
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
    
        // Execute the statement
        $stmt->execute();
    
        // Check if any rows were returned
        return $stmt->rowCount() > 0;
    }
    

    function toggleFavoriteStatus($user_id, $recipe_id) {
        if (checkIfFavorited($user_id, $recipe_id)) {
            $stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND recipe_id = ?");
            $stmt->execute([$user_id, $recipe_id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO favorites (user_id, recipe_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $recipe_id]);
        }
    }

    $isFavorited = checkIfFavorited($user_id, $recipe_id, $con);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $comment = $_POST['comment'];
    
        // Check if user has commented on this recipe before
        $stmt = $con->prepare("SELECT * FROM reviews WHERE recipe_id = :recipe_id AND user_id = :user_id");
        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            // User has commented before, update the comment
            $updateStmt = $con->prepare("UPDATE reviews SET comment = :comment WHERE recipe_id = :recipe_id AND user_id = :user_id");
            $updateStmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $updateStmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
            $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $updateStmt->execute();
            echo "<script>alert('Comment updated successfully!');</script>";
        } else {
            // User has not commented before, insert a new row
            $insertStmt = $con->prepare("INSERT INTO reviews (recipe_id, user_id, comment) VALUES (:recipe_id, :user_id, :comment)");
            $insertStmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
            $insertStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $insertStmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $insertStmt->execute();
            echo "<script>alert('Comment added successfully!');</script>";
        }
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
    
    // Fetch all comments for this recipe_id
    $commentsStmt = $con->prepare("SELECT users.username, reviews.comment FROM reviews JOIN users ON reviews.user_id = users.user_id WHERE reviews.recipe_id = :recipe_id");
    $commentsStmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
    $commentsStmt->execute();
    $comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);    

?>


<!DOCTYPE html>
<!-- page created by Ranim Ibrahim -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Recipe Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-image: url('https://i.pinimg.com/736x/ec/88/01/ec88011e4d940a6fbfde37d59b58b85b.jpg');
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            color: #d46a7e;
            margin: 0;
            padding: 0;
        }
        .container {
            background: #fbf3ed;
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative; 
        }
         /* Navbar Styles */
         .custom-navbar {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            background-color: #fbf3ed !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 0; 
        }

        .custom-navbar.sticky-top {
            position: sticky;
            top: 0;
        }

        .custom-navbar .navbar-nav .nav-link {
            color: #dc889a !important;
            font-size: 18px;
            padding: 8px 12px;
            transition: color 0.3s ease;
        }

        .custom-navbar .navbar-nav .nav-link.active,
        .custom-navbar .navbar-nav .nav-link:hover {
            color: #c42348 !important;
        }

        .custom-navbar .dropdown-menu {
            background-color: #fbf3ed !important;
            border: 2px solid #dc889a;
            border-radius: 8px;
            padding: 5px;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            min-width: 150px;
        }

        .custom-navbar .dropdown-menu .dropdown-item {
            color: #dc889a !important;
            font-size: 14px;
            padding: 6px 12px;
            transition: background-color 0.3s ease;
        }

        .custom-navbar .dropdown-menu .dropdown-item:hover {
            background-color: rgba(220, 136, 154, 0.1);
        }

        .custom-navbar .navbar-brand {
            color: #dc889a !important;
            font-size: 18px;
            margin-left: 0; 
        }

        .custom-navbar .navbar-toggler-icon {
            background-color: #dc889a;
        }

        .btn-outline-danger {
            border-color: #dc889a;
            color: #dc889a;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background-color: #dc889a;
            color: white;
        }

        #loginButton {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 8px;
            border-width: 2px;
        }
        .recipe-header {
            text-align: center;
        }
        .recipe-img {
            width: 30%;
            border-radius: 5px;
        }
        .categories {
            text-align: center;
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        .category {
            background: #fbf3ed;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        .favorite-heart {
            font-size: 28px;
            color: #e74c3c;
            cursor: pointer;
            transition: color 0.3s;
            position: absolute;
            top: 20px; 
            right: 20px; 
        }
        .rating-section, .discussion-section {
            margin-top: 20px;
        }
        .star-rating {
            display: flex;
            gap: 5px;
            margin: 10px 0;
        }
        .star {
            cursor: pointer;
            font-size: 24px;
            color: #ccc;
        }
        .star.selected {
            color: #d46a7e;
        }
        .average-rating {
            font-size: 18px;
            margin: 10px 0;
        }
        .discussion-section input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .discussion-section button {
            padding: 10px 20px;
            background: #d46a7e;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .discussion-section button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .warning {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            display: none;
        }
        .favorite-warning {
            position: absolute;
            top: 60px;
            right: 20px;
            background: #fbf3ed;
            padding: 5px 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .user-info img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
        }
        .footer {
            background-color: #dc889a;
            padding: 40px 0;
            font-family: 'Poppins', sans-serif;
            margin-top: 80px;
            color: #fbf3ed;
        }

        .footer .container {
            background-color: #dc889a;
            max-width: 1170px;
            margin: auto;
            padding: 0 15px;
            box-shadow: none;
            border: none;
        }

        .footer .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .footer-col {
            flex: 1;
            min-width: 200px;
            padding: 0 15px;
        }

        .footer-col h4 {
            font-size: 18px;
            color: #fbf3ed;
            text-transform: capitalize;
            margin-bottom: 20px;
            font-weight: 600;
            position: relative;
        }

        .footer-col h4::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            background-color: #fbf3ed;
            height: 2px;
            box-sizing: border-box;
            width: 50px;
        }

        .footer-col ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .footer-col ul li:not(:last-child) {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            font-size: 14px;
            text-transform: capitalize;
            color: #fbf3ed;
            text-decoration: none;
            font-weight: 400;
            display: block;
            transition: all 0.3s ease;
        }

        .footer-col ul li a:hover {
            color: #ffffff;
            padding-left: 8px;
        }

        .footer-col .social-links {
            display: flex;
            gap: 10px;
        }

        .footer-col .social-links a {
            display: inline-block;
            height: 40px;
            width: 40px;
            background-color: rgba(251, 243, 237, 0.2);
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            color: #fbf3ed;
            transition: all 0.5s ease;
        }

        .footer-col .social-links a:hover {
            color: #dc889a;
            background-color: #ffffff;
        }

        
        @media (max-width: 768px) {
            .container {
                margin: 20px auto;
                padding: 15px;
                width:450px;
                font-size: 13px;
            }

            .recipe-header{
                margin-bottom: 25px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .row {
                flex-direction: column;
            }

            .col-md-6 {
                width: 100%;
            }

            .ingredient-group,
            .step-group {
                flex-direction: column;
                gap: 5px;
            }

            .ingredient-group input,
            .step-group textarea {
                width: 100%;
            }

            .btn-secondary {
                width: 100%;
                margin-top: 10px;
            }
            .custom-navbar .navbar-brand,
            .custom-navbar .navbar-nav .nav-link,
            .custom-navbar .dropdown-menu .dropdown-item,
            .btn-outline-danger,
            #loginButton {
            font-size: 14px; 
            }

            .custom-navbar .navbar-brand {
            margin-left: 1px;
            }

            .custom-navbar .navbar-nav .nav-link {
                font-size: 14px;
                padding: 1px 0; 
            }

            .custom-navbar .d-flex #loginButton{
                margin: 0;
                width: 55px;
                height: 30px;
                padding: 1px;
                font-size: 13px;
            }

            .custom-navbar .dropdown-menu {
            min-width: 120px; 
            }

            .footer-col h4 {
            font-size: 16px;
            }

            .footer-col ul li a {
            font-size: 12px; 
            }

            .custom-navbar {
            height: auto; 
            }

            .timeline_about .tabs {
            height: 40px; 
            }

            .footer {
            padding: 20px 0; 
            }

            .footer-col {
            flex: 1 1 100%; 
            text-align: center; 
            }

            .footer-col h4::before {
                left: 50%; 
                transform: translateX(-50%);
            }

            .footer-col .social-links {
                justify-content: center; 
            }
            .footer-col {
                flex: 1 1 100%;
                text-align: center;
            }

            .footer-col h4::before {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-col .social-links {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .container {
                margin: 10px auto;
                padding: 10px;
                width: 290px;
            }

            h1 {
                font-size: 1.25rem;
            }

            .form-label {
                font-size: 0.8rem;
            }

            .form-control {
                font-size: 0.8rem;
            }

            .btn-primary,
            .btn-secondary {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 400px) {
            .custom-navbar .navbar-brand{
            width:27px;
            }

            .custom-navbar .navbar-brand img{
            width: 50px;
            }
            .custom-navbar .navbar-nav{
            margin-left: 6px;
            }

            .custom-navbar .navbar-nav .nav-link{
                font-size: 12px;
            }


            .custom-navbar .d-flex #loginButton{
            margin: 0;
            width: 55px;
            height: 30px;
            font-size: 13px;
            }
        }

        @media (max-width: 345px) {
            .custom-navbar .navbar-brand{
            width:25px;
            }

            .custom-navbar .navbar-brand img{
            width: 50px;
            }
            .custom-navbar .navbar-nav{
            margin-left: 13px;
            }


            .custom-navbar .navbar-nav .nav-link{
            font-size: 12px;
            }

            .custom-navbar .d-flex #loginButton{
            margin: 0;
            width: 55px;
            height: 30px;
            padding: 1px;
            font-size: 13px;
            }
        }
    </style>
</head>
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
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="about us.php">About Us</a>
                </li>
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Recipes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="AddYourRecipe.php">Add</a></li>
                        <li><a class="dropdown-item" href="recipes.php">Explore</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Login Button and Profile Icon -->
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
        <!-- Favorite Heart -->
        <i class="<?php echo $isFavorited ? 'fa-solid' : 'fa-regular'; ?> fa-heart favorite-heart" id="favoriteHeart" onclick="toggleFavorite()"></i>

        <div class="recipe-header">
            <h1><?= htmlspecialchars($recipe['name'] ?? 'No Name Available') ?></h1>
            <br></br>
            <img src="images/<?= htmlspecialchars($recipe['image'] ?? 'default.jpg') ?>" alt="Recipe Image" class="recipe-img" style="width: 400px; height: 300px; object-fit: cover;"> <!-- Image check -->
            <div class="categories">
                <?php
                $categories = explode(',', $recipe['category'] ?? ''); 
                $categories = array_unique($categories); 
                foreach ($categories as $category) {
                    echo '<div class="category">' . htmlspecialchars(trim($category)) . '</div>';
                }
                ?>
            </div>

        </div>


        <div class="user-info">
            <img src="<?= htmlspecialchars($userInfo['profile_picture'] ?? 'default.png') ?>" alt="User Picture" class="user-pic"> <!-- Profile picture check -->
            <p>Posted by: <strong><?= htmlspecialchars($userInfo['username'] ?? 'Unknown User') ?></strong></p> <!-- Username check -->
        </div>

        <?php
            $averageRating = $ratingResult['avg_rating'];

            echo '<p><strong>Rating:</strong> ';

            if ($averageRating) {
                $roundedRating = round($averageRating); // Round to nearest whole number
                for ($i = 1; $i <= 5; $i++) {
                    echo ($i <= $roundedRating) ? '★' : '☆';
                }
                echo " (" . number_format($averageRating, 1) . " / 5)";
            } else {
                // No ratings yet — show 5 empty stars
                echo str_repeat('☆', 5);
                echo " (No ratings yet)";
            }

            echo '</p>';
        ?>

        <p><strong>Description:</strong> <?= htmlspecialchars($recipe['description']) ?></p>
        <p><strong>Prep Time:</strong> <?= htmlspecialchars($recipe['prep_time']) ?> | <strong>Cook Time:</strong>  <?= htmlspecialchars($recipe['cook_time']) ?> | <strong>Servings:</strong> <?= htmlspecialchars($recipe['servings']) ?> | <strong>Difficulty:</strong> <?= htmlspecialchars($recipe['difficulty']) ?></p>
        
        <div class="serving-calculator">
            <label for="servingInput">Adjust servings:</label>
            <input type="number" id="servingInput" value=<?= htmlspecialchars($recipe['servings']) ?> min="1" onchange="adjustIngredients()">
        </div>


        <h3>Ingredients</h3>
        <ul id="ingredients-list">
            <?php
            // Loop through ingredients and display each one
            foreach ($ingredients as $ingredient) {
                echo "<li id=\"ingredient-" . htmlspecialchars($ingredient['ingredient']) . "\" data-quantity=\"" . htmlspecialchars($ingredient['quantity']) . "\">" . htmlspecialchars($ingredient['quantity']) . " " . htmlspecialchars($ingredient['ingredient']) . "</li>";
            }
            ?>
        </ul>


        <h3>Steps</h3>
        <ol id="steps-list">
            <?php
            foreach ($steps as $step) {
                echo "<li>" . htmlspecialchars($step) . "</li>";
            }
            ?>
        </ol>


        <div class="user-rating">
                    <form method="post" action="">
                        <label for="rating">Rate this recipe:</label>
                        <div class="star-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star" data-value="<?= $i ?>" onclick="setRating(<?= $i ?>)">
                                    ★
                                </span>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="rating" id="rating" required>
                        <button type="submit" name="submit_rating">Submit</button>
                    </form>

                    <div id="warning-message" 
                        style="color: red; margin-top: 10px; display: none; font-size: 14px;">
                        Please log in to rate this page
                    </div>
                </div>
                <div class="discussion-section">
                <br></br>
                <h3>Add Comment</h3>
                <form method="POST" action="individual-recipes.php?id=<?php echo $recipe_id; ?>" style="margin-bottom: 20px;">
                    <textarea name="comment" placeholder="Add your comment..." required
                        style="width: 100%; height: 100px; padding: 10px; font-size: 16px; resize: vertical;"></textarea>
                    <button type="submit"
                        style="margin-top: 10px; padding: 10px 20px; font-size: 16px; display: block;">Submit</button>
                </form>


                <br></br>
                <h3>Comments</h3>
                <div id="commentsList">
                    <?php
                    $hasComments = false;
                    foreach ($comments as $comment) {
                        if (!empty(trim($comment['comment']))) {
                            $hasComments = true;
                            echo '<p><strong>' . htmlspecialchars($comment['username']) . ':</strong> ' . htmlspecialchars($comment['comment']) . '</p>';
                        }
                    }
                    if (!$hasComments) {
                        echo '<p>No comments yet.</p>';
                    }
                    ?>
                </div>

            </div>
        
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const favoriteHeart = document.getElementById('favoriteHeart');
        const favoriteWarning = document.getElementById('favoriteWarning');
        
        const isRecipeFavorited = <?= $isFavorited ? 'true' : 'false' ?>;

        document.addEventListener('DOMContentLoaded', function() {
            if (isRecipeFavorited) {
                favoriteHeart.classList.remove('fa-regular');
                favoriteHeart.classList.add('fa-solid');
            } else {
                favoriteHeart.classList.remove('fa-solid');
                favoriteHeart.classList.add('fa-regular');
            }
        });

        function toggleFavorite() {
            const heart = document.getElementById('favoriteHeart');

            // Toggle between outlined and filled heart
            heart.classList.toggle('fa-regular');
            heart.classList.toggle('fa-solid');

            // Optionally: Send request to backend
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'add_favorite=1'
            })
            .then(res => res.texHt())
            .then(data => {
                console.log('Response:', data);
            });
        }

        const stars = document.querySelectorAll('.star');
        const message = document.getElementById('ratingMessage');
        const recipeId = new URLSearchParams(window.location.search).get("id");

        function highlightStars(rating) {
            document.querySelectorAll('.star').forEach(star => {
                const value = parseInt(star.getAttribute('data-value'));
                if (value <= rating) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }


        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function () {
                const rating = this.getAttribute('data-value');
                const recipeId = new URLSearchParams(window.location.search).get('id');

                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `submit_rating=1&rating=${rating}&recipe_id=${recipeId}`
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    highlightStars(rating);
                });
            });
        });


        const commentInput = document.getElementById('commentInput');
        const submitCommentBtn = document.getElementById('submitCommentBtn');
        const commentWarning = document.getElementById('commentWarning');

        submitCommentBtn.addEventListener('click', () => {
            commentWarning.style.display = 'block'; 
        });

        
    </script>
        
    <script>
        function setRating(rating) {
            document.getElementById('rating').value = rating;

            const stars = document.querySelectorAll('.star');
            stars.forEach(star => {
                if (parseInt(star.getAttribute('data-value')) <= rating) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }
    </script>

    <script>
        // Function to submit the comment via AJAX
        function submitComment() {
            var comment = document.getElementById("commentInput").value;
            if (comment.trim() === "") {
                alert("Please enter a comment.");
                return;
            }

            // Create a new FormData object to send the data
            var formData = new FormData();
            formData.append("comment", comment);

            // Send the comment to the PHP backend using AJAX
            var xhr = new XMLHttpRequest();
            var recipeId = new URLSearchParams(window.location.search).get("id");
            xhr.open("POST", "individual-recipes.php?id=" + recipeId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // After submission, clear the input field and reload comments
                    document.getElementById("commentInput").value = "";
                    loadComments();  // Reload the comments after submitting
                }
            };
            xhr.send(formData);
        }

        // Function to load comments via AJAX

        // Load comments on page load
        window.onload = loadComments;
    </script>


    <script>
        function adjustIngredients() {
            const newServings = document.getElementById('servingInput').value;

            const oldServings = <?= htmlspecialchars($recipe['servings']) ?>;

            const ingredientsList = document.querySelectorAll('#ingredients-list li');

            ingredientsList.forEach(function(ingredient) {
                let oldQuantity = ingredient.getAttribute('data-quantity');
                let newQuantity = calculateNewQuantity(oldQuantity, oldServings, newServings);

                ingredient.innerHTML = newQuantity + " " + ingredient.innerHTML.split(' ').slice(1).join(' ');
            });
        }

        function calculateNewQuantity(oldQuantity, oldServings, newServings) {
            let number = parseFloat(oldQuantity); 
            let unit = oldQuantity.replace(number, '').trim();

            let newQuantity = (number / oldServings) * newServings;

            return newQuantity.toFixed(2);
        }
    </script>
</body>
    <footer class="footer">
        <div class="container">
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
                        <li><a href="#faqpage.php">FAQ</a></li>
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
</html>