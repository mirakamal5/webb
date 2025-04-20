<?php
session_start(); // Start session only once at the top

// Database connection
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "recipe_website";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

// Dummy user ID for guests
$defaultUserId = 0;
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $defaultUserId;


// Sanitize function
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Validate required fields
if (!isset($_POST['recipeName'], $_POST['recipeDescription'], $_POST['categories'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

// Sanitize and extract main recipe fields
$title = sanitize($_POST['recipeName']);
$description = sanitize($_POST['recipeDescription']);
$prepTime = (int)$_POST['preparingTime'];
$cookTime = (int)$_POST['cookingTime'];
$servings = (int)$_POST['servings'];
$difficulty = sanitize($_POST['difficulty']);

// Insert main recipe

echo "User ID used: " . htmlspecialchars($userId);

$stmt = $conn->prepare("INSERT INTO Recipes (user_id, title, description, prep_time, cook_time, servings, difficulty) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issiiis", $userId, $title, $description, $prepTime, $cookTime, $servings, $difficulty);

$stmt->execute();
$recipeId = $stmt->insert_id;
$stmt->close();

// Insert categories
if (!empty($_POST['categories'])) {
    $stmt = $conn->prepare("INSERT INTO Recipe_Categories (recipe_id, category_id) 
                            SELECT ?, category_id FROM Categories WHERE name = ?");
    foreach ($_POST['categories'] as $category) {
        $cleanCategory = sanitize($category);
        $stmt->bind_param("is", $recipeId, $cleanCategory);
        $stmt->execute();
    }
    $stmt->close();
}

// Insert ingredients
if (!empty($_POST['ingredient']) && !empty($_POST['quantity'])) {
    $stmt = $conn->prepare("INSERT INTO Ingredients (recipe_id, name, quantity, `order`) VALUES (?, ?, ?, ?)");
    $order = 1;
    for ($i = 0; $i < count($_POST['ingredient']); $i++) {
        $name = sanitize($_POST['ingredient'][$i]);
        $quantity = sanitize($_POST['quantity'][$i]);
        if ($name && $quantity) {
            $stmt->bind_param("issi", $recipeId, $name, $quantity, $order++);
            $stmt->execute();
        }
    }
    $stmt->close();
}

// Insert steps
if (!empty($_POST['step'])) {
    $stmt = $conn->prepare("INSERT INTO Steps (recipe_id, description, step_number) VALUES (?, ?, ?)");
    foreach ($_POST['step'] as $index => $step) {
        $cleanStep = sanitize($step);
        if (!empty($cleanStep)) {
            $stepNumber = $index + 1;
            $stmt->bind_param("isi", $recipeId, $cleanStep, $stepNumber);
            $stmt->execute();
        }
    }
    $stmt->close();
}

// Create upload directory
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Upload images
if (isset($_FILES['recipePhotos']) && !empty($_FILES['recipePhotos']['name'][0])) {
    $stmt = $conn->prepare("INSERT INTO Recipe_Media (recipe_id, file_path, media_type, is_primary) VALUES (?, ?, 'image', ?)");
    $isPrimary = 1;

    foreach ($_FILES['recipePhotos']['tmp_name'] as $index => $tmpName) {
        if ($index >= 5) break;
        $fileType = strtolower(pathinfo($_FILES['recipePhotos']['name'][$index], PATHINFO_EXTENSION));
        if (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) continue;

        $fileName = uniqid() . "_" . basename($_FILES['recipePhotos']['name'][$index]);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $stmt->bind_param("isi", $recipeId, $targetPath, $isPrimary);
            $stmt->execute();
            $isPrimary = 0;
        }
    }
    $stmt->close();
}

// Upload video
if (isset($_FILES['recipeVideo']) && !empty($_FILES['recipeVideo']['tmp_name'])) {
    $videoType = strtolower(pathinfo($_FILES['recipeVideo']['name'], PATHINFO_EXTENSION));
    if (in_array($videoType, ['mp4', 'mov', 'avi'])) {
        $videoName = uniqid() . "_" . basename($_FILES['recipeVideo']['name']);
        $targetVideo = $uploadDir . $videoName;
        if (move_uploaded_file($_FILES['recipeVideo']['tmp_name'], $targetVideo)) {
            $stmt = $conn->prepare("INSERT INTO Recipe_Media (recipe_id, file_path, media_type) VALUES (?, ?, 'video')");
            $stmt->bind_param("is", $recipeId, $targetVideo);
            $stmt->execute();
            $stmt->close();
        }
    }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Recipe submitted successfully!', 'recipeId' => $recipeId]);
?>
