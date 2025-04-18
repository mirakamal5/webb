<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<!-- page created by Mira Kamal + navbar + footer-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bake وبس</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            line-height: 1.6;
            font-family: 'Poppins', sans-serif;
            color: #535353;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #ffffff;
        }/* Navbar Styles */
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

        .search-bar-section {
            padding: 20px 10px; 
            background-image: url('images/five.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-color: #f8f9fa;
            height: 100vh; 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            width: 100%;
        }

        .search-bar-section h1 {
            font-size: 32px; 
            font-weight: 600;
            margin-bottom: 15px; 
            color: white;
            text-align: center;
        }

        .search-bar-section .input-group {
            max-width: 100%;
            width: 40%; 
            margin: 0 auto;
        }

        .search-bar-section .form-control {
            font-size: 16px; 
            padding: 10px 14px; 
            border: 2px solid #dc889a;
            border-radius: 12px 0 0 12px;
            width: 100%;
            flex: 1;
        }

        .search-bar-section .btn-outline-danger {
            padding: 12px 16px; 
            border-radius: 0 12px 12px 0;
            font-size: 16px; 
            border: 2px solid #dc889a;
            border-left: none;
        }

       .recipe-of-the-day {
            background-color: #fbf3ed;
            border: 2px solid #dc889a;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 110px;
            width: 100%;
            max-width: 800px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            box-sizing: border-box;
            display: flex;
            align-items: flex-start;
            position: relative; 
        }

        .recipe-of-the-day .image-container {
            flex: 0 0 300px;
            max-width: 300px;
            margin-right: 20px;
        }

        .recipe-of-the-day .image-container img {
            width: 100%;
            height: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 10px;
        }

        .recipe-of-the-day .col-md-5 {
            flex: 1;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        .recipe-of-the-day h3 {
            color: #dc889a;
            font-size: 24px;
            margin-bottom: 20px;
            word-wrap: break-word;
        }

        .recipe-of-the-day h4 {
            color: #dc889a;
            font-size: 20px;
            margin-bottom: 10px;
            word-wrap: break-word;
        }

        .recipe-of-the-day .posted-by {
            font-size: 16px;
            color: #535353;
            margin-bottom: 15px;
        }

        .recipe-of-the-day .posted-by .username {
            font-weight: 500;
            color: #dc889a;
        }

        .recipe-of-the-day .rating {
            color: #dc889a;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .recipe-of-the-day .rating .star {
            color: #dc889a;
        }

        .recipe-of-the-day .rating .rating-value {
            font-size: 16px;
            margin-left: 5px;
        }

        .recipe-of-the-day .card-text {
            color: #535353;
            font-size: 14px;
            margin-bottom: 20px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        .recipe-of-the-day .btn-outline-danger {
            border-color: #dc889a;
            color: #dc889a;
            font-size: 16px;
            padding: 8px 16px;
            border-radius: 8px;
        }

        .recipe-of-the-day .btn-outline-danger:hover {
            background-color: #dc889a;
            color: white;
        }

        /* Tag styling */
        .recipe-of-the-day .tag {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc889a;
            color: white;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 5px;
            text-transform: uppercase;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        } /* Circular Icons for Categories */
        .circle-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .circle-icon img {
            width: 90%;
            height: 100%;
            object-fit: cover;
        }

        .circle-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(240, 172, 172, 0.2);
        }

        /* Category Labels */
        .category-label {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: #dc889a;
            margin-top: 8px;
            text-align: center;
            font-weight: 500;
        }

        /* Container for Circular Icons */
        .categories-container {
            display: flex;
            flex-wrap: wrap;
        }

        /* Footer Styles */
        .footer {
            background-color: #dc889a;
            padding: 40px 0;
            font-family: 'Poppins', sans-serif;
            margin-top: 80px;
        }

        .container {
            max-width: 1170px;
            margin: auto;
            padding: 0 15px; 
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; 
            gap: 20px; 
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

        @media (max-width: 1300px) {
            .search-bar-section {
                height: 600px;
                padding: 50px 10px;
            }
        }
        @media (max-width: 768px) {
            .search-bar-section {
                height: 400px;
                padding: 50px 10px;
            }

            .search-bar-section h1 {
                font-size: 20px;
            }

            .search-bar-section .input-group {
                width: 80%;
            }

            .search-bar-section .form-control {
                font-size: 12px;
                padding: 8px 12px;
            }

            .search-bar-section .btn-outline-danger {
                padding: 10px 14px;
                font-size: 14px;
            }

            .recipe-of-the-day {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .recipe-of-the-day .image-container {
                margin-right: 0;
                margin-bottom: 20px;
            }
            
            .recipe-of-the-day .image-container img{
                width: 12rem;
                height: 12rem;
            }

            .recipe-of-the-day .col-md-7 {
                width: 100%;
            }

            .recipe-of-the-day h3 {
                font-size: 20px;
            }

            .recipe-of-the-day h4 {
                font-size: 18px;
            }

            .recipe-of-the-day .card-text {
                font-size: 12px;
            }

            .recipe-of-the-day .btn-outline-danger {
                font-size: 14px;
            }

            .categories-container {
                justify-content: center;
            }

            .circle-icon {
                width: 80px;
                height: 80px;
            }

            .category-label {
                font-size: 12px;
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
                
                .search-bar-section .input-group ::placeholder {
                    font-size: 10px;
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
                .search-bar-section .input-group ::placeholder {
                    font-size: 8px;
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

<!-- Navbar -->
<nav class="navbar custom-navbar sticky-top">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="images/final.png" alt="Website Logo" width="80" height="50" class="d-inline-block align-text-top">
        </a>

        <!-- Navigation Links -->
        <ul class="navbar-nav d-flex flex-row">
            <li class="nav-item me-3">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item me-3">
                <a class="nav-link" href="about us.html">About Us</a>
            </li>
            <li class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Recipes
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="AddYourRecipe.html">Add</a></li>
                    <li><a class="dropdown-item" href="recipes.php">Explore</a></li>
                </ul>
            </li>
        </ul>

        <!-- Login Button OR Profile Icon -->
        <div class="d-flex">
            <?php if (!$isLoggedIn): ?>
                <button class="btn btn-outline-danger me-2" onclick="window.location.href='login.php'">Log In</button>
            <?php else: ?>
                <div onclick="window.location.href='profile.php'" style="cursor:pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#c42348" class="bi bi-person-fill">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Session Alerts -->
<?php
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger text-center">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success text-center">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}
?>

<!-- Search Bar Section -->
<div class="search-bar-section text-center mt-5">
    <h1 class="mb-4">Find Recipes, Fast</h1>
    <form action="recipes.php" method="GET">
        <div class="input-group w-50 mx-auto">
            <input type="text" name="search" class="form-control form-control-lg" placeholder="Search by recipe, ingredient, or keyword" required>
            <button class="btn btn-outline-danger btn-lg" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>

<!-- Recipe of the Day Section -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="recipe-of-the-day d-flex align-items-center">
                <div class="col-md-5 me-md-5">
                    <div class="image-container">
                        <img src="images/mugcake.png" alt="Recipe of the Day" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-7">
                    <h3>Recipe of the Day</h3>
                    <h4>Mug Cake</h4>
                    <div class="posted-by">
                        <span>by:</span>
                        <a href="userpage mira.html" class="username">MiraCooks🍰</a>
                    </div>
                    <div class="rating mb-3">
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9734;</span>
                        <span class="rating-value">4.5</span>
                    </div>
                    <p class="card-text">
                        This chocolate mug cake is made in the microwave for a fudgy, chocolaty treat that is truly decadent.
                        It's a great recipe for nights when I need a yummy dessert that's ready in less than 10 minutes! Add a few chocolate chips to make it extra rich and gooey.
                    </p>
                    <a href="MugCake-Microwavable.html" class="btn btn-outline-danger">View Recipe</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="col-md-12 mt-5">
        <h1 class="mb-4 text-center">Explore Recipes by Category</h1>
        <div class="row justify-content-center g-1 categories-container">
            <?php
            $categories = [
                "Diabetic-Friendly" => "c.jpg",
                "Dairy-Free" => "waffl.jpg",
                "Gluten-Free" => "choco.jpg",
                "Egg-Free" => "cinnamon.jpg",
                "Vegan" => "yog.jpg",
                "Nut-Free" => "cheese.jpg",
                "Sugar-Free" => "l.jpg",
                "High-Protein" => "pann.jpg",
                "No-Bake" => "s.jpg"
            ];
            foreach ($categories as $label => $image) {
                $slug = strtolower(str_replace(' ', '-', $label));
                echo "
                <div class='col-auto'>
                    <a href='recipes.php?category=$slug' class='text-decoration-none'>
                        <div class='circle-icon mx-auto'>
                            <img src='images/$image' alt='$label' class='img-fluid'>
                        </div>
                        <p class='mt-2 category-label'>$label</p>
                    </a>
                </div>";
            }
            ?>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-5">
    <div class="container">
        <div class="row">
            <div class="footer-col">
                <h4>About Us</h4>
                <ul>
                    <li><a href="about us.html">About us</a></li>
                    <li><a href="contactUs.html">Contact us</a></li>
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
                    <li><a href="<?= $isLoggedIn ? 'profile.php' : 'login.php' ?>">My Profile</a></li>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Auto-hide alerts -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 4000);
    }
});
</script>

</body>
</html>