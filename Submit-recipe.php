

<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "recipe_website"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to submit a recipe");
}

// Create upload directory
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Sanitize function
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Validate required fields
$required = ['recipeName', 'recipeDescription', 'preparingTime', 'cookingTime', 'servings', 'difficulty'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        die("Error: Missing required field - $field");
    }
}

// Process basic recipe info
$userId = $_SESSION['user_id'];
$title = sanitize($_POST['recipeName']);
$description = sanitize($_POST['recipeDescription']);
$prepTime = (int)$_POST['preparingTime'];
$cookTime = (int)$_POST['cookingTime'];
$servings = (int)$_POST['servings'];
$difficulty = sanitize($_POST['difficulty']);

// Insert recipe
$stmt = $conn->prepare("INSERT INTO Recipes (user_id, title, description, prep_time, cook_time, servings, difficulty) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issiiis", $userId, $title, $description, $prepTime, $cookTime, $servings, $difficulty);
$stmt->execute();
$recipeId = $stmt->insert_id;
$stmt->close();

// Process categories
if (!empty($_POST['categories'])) {
    $stmt = $conn->prepare("INSERT INTO Recipe_Categories (recipe_id, category_id) 
                           SELECT ?, category_id FROM Categories WHERE name = ?");
    
    foreach ($_POST['categories'] as $category) {
        $category = sanitize($category);
        $stmt->bind_param("is", $recipeId, $category);
        $stmt->execute();
    }
    $stmt->close();
}

// Process ingredients
if (!empty($_POST['ingredient'])) {
    $stmt = $conn->prepare("INSERT INTO Ingredients (recipe_id, name, quantity, `order`) VALUES (?, ?, ?, ?)");
    $order = 1;
    
    for ($i = 0; $i < count($_POST['ingredient']); $i++) {
        $name = sanitize($_POST['ingredient'][$i]);
        $quantity = sanitize($_POST['quantity'][$i]);
        
        if (!empty($name) && !empty($quantity)) {
            $stmt->bind_param("issi", $recipeId, $name, $quantity, $order);
            $stmt->execute();
            $order++;
        }
    }
    $stmt->close();
}

// Process steps
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

// Process media uploads
// Images
if (!empty($_FILES['recipePhotos']['name'][0])) {
    $stmt = $conn->prepare("INSERT INTO Recipe_Media (recipe_id, file_path, media_type, is_primary) VALUES (?, ?, 'image', ?)");
    $isPrimary = true; // First image is primary
    
    foreach ($_FILES['recipePhotos']['tmp_name'] as $index => $tmpName) {
        if ($index >= 5) break; // Limit to 5 photos
        
        // Validate file
        $fileType = strtolower(pathinfo($_FILES['recipePhotos']['name'][$index], PATHINFO_EXTENSION));
        if (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            continue;
        }
        
        $fileName = uniqid() . "_" . basename($_FILES['recipePhotos']['name'][$index]);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($tmpName, $targetPath)) {
            $stmt->bind_param("isi", $recipeId, $targetPath, $isPrimary);
            $stmt->execute();
            $isPrimary = false; // Subsequent images not primary
        }
    }
    $stmt->close();
}

// Video
if (!empty($_FILES['recipeVideo']['tmp_name'])) {
    // Validate video file
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

// Return success response
header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Recipe submitted successfully!', 'recipeId' => $recipeId]);
?>