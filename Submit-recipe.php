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
$username = isset($_SESSION['username']) ? $_SESSION['username'] : $defaultUsername;

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
if (isset($_FILES['recipePhoto']) && $_FILES['recipePhoto']['error'] === 0) {
    $img = $_FILES['recipePhoto'];
    $filename = basename($img['name']);
    $targetDir = 'images/';
    $targetFile = $targetDir . uniqid() . '-' . $filename;

    if (move_uploaded_file($img['tmp_name'], $targetFile)) {
        $imageName = basename($targetFile); // store just the filename
    }
}


// Prepare SQL query (Notice: No video anymore!)
$sql = "INSERT INTO recipe 
(name, description, category, prep_time, cook_time, servings, difficulty, image, ingredients, steps, user, created_at, user_id)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]));
}

// Bind parameters correctly (Notice: one "s" less because no video)
$stmt->bind_param(
    "sssiissssssi",
    $name,
    $description,
    $category,
    $prep_time,
    $cook_time,
    $servings,
    $difficulty,
    $imageName,
    $ingredientsJson,
    $stepsJson,
    $username,
    $userId
);

// Execute
if ($stmt->execute()) {
    
    $recipeId = $stmt->insert_id;
    header("Location: individual-recipes.php?id=" . $recipeId);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit recipe: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
exit;
?>
