<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);


// Database connection
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "recipe_website";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

// Get and validate recipe ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid recipe ID.";
    exit;
}

$recipeId = (int) $_GET['id'];
// Fetch recipe data from DB

$sql = "
SELECT recipe.*, users.username, users.profile_picture
FROM recipe 
JOIN users ON recipe.user_id = users.user_id 
WHERE recipe.id = $recipeId
";


$recipe = $conn->query($sql);
$userId = $_SESSION['user_id'];

if ($recipe->num_rows > 0) {
    $recipe = $recipe->fetch_assoc();
} else {
    echo "Recipe not found.";
    exit;
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// Flags and messages
$addedToFavorites = false;
$ratingMessage = '';
$discussionMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_favorite'])) {
    if ($isLoggedIn) {

        // Check if favorite already exists
        $checkSql = "SELECT * FROM favorites WHERE user_id = $userId AND recipe_id = $recipeId";
        $result = $conn->query($checkSql);
        echo $recipeId;
        if ($result->num_rows > 0) {
            // Remove from favorites
            $deleteSql = "DELETE FROM favorites WHERE user_id = $userId AND recipe_id = $recipeId";
            $conn->query($deleteSql);
            echo "removed from favorites";
        } else {
            // Add to favorites
            $insertSql = "INSERT INTO favorites (user_id, recipe_id) VALUES ($userId, $recipeId)";
            $conn->query($insertSql);
            echo "added to favorites";
        }

        exit();
    } else {
        echo "NOT LOGGED IN";
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_rating'])) {
    if ($isLoggedIn) {
        $rating = (int) $_POST['rating'];

        // Check if rating exists
        $checkSql = "SELECT * FROM recipe_rating WHERE user_id = $userId AND recipe_id = $recipeId";
        $result = $conn->query($checkSql);

        if ($result->num_rows > 0) {
            // Update rating if it exists
            $updateSql = "UPDATE recipe_rating SET rating = ? WHERE user_id = ? AND recipe_id = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("iii", $rating, $userId, $recipeId);
            $stmt->execute();
            echo "Rating updated!";
        } else {
            // Add rating
            $insertSql = "INSERT INTO recipe_rating (user_id, recipe_id, rating) VALUES ($userId, $recipeId, $rating)";
            $conn->query($insertSql);
            echo "Rating submitted!";
        }

        exit();
    } else {
        echo "NOT LOGGED IN";
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