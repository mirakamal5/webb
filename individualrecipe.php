<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "recipe_website";

try {
    $con = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]));
}

// Get and validate recipe ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: recipes.php'); // Redirect to recipes page instead of echo
    exit;
}

$recipeId = (int) $_GET['id'];

// Fetch the recipe and user info
$sql = "
SELECT recipe.*, users.username, users.profile_picture
FROM recipe 
JOIN users ON recipe.user_id = users.user_id 
WHERE recipe.id = :recipe_id
";

$stmt = $con->prepare($sql);
$stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
$stmt->execute();

$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    header('Location: recipes.php');
    exit;
}

$userId = $_SESSION['user_id'] ?? null;
$isLoggedIn = isset($_SESSION['user_id']);

// Flags and messages
$addedToFavorites = false;
$ratingMessage = '';
$discussionMessage = '';

// Handle "Add to Favorites" functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_favorite'])) {
    if ($isLoggedIn) {
        $checkSql = "SELECT * FROM favorites WHERE user_id = :user_id AND recipe_id = :recipe_id";
        $stmt = $con->prepare($checkSql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Remove from favorites
            $deleteSql = "DELETE FROM favorites WHERE user_id = :user_id AND recipe_id = :recipe_id";
            $stmt = $con->prepare($deleteSql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
            $stmt->execute();
            $_SESSION['flash_message'] = 'Removed from favorites successfully.';
        } else {
            // Add to favorites
            $insertSql = "INSERT INTO favorites (user_id, recipe_id) VALUES (:user_id, :recipe_id)";
            $stmt = $con->prepare($insertSql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
            $stmt->execute();
            $_SESSION['flash_message'] = 'Added to favorites successfully.';
        }
        header('Location: individual-recipes.php?id=' . $recipeId);
        exit();
    } else {
        $_SESSION['flash_message'] = 'You must be logged in to add favorites.';
        header('Location: login.php');
        exit();
    }
}

// Handle Rating and Comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_rating'])) {
    if ($isLoggedIn) {
        $rating = (int) ($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');

        // Validate rating
        if ($rating < 1 || $rating > 5) {
            $_SESSION['flash_message'] = 'Invalid rating submitted.';
            header('Location: individual-recipes.php?id=' . $recipeId);
            exit();
        }

        // Check if recipe exists
        $checkRecipeSql = "SELECT 1 FROM recipe WHERE id = :recipe_id";
        $stmt = $con->prepare($checkRecipeSql);
        $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            $_SESSION['flash_message'] = 'Recipe not found.';
            header('Location: recipes.php');
            exit();
        }

        // Check if user already rated
        $checkSql = "SELECT * FROM reviews WHERE user_id = :user_id AND recipe_id = :recipe_id";
        $stmt = $con->prepare($checkSql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Update rating
            $updateSql = "UPDATE reviews SET rating = :rating, comment = :comment WHERE user_id = :user_id AND recipe_id = :recipe_id";
            $stmt = $con->prepare($updateSql);
            $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
            $stmt->execute();
            $_SESSION['flash_message'] = 'Rating updated successfully!';
        } else {
            // Insert new review
            $insertSql = "INSERT INTO reviews (user_id, recipe_id, rating, comment) VALUES (:user_id, :recipe_id, :rating, :comment)";
            $stmt = $con->prepare($insertSql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
            $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['flash_message'] = 'Rating submitted successfully!';
        }

        header('Location: individual-recipes.php?id=' . $recipeId);
        exit();
    } else {
        $_SESSION['flash_message'] = 'You must be logged in to rate.';
        header('Location: login.php');
        exit();
    }
}

// Handle Discussion Submission (simple save comment only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_discussion'])) {
    if ($isLoggedIn) {
        $comment = htmlspecialchars(trim($_POST['discussion'] ?? ''));
        if (!empty($comment)) {
            $discussionMessage = "Comment submitted: " . $comment;
            $_SESSION['flash_message'] = 'Comment submitted successfully!';
        }
    } else {
        $discussionMessage = "You must be logged in to comment.";
        $_SESSION['flash_message'] = 'You must be logged in to comment.';
    }
}
?>
