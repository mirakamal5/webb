<?php
// Include database configuration
require_once('config.php');

// Handle the search query
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Query recipes based on the search term
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE name LIKE :searchTerm");
    $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no search term, fetch all recipes
    $stmt = $conn->query("SELECT * FROM recipes");
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle category filtering
$categoryFilter = '';
if (isset($_GET['category'])) {
    $categoryFilter = $_GET['category'];
    // Query recipes based on category
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE category = :category");
    $stmt->execute(['category' => $categoryFilter]);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch all categories for category filter
$categoryStmt = $conn->query("SELECT DISTINCT category FROM recipes");
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Website</title>
    <link rel="stylesheet" href="path_to_your_css/bootstrap.min.css">
    <link rel="stylesheet" href="path_to_your_css/styles.css">
</head>
<body>
    <!-- Header -->
    <?php include('header.php'); ?>

    <!-- Search Bar Section -->
    <div class="search-bar-section">
        <h1 class="mb-4">Find Recipes, Fast</h1>
        <form action="index.php" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control form-control-lg" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search by recipe, ingredient, or keyword">
                <button class="btn btn-outline-danger btn-lg" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Categories Section -->
    <div class="col-md-12">
        <h1 class="mb-4 text-center">Explore Recipes by Category</h1>
        <div class="row justify-content-center g-1 categories-container">
            <?php foreach ($categories as $category): ?>
                <div class="col-auto">
                    <a href="index.php?category=<?php echo urlencode($category['category']); ?>" class="text-decoration-none">
                        <div class="circle-icon mx-auto">
                            <!-- Example for categories, replace with actual category images -->
                            <img src="images/<?php echo strtolower($category['category']); ?>.jpg" alt="<?php echo htmlspecialchars($category['category']); ?>" class="img-fluid">
                        </div>
                        <p class="mt-2 category-label"><?php echo htmlspecialchars($category['category']); ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Recipe Results Section -->
    <div class="container my-5">
        <div class="row">
            <?php if (empty($recipes)): ?>
                <p>No recipes found based on your search or category filter.</p>
            <?php else: ?>
                <?php foreach ($recipes as $recipe): ?>
                    <div class="col-md-4">
                        <div class="recipe-card">
                            <img src="images/<?php echo $recipe['image']; ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>" class="img-fluid">
                            <h4><?php echo htmlspecialchars($recipe['name']); ?></h4>
                            <p><?php echo htmlspecialchars($recipe['description']); ?></p>
                            <a href="recipe_details.php?id=<?php echo $recipe['id']; ?>" class="btn btn-outline-danger">View Recipe</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Any JavaScript functionality can be added here
    </script>
</body>
</html>
