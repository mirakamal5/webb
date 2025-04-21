
<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']) ? 'true' : 'false';
?>

<!DOCTYPE html>
<!-- page created by Mira Kamal + navbar + footer -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Your Recipe</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('images/cakes.jpg');
            background-size: cover;
            background-position: center;
            color: #d46a7e;
            margin: 0;
            padding: 0;
            min-height: 100vh; 
            display: flex;
            flex-direction: column; 
        }

        .custom-navbar {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            background-color: #fbf3ed !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            position: relative;
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
            margin-left: 20px;
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
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fbf3ed;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex: 1; 
        }
        h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #d46a7e;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 500;
            color: #d46a7e;
            font-size: 0.9rem;
        }
        .ingredient-group,
        .step-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .ingredient-group input,
        .step-group textarea {
            flex: 1;
            font-size: 0.9rem;
        }
        .btn-primary {
            background-color: #c97688;
            border: none;
            padding: 8px 16px;
            font-size: 0.9rem;
            color: #fbf3ed;
        }
        .btn-primary:hover {
            background-color: #b86476;
        }
        .btn-secondary {
            background-color: #c97688;
            border: none;
            padding: 4px 8px;
            font-size: 0.8rem;
            color: #fbf3ed;
        }
        .btn-secondary:hover {
            background-color: #b86476;
        }
        .form-control {
            border: 1px solid #d46a7e;
            border-radius: 5px;
            padding: 8px;
            font-family: 'Schola', serif;
            color: #d46a7e;
        }
        .form-control::placeholder {
            color: #d46a7e;
            opacity: 0.7;
        }
        .form-control:focus {
            border-color: #d68c45;
            box-shadow: 0 0 5px rgba(214, 140, 69, 0.5);
        }
        .form-control[type="file"] {
            padding: 5px;
        }
        .empty-warning {
            color: rgb(247, 170, 170);
            font-size: 0.8rem;
            display: none;
        }
        .btn-danger.btn-sm {
            padding: 2px 6px;
            font-size: 0.75rem;
            line-height: 1.2;
            background-color: #d46a7e;
            border-color: #d46a7e;
            color: #fbf3ed;
        }
        .btn-danger.btn-sm:hover {
            background-color: #c42348;
            border-color: #c42348;
        }
        .form-check-input:checked {
            background-color: #d46a7e;
            border-color: #d46a7e;
        }
        .form-check-label {
            color: #d46a7e;
            font-size: 0.9rem;
        }
        .form-check {
            margin-bottom: 0.5rem;
        }
        .form-select {
            border: 1px solid #d46a7e;
            border-radius: 5px;
            padding: 8px;
            font-family: 'Schola', serif;
            color: #d46a7e;
            background-color: #ffffff;
        }
        .form-select:focus {
            border-color: #d68c45;
            box-shadow: 0 0 5px rgba(214, 140, 69, 0.5);
            background-color: #fbf3ed;
        }
        .form-select option {
            background-color: #fbf3ed;
            color: #d46a7e;
        }
        .uploaded-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .uploaded-images img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
        }
        .image-container {
            position: relative;
        }
        .remove-image {
            position: absolute;
            top: 0;
            right: 0;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
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
                    <a class="nav-link" href="about us.html">About Us</a>
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
    <div class="container mt-5">
    <h1 class="text-center mb-4">Add Your Recipe</h1>
    <form id="recipeForm" action="Submit-recipe.php" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="recipeName" class="form-label">Recipe Name</label>
            <input type="text" class="form-control" id="recipeName" name="recipeName" placeholder="Enter recipe name" required>
            <div class="empty-warning">Please fill out this field.</div>
        </div>

        <div class="mb-3">
            <label for="recipeDescription" class="form-label">Description</label>
            <textarea class="form-control" id="recipeDescription" name="recipeDescription" rows="3" placeholder="Describe your recipe" required></textarea>
            <div class="empty-warning">Please fill out this field.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="diabeticFriendly" value="Diabetic-Friendly">
                        <label class="form-check-label" for="diabeticFriendly">Diabetic-Friendly</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="eggFree" value="Egg-Free">
                        <label class="form-check-label" for="eggFree">Egg-Free</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="glutenFree" value="Gluten-Free">
                        <label class="form-check-label" for="glutenFree">Gluten-Free</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="highProtein" value="High-Protein">
                        <label class="form-check-label" for="highProtein">High-Protein</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="keto" value="Keto">
                        <label class="form-check-label" for="keto">Keto</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="lactoseFree" value="Lactose-Free">
                        <label class="form-check-label" for="lactoseFree">Lactose-Free</label>
                    </div>
                </div>

                <!-- Second Column -->
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="noBake" value="No-Bake">
                        <label class="form-check-label" for="noBake">No-Bake</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="nutFree" value="Nut-Free">
                        <label class="form-check-label" for="nutFree">Nut-Free</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="organic" value="Organic">
                        <label class="form-check-label" for="organic">Organic</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="sugarFree" value="Sugar-Free">
                        <label class="form-check-label" for="sugarFree">Sugar-Free</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="vegan" value="Vegan">
                        <label class="form-check-label" for="vegan">Vegan</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="vegetarian" value="Vegetarian">
                        <label class="form-check-label" for="vegetarian">Vegetarian</label>
                    </div>
                </div>
            </div>
            <div class="empty-warning category-warning">Please select at least one category.</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="preparingTime" class="form-label">Preparing Time (minutes)</label>
                <input type="number" class="form-control" id="preparingTime" name="preparingTime" placeholder="Enter preparing time" required>
                <div class="empty-warning">Please fill out this field.</div>
            </div>
            <div class="col-md-6">
                <label for="cookingTime" class="form-label">Cooking Time (minutes)</label>
                <input type="number" class="form-control" id="cookingTime" name="cookingTime" placeholder="Enter cooking time" required>
                <div class="empty-warning">Please fill out this field.</div>
            </div>
        </div>

        <div class="mb-3">
            <label for="servings" class="form-label">Servings</label>
            <input type="number" class="form-control" id="servings" name="servings" placeholder="Enter number of servings" required>
            <div class="empty-warning">Please fill out this field.</div>
        </div>

        <div class="mb-3">
            <label for="difficulty" class="form-label">Difficulty</label>
            <select class="form-select" id="difficulty" name="difficulty" required>
                <option value="" disabled selected>Select difficulty</option>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
            </select>
            <div class="empty-warning">Please select difficulty.</div>
        </div>

        <div class="mb-3">
            <label for="recipePhotos" class="form-label">Upload Photos</label>
            <input type="file" class="form-control" id="recipePhotos" name="recipePhotos[]" accept="image/*" multiple>
            <small class="text-muted">You can upload up to 5 photos.</small>
            <div class="uploaded-images" id="uploadedImages"></div>
        </div>

        <!-- <div class="mb-3">
            <label for="recipeVideo" class="form-label">Video Tutorial (Optional)</label>
            <input type="file" class="form-control" id="recipeVideo" name="recipeVideo" accept="video/*">
            <small class="text-muted">Upload a video or paste a YouTube/Vimeo link.</small>
        </div> -->

        <div class="mb-3">
            <label class="form-label">Ingredients</label>
            <div id="ingredientsContainer">
                <div class="ingredient-group mb-2">
                    <input type="text" class="form-control ingredient" name="ingredients[]" placeholder="Ingredient (e.g., Flour)" required>
                    <input type="text" class="form-control quantity" name="quantities[]" placeholder="Quantity (e.g., 200g)" required>
                    <button type="button" class="btn btn-danger btn-sm remove-ingredient">Remove</button>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" id="addIngredient">Add Ingredient</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Steps</label>
            <div id="stepsContainer">
                <div class="step-group mb-2">
                    <textarea class="form-control step" name="steps[]" rows="2" placeholder="Step 1" required></textarea>
                    <button type="button" class="btn btn-danger btn-sm remove-step">Remove</button>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" id="addStep">Add Step</button>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit Recipeee</button>
        </div>
    </form>


    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col">
                    <h4>About Us</h4>
                    <ul>
                        <li><a href="about us.html">About us</a></li>
                        <li><a href="contactUs.php">Contact us</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Help & Policies</h4>
                    <ul>
                        <li><a href="faqpage.html">FAQ</a></li>
                        <li><a href="privacy.html">Privacy Policy</a></li>
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
    

    <script>
        let isLoggedIn = false;
        document.getElementById('addIngredient').addEventListener('click', () => {
            const ingredientsContainer = document.getElementById('ingredientsContainer');
            const newIngredientGroup = document.createElement('div');
            newIngredientGroup.classList.add('ingredient-group', 'mb-2');
            newIngredientGroup.innerHTML = `
                <input type="text" class="form-control ingredient" placeholder="Ingredient (e.g., Flour)" required>
                <input type="text" class="form-control quantity" placeholder="Quantity (e.g., 200g)" required>
                <button type="button" class="btn btn-danger btn-sm remove-ingredient">Remove</button>
            `;
            ingredientsContainer.appendChild(newIngredientGroup);

            newIngredientGroup.querySelector('.remove-ingredient').addEventListener('click', () => {
                ingredientsContainer.removeChild(newIngredientGroup);
            });
        });
        document.getElementById('addStep').addEventListener('click', () => {
            const stepsContainer = document.getElementById('stepsContainer');
            const newStepGroup = document.createElement('div');
            newStepGroup.classList.add('step-group', 'mb-2');
            newStepGroup.innerHTML = `
                <textarea class="form-control step" rows="2" placeholder="Step ${stepsContainer.children.length + 1}" required></textarea>
                <button type="button" class="btn btn-danger btn-sm remove-step">Remove</button>
            `;
            stepsContainer.appendChild(newStepGroup);

            newStepGroup.querySelector('.remove-step').addEventListener('click', () => {
                stepsContainer.removeChild(newStepGroup);
            });
        });
        const uploadedImagesContainer = document.getElementById('uploadedImages');
        const recipePhotosInput = document.getElementById('recipePhotos');

        recipePhotosInput.addEventListener('change', (event) => {
            const files = event.target.files;
            for (const file of files) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imageContainer = document.createElement('div');
                    imageContainer.classList.add('image-container');
                    imageContainer.innerHTML = `
                        <img src="${e.target.result}" alt="Uploaded Image">
                        <button type="button" class="remove-image">×</button>
                    `;
                    uploadedImagesContainer.appendChild(imageContainer);
                    imageContainer.querySelector('.remove-image').addEventListener('click', () => {
                        uploadedImagesContainer.removeChild(imageContainer);
                    });
                };
                reader.readAsDataURL(file);
            }
        });
       /*  document.getElementById('recipeForm').addEventListener('submit', (event) => {
            event.preventDefault();
            if (!isLoggedIn) {
                alert('You must be logged in to submit a recipe.');
                return;
            }
            alert('Recipe submitted successfully!');
        });*/
        function checkLoginStatus() {
            const token = localStorage.getItem('authToken');
            isLoggedIn = !!token;
        }

        checkLoginStatus();
    </script> 
</body>
</html>