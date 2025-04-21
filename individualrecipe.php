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
    die(json_encode(['success' => false, 'message' => 'Database conection failed: ' . $e->getMessage()]));
}

// Get and validate recipe ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid recipe ID.";
    exit;
}

$recipeId = (int) $_GET['id'];

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
    echo "Recipe not found.";
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
        // Check if favorite already exists
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
            echo "Removed from favorites";
        } else {
            // Add to favorites
            $insertSql = "INSERT INTO favorites (user_id, recipe_id) VALUES (:user_id, :recipe_id)";
            $stmt = $con->prepare($insertSql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
            $stmt->execute();
            echo "Added to favorites";
        }
        exit();
    } else {
        echo "NOT LOGGED IN";
        exit();
    }
}

// Handle Rating and Comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_rating'])) {
    if ($isLoggedIn) {
        $rating = (int) $_POST['rating'];
        $comment = $_POST['comment'] ?? ''; // Optional comment from the user
        
        // Ensure the rating is valid
        if ($rating < 1 || $rating > 5) {
            echo "Invalid rating.";
            exit();
        }

        // Check if the recipe_id exists in the recipe table
        $checkRecipeSql = "SELECT 1 FROM recipe WHERE id = :recipe_id";
        $stmt = $con->prepare($checkRecipeSql);
        $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            echo "The recipe does not exist.";
            exit();
        }

        // Check if the user has already rated the recipe
        $checkSql = "SELECT * FROM reviews WHERE user_id = :user_id AND recipe_id = :recipe_id";
        $stmt = $con->prepare($checkSql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Update rating if the user has already rated the recipe
            $updateSql = "UPDATE reviews SET rating = :rating, comment = :comment WHERE user_id = :user_id AND recipe_id = :recipe_id";
            $stmt = $con->prepare($updateSql);
            $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
            $stmt->execute();

            echo "Successfully updated!";
        } else {
            // Insert a new review if the user hasn't rated the recipe yet
            $insertSql = "INSERT INTO reviews (user_id, recipe_id, rating, comment) VALUES (:user_id, :recipe_id, :rating, :comment)";
            $stmt = $con->prepare($insertSql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
            $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            $stmt->execute();

            echo "Successfully submitted!";
        }
        exit();
    } else {
        echo "You are not logged in.";
        exit();
    }
}

// Handle Discussion Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_discussion'])) {
    if ($isLoggedIn) {
        $comment = htmlspecialchars($_POST['discussion']);
        // TODO: Save comment to database
        $discussionMessage = "Comment submitted: " . $comment;
    } else {
        $discussionMessage = "You must be logged in to comment.";
    }
}
?>
