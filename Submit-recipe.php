<?php
session_start();

// Database connection
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "recipe_website";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

// Dummy values for guests
$defaultUserId = 0;
$defaultUsername = 'Guest';

// If logged in user
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $defaultUserId;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : $defaultUsername; // Add session username!!

// Sanitize function
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Validate required fields
if (!isset($_POST['recipeName'], $_POST['recipeDescription'], $_POST['categories'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

// Collect and sanitize inputs
$name = sanitize($_POST['recipeName']);
$description = sanitize($_POST['recipeDescription']);
$prep_time = (int)$_POST['preparingTime'];
$cook_time = (int)$_POST['cookingTime'];
$servings = (int)$_POST['servings'];
$difficulty = sanitize($_POST['difficulty']);
$category = implode(", ", array_map('sanitize', $_POST['categories']));

// Ingredients and steps as JSON
$ingredientsArray = [];
if (!empty($_POST['ingredients']) && !empty($_POST['quantities'])) {
    foreach ($_POST['ingredients'] as $index => $ingredient) {
        $quantity = $_POST['quantities'][$index] ?? '';
        if ($ingredient && $quantity) {
            $ingredientsArray[] = [
                'ingredient' => sanitize($ingredient),
                'quantity' => sanitize($quantity)
            ];
        }
    }
}
$ingredientsJson = json_encode($ingredientsArray);

$stepsArray = [];
if (!empty($_POST['steps'])) {
    foreach ($_POST['steps'] as $step) {
        if (!empty($step)) {
            $stepsArray[] = sanitize($step);
        }
    }
}
$stepsJson = json_encode($stepsArray);

// Upload image (first one)
$imageName = null;
if (isset($_FILES['recipePhotos']['tmp_name'][0]) && !empty($_FILES['recipePhotos']['tmp_name'][0])) {
    $img = $_FILES['recipePhotos'];
    $filename = basename($img['name'][0]);  // Use original name
    $destination = 'images/' . $filename;
    if (move_uploaded_file($img['tmp_name'][0], $destination)) {
        $imageName = $filename;
    }
}

// Upload video
$videoName = null;
if (isset($_FILES['recipeVideo']['tmp_name']) && !empty($_FILES['recipeVideo']['tmp_name'])) {
    $video = $_FILES['recipeVideo'];
    $videoFilename = uniqid() . '_' . basename($video['name']);
    $videoDestination = 'videos/' . $videoFilename;

    if (!is_dir('videos')) {
        mkdir('videos', 0777, true);
    }
    if (move_uploaded_file($video['tmp_name'], $videoDestination)) {
        $videoName = $videoFilename;
    }
}

// Prepare SQL query
$sql = "INSERT INTO recipe 
(name, description, category, prep_time, cook_time, servings, difficulty, image, video, ingredients, steps, user, created_at, user_id)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]));
}

// Bind parameters correctly
$stmt->bind_param(
    "sssiisssssssi",
    $name,
    $description,
    $category,
    $prep_time,
    $cook_time,
    $servings,
    $difficulty,
    $imageName,
    $videoName,
    $ingredientsJson,
    $stepsJson,
    $username,   // <<< 🟰 Correct username, not userId
    $userId      // <<< 🟰 Integer ID
);

// Execute
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Recipe submitted successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit recipe: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>