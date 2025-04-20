<?php
session_start();
require_once 'config.php';
$isLoggedIn = isset($_SESSION['user_id']); // <--- ADD THIS LINE


// Connect to DB and fetch recipes
$query = "SELECT * FROM recipe";
$params = [];

if (isset($_GET['search'])) {
    $query .= " WHERE name LIKE :search";
    $params[':search'] = '%' . $_GET['search'] . '%';
} elseif (isset($_GET['category'])) {
    $query .= " WHERE category LIKE :category";
    $params[':category'] = '%' . $_GET['category'] . '%';
}

$stmt = $con->prepare($query);
$stmt->execute($params);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        .custom-navbar {
    font-family: 'Poppins', sans-serif;
    font-size: 20px;
    background-color: #fbf3ed !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    padding: 0; 
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
    margin-left: 0; 
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
@media (max-width: 768px) {
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

    .custom-navbar .d-flex #loginButton {
        margin: 0;
        width: 55px;
        height: 30px;
        padding: 1px;
        font-size: 13px;
    }

    .custom-navbar .dropdown-menu {
        min-width: 120px; 
    }
}

@media (max-width: 400px) {
    .custom-navbar .navbar-brand {
        width: 27px;
    }

    .custom-navbar .navbar-brand img {
        width: 50px;
    }

    .custom-navbar .navbar-nav {
        margin-left: 6px;
    }

    .custom-navbar .navbar-nav .nav-link {
        font-size: 12px;
    }

    .custom-navbar .d-flex #loginButton {
        margin: 0;
        width: 55px;
        height: 30px;
        font-size: 13px;
    }
}

@media (max-width: 345px) {
    .custom-navbar .navbar-brand {
        width: 25px;
    }

    .custom-navbar .navbar-brand img {
        width: 50px;
    }

    .custom-navbar .navbar-nav {
        margin-left: 13px;
    }

    .custom-navbar .navbar-nav .nav-link {
        font-size: 12px;
    }

    .custom-navbar .d-flex #loginButton {
        margin: 0;
        width: 55px;
        height: 30px;
        padding: 1px;
        font-size: 13px;
    }
}
        .category-title {
            font-size: 2rem;
            font-weight: bold;
            margin: 30px 0 15px 20px;
            color: #9c4d4d;
            position: relative;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
        }
    .btn-pink {
        background-color: #D27D92; 
        border: none;
        padding: 10px 18px;
        font-weight: bold;
        color: white;
        border-radius: 8px;
        transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        font-size: 14px;
        display: inline-block;
        text-align: center;
        text-decoration: none;
    }
    .btn-pink:hover {
        background-color: #B55B73; 
        transform: scale(1.05);
    }
    .btn-pink:focus, .btn-pink:active {
        background-color: #B55B73 !important;
        color: white !important;
        box-shadow: none !important;
        border: none !important;
    }



        .category-title::after {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            background: #FF6F61;
            margin-top: 5px;
            border-radius: 2px;
        }
        .scroll-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            padding: 10px 0;
        }

        .scroll-container {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 10px;
            scrollbar-width: thin;
            scrollbar-color: #bbb #eee;
            scroll-behavior: smooth;
        }
        .scroll-container::-webkit-scrollbar {
            height: 6px;
        }
        .scroll-container::-webkit-scrollbar-thumb {
            background: #FF6F61;
            border-radius: 5px;
        }
        .recipe-card {
            position: relative;
            flex: 0 0 auto;
            width: 280px;
            height: 380px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-right: 15px;
            transform: scale(1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .recipe-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.2);
        }
        .recipe-card img {
            width: 100%;
            height: 210px;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .recipe-card:hover img {
            transform: scale(1.08);
        }
        .recipe-card .card-body {
        padding: 15px;
        text-align: center;
        position: relative;
    }

    .favorite-container {
        position: absolute;
        top: 10px;
        right: 5px;
        width: 35px;
        height: 35px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        z-index: 10; 
        pointer-events: auto; 
    }

    .favorite-icon {
        font-size: 18px;
        color: #bbb;
        transition: color 0.3s ease-in-out, transform 0.2s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50%;
        height: 50%;
    }
     .favorite-container.active {
        background: #FFD1DC;
    }

    .favorite-container.active .favorite-icon {
        color: red;
        transform: scale(1.1);
    }
    .favorite-container:hover {
        background: #F5B7B1;
    }

    .favorite-container:hover .favorite-icon {
        transform: scale(1.2);
    }

        .recipe-card h5 {
            font-size: 1.1rem;
            font-weight: bold;
            color: #9c4d4d;
        }

        .recipe-card p {
            font-size: 0.9rem;
            color: #9c4d4d;;
            margin-bottom: 5px;
        }

        .favorite-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 22px;
            color: #bbb;
            cursor: pointer;
            transition: color 0.3s ease-in-out;
        }

    .favorite-icon.active {
        color: #FF6F91;
    }
        .scroll-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.7);
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            color: white;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s ease-in-out;
            z-index: 10;
            opacity: 0;
        }

        .scroll-wrapper:hover .scroll-button {
            opacity: 1;
        }

        .scroll-button:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }

        .a {
            color:#9c4d4d;
            background-color: #FF6F61;
            border-color: #FF6F61;
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
    background-color: #dc889a;
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
        .scroll-left { left: 10px; }
        .scroll-right { right: 10px; }

    </style>
    </style>
</head>
<body>

<!-- Navbar -->
<!-- Navbar -->
<nav class="navbar custom-navbar sticky-top">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="images/final.png" alt="Website Logo" width="80" height="50" class="d-inline-block align-text-top">
        </a>

        <!-- Navigation Links -->
        <ul class="navbar-nav d-flex flex-row">
            <li class="nav-item me-3">
                <a class="nav-link" href="index.php">Home</a>
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

<!-- Recipes Section -->
<div class="container mt-5">
    <h2 class="category-title text-center mb-5">
        <?php
        if (isset($_GET['search'])) {
            echo "Search Results for: " . htmlspecialchars($_GET['search']);
        } elseif (isset($_GET['category'])) {
            echo "Category: " . htmlspecialchars(ucwords(str_replace('-', ' ', $_GET['category'])));
        } else {
            echo "All Recipes";
        }
        ?>
    </h2>

    <?php if (count($recipes) > 0): ?>
        <div class="row">
            <?php foreach ($recipes as $recipe): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="recipe-card">
                        <div class="favorite-container">
                            <span class="favorite-icon"><i class="fa-regular fa-heart"></i></span>
                        </div>
                        <img src="images/<?= htmlspecialchars($recipe['image']) ?>" alt="<?= htmlspecialchars($recipe['name']) ?>">
                        <div class="card-body">
                            <h5><?= htmlspecialchars($recipe['name']) ?></h5>
                            <p>By <?= htmlspecialchars($recipe['user']) ?></p>
                            <p>Prep time: <?= htmlspecialchars($recipe['prep_time']) ?> minutes</p>
                            <a href="#" class="btn-pink">View Recipe</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            No recipes found.
        </div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="footer">
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
                    <li><a href="#">My Profile</a></li>
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

<!-- JS Scroll and Favorite Heart Script -->
<script>
$(document).ready(function () {
    $(".scroll-container").each(function () {
        let scrollContainer = $(this);
        scrollContainer.on("wheel", function (event) {
            event.preventDefault();
            this.scrollLeft += event.originalEvent.deltaY * 1.5;
        });
    });
    $(".scroll-button").on("click", function () {
        let targetId = $(this).data("target");
        let scrollContainer = $("#" + targetId);
        let scrollAmount = $(this).hasClass("scroll-left") ? "-=400" : "+=400";
        scrollContainer.animate({ scrollLeft: scrollAmount }, 400, "swing");
    });

    const hearts = document.querySelectorAll(".favorite-container");
    hearts.forEach(heartContainer => {
        heartContainer.addEventListener("click", function () {
            const icon = this.querySelector("i");
            icon.classList.toggle("fa-regular");
            icon.classList.toggle("fa-solid");
            this.classList.toggle("active");
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
