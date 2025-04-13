<?php
/**
 * Creates all tables needed for the recipe submission system
 */

// Database configuration
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'recipe_website';

try {
    // Create connection
    $conn = new mysqli($host, $user, $pass, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    $tables = [
        "Users" => "CREATE TABLE IF NOT EXISTS Users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            profile_picture VARCHAR(255) DEFAULT 'default_profile.jpg',
            CONSTRAINT email_format CHECK (email LIKE '%_@__%.__%')
        ) ENGINE=InnoDB",
        
        "Categories" => "CREATE TABLE IF NOT EXISTS Categories (
            category_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) UNIQUE NOT NULL,
            slug VARCHAR(50) UNIQUE NOT NULL,
            description TEXT,
            icon_class VARCHAR(50)
        ) ENGINE=InnoDB",
        
        "Recipes" => "CREATE TABLE IF NOT EXISTS Recipes (
            recipe_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(100) NOT NULL,
            description TEXT,
            prep_time INT COMMENT 'in minutes',
            cook_time INT COMMENT 'in minutes',
            servings INT,
            difficulty ENUM('Easy', 'Medium', 'Hard'),
            FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
        ) ENGINE=InnoDB",
        
        "Recipe_Categories" => "CREATE TABLE IF NOT EXISTS Recipe_Categories (
            recipe_id INT NOT NULL,
            category_id INT NOT NULL,
            PRIMARY KEY (recipe_id, category_id),
            FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE,
            FOREIGN KEY (category_id) REFERENCES Categories(category_id) ON DELETE CASCADE
        ) ENGINE=InnoDB",
        
        "Ingredients" => "CREATE TABLE IF NOT EXISTS Ingredients (
            ingredient_id INT AUTO_INCREMENT PRIMARY KEY,
            recipe_id INT NOT NULL,
            name VARCHAR(100) NOT NULL,
            quantity VARCHAR(50) NOT NULL,
            `order` INT NOT NULL,
            FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE
        ) ENGINE=InnoDB",
        
        "Steps" => "CREATE TABLE IF NOT EXISTS Steps (
            step_id INT AUTO_INCREMENT PRIMARY KEY,
            recipe_id INT NOT NULL,
            description TEXT NOT NULL,
            step_number INT NOT NULL,
            FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE
        ) ENGINE=InnoDB",
        
        "Recipe_Media" => "CREATE TABLE IF NOT EXISTS Recipe_Media (
            media_id INT AUTO_INCREMENT PRIMARY KEY,
            recipe_id INT NOT NULL,
            file_path VARCHAR(255) NOT NULL,
            media_type ENUM('image', 'video') NOT NULL,
            is_primary BOOLEAN DEFAULT FALSE,
            FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE
        ) ENGINE=InnoDB",
        
        "Reviews" => "CREATE TABLE IF NOT EXISTS Reviews (
            review_id INT AUTO_INCREMENT PRIMARY KEY,
            recipe_id INT NOT NULL,
            user_id INT NOT NULL,
            rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
            comment TEXT,
            FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
        ) ENGINE=InnoDB",
        
        "Favorites" => "CREATE TABLE IF NOT EXISTS Favorites (
            user_id INT NOT NULL,
            recipe_id INT NOT NULL,
            PRIMARY KEY (user_id, recipe_id),
            FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
            FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE
        ) ENGINE=InnoDB"
    ];
    foreach ($tables as $name => $sql) {
        if ($conn->query($sql)) {
            echo "Table '$name' created successfully!<br>";
        } else {
            throw new Exception("Error creating table $name: " . $conn->error);
        }
    }
    $indexes = [
        "CREATE INDEX idx_recipes_user ON Recipes(user_id)",
        "CREATE INDEX idx_reviews_recipe ON Reviews(recipe_id)",
        "CREATE INDEX idx_reviews_user ON Reviews(user_id)",
        "CREATE INDEX idx_favorites_user ON Favorites(user_id)"
    ];
    
    foreach ($indexes as $sql) {
        if ($conn->query($sql)) {
            echo "Index created successfully!<br>";
        } else {
            echo "Warning: Could not create index: " . $conn->error . "<br>";
        }
    }
    $categories = [
        ['Diabetic-Friendly', 'diabetic-friendly', 'Suitable for diabetics', 'fa-heartbeat'],
        ['Egg-Free', 'egg-free', 'Contains no eggs', 'fa-egg'],
        ['Gluten-Free', 'gluten-free', 'Contains no gluten', 'fa-bread-slice'],
        ['High-Protein', 'high-protein', 'High protein content', 'fa-dumbbell'],
        ['Keto', 'keto', 'Keto-friendly recipes', 'fa-bacon'],
        ['Lactose-Free', 'lactose-free', 'No lactose', 'fa-cheese'],
        ['No-Bake', 'no-bake', 'Requires no baking', 'fa-temperature-low'],
        ['Nut-Free', 'nut-free', 'Contains no nuts', 'fa-tree'],
        ['Organic', 'organic', 'Organic ingredients', 'fa-leaf'],
        ['Sugar-Free', 'sugar-free', 'No added sugar', 'fa-candy-cane'],
        ['Vegan', 'vegan', 'No animal products', 'fa-seedling'],
        ['Vegetarian', 'vegetarian', 'Vegetarian recipes', 'fa-carrot']
    ];
    
    foreach ($categories as $category) {
        $name = $conn->real_escape_string($category[0]);
        $slug = $conn->real_escape_string($category[1]);
        $desc = $conn->real_escape_string($category[2]);
        $icon = $conn->real_escape_string($category[3]);
        
        $sql = "INSERT IGNORE INTO Categories (name, slug, description, icon_class) 
                VALUES ('$name', '$slug', '$desc', '$icon')";
        
        if (!$conn->query($sql)) {
            echo "Warning: Could not insert category '$name': " . $conn->error . "<br>";
        }
    }
    
    echo "Database setup complete with all tables and categories!";
    $conn->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>