<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']) ? 'true' : 'false';
?>
<!DOCTYPE html>
<!-- page created by Ranim Ibrahim -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>FAQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-image: url('https://i.pinimg.com/736x/ec/88/01/ec88011e4d940a6fbfde37d59b58b85b.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Poppins', serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #fbf3ed; 
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
       /* Navbar Styles */
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

/* Responsive Navbar Styles */
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
        h1 {
            color: #d46a7e;
            font-family:'Poppins', sans-serif;
            font-size: 3em;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 300;
        }

        h2 {
            color: #d46a7e;
            font-family:'Poppins', sans-serif;
            font-size: 2em;
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: 300;
        }
        .faq-item {
            margin-bottom: 15px;
        }

        .faq-question {
            width: 100%;
            text-align: left;
            padding: 15px;
            background: #FFF0F5;
            border: none;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 1.1em;
            color: #464343;
            cursor: pointer;
            transition: background 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-question:hover {
            background: #fbf3ed;
        }

       
        .faq-answer {
            padding: 15px;
            background: #FFF0F5;
            border-radius: 10px;
            margin-top: 5px;
            display: none;
            font-family: 'Poppins', sans-serif;
            color: #6D6875;
        }

        .faq-answer p {
            margin: 0;
        }

        .faq-answer.active {
            display: block;
        }

        .faq-question::after {
            content: '+';
            font-size: 1.5em;
            color: #f175b9;/*hyde lal + - buttons*/
        }

        .faq-question.active::after {
            content: '-';
        }
     /* Footer Styles */
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

/* Responsive Footer Styles */
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
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Lato&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar custom-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/final.png" alt="Website Logo" width="80" height="50" class="d-inline-block align-text-top">
            </a>
            <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="about us.php">About Us</a>
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

            <!-- Login Button and Profile Icon -->
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
    <div class="container">
        <h1>Frequently Asked Questions</h1>

   
        <h2>General Questions</h2>
        <div class="faq-item">
            <button class="faq-question">What is this website about?</button>
            <div class="faq-answer">
                <p>This website is a place for baking enthusiasts to share recipes, tips, and stories. Whether you're a beginner or an expert, you'll find something sweet here!</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Who is this website for?</button>
            <div class="faq-answer">
                <p>This website is for anyone who loves baking, from beginners to seasoned bakers. If you enjoy creating delicious treats, you'll feel right at home.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Do I need to create an account to use this website?</button>
            <div class="faq-answer">
                <p>No, you don't need an account to browse recipes. However, creating an account allows you to save your favorite recipes, leave comments, and share your own creations.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Is this website free to use?</button>
            <div class="faq-answer">
                <p>
                    Yes, this website is completely free to use. We believe baking should be accessible to everyone!</p>
            </div>
        </div>
         <div class="faq-item">
            <button class="faq-question">Can I contribute my own recipes?How?</button>
            <div class="faq-answer">
                <p>
                    Absolutely! We encourage users to share their favorite recipes. 
                    Simply create an account and submit your recipe through the "Add Your Recipe" page.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Do you offer baking classes or workshops?</button>
            <div class="faq-answer">
                <p>
                    Not currently, but we’re planning to host virtual baking classes in the future, in addition to baking challenges between our users. Stay tuned!</p>
            </div>
        </div>
       

        <h2>Recipe Questions</h2>
        <div class="faq-item">
            <button class="faq-question">Can I substitute ingredients in your recipes?</button>
            <div class="faq-answer">
                <p>Yes, you can! We encourage experimentation. However, results may vary depending on the substitutions.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Are your recipes tested before being published?</button>
            <div class="faq-answer">
                <p>Our team works hard to make sure all the recipes posted by different bakers are legitemate; 
                    however, we encourage reeading through the ingredients before preceding with baking. 
                </p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Can I adjust the serving size of a recipe?</button>
            <div class="faq-answer">
                <p>Yes, most of our posted recipes include a serving size calculator. Simply input the number of servings you need, and the ingredient quantities will adjust automatically. 
                </p>
            </div>
        </div>

        <h2>Technical Questions</h2>
        <div class="faq-item">
            <button class="faq-question">How do I contact you?</button>
            <div class="faq-answer">
                <p>You can reach us via email at <a href="mailto:contact@BakeWBas.com">contact@BakeWBas.com</a>.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Can I share your recipes on social media?</button>
            <div class="faq-answer">
                <p>Yes, please do! We'd love for you to share our bakers' recipes. Just make sure to credit the baker and link back to our website.</p>
            </div>
        </div>
        
        <div class="faq-item">
            <button class="faq-question">How do I reset my password?</button>
            <div class="faq-answer">
                <p>Click on the "Forgot Password" link on the login page and follow the instructions sent to your email.</p>
            </div>
        </div>

    </div>
<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col">
                <h4>About Us</h4>
                <ul>
                    <li><a href="about us.php">About us</a></li>
                    <li><a href="contactUs.php">Contact us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Help & Policies</h4>
                <ul>
                    <li><a href="faqpage.php">FAQ</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', () => {
                const answer = button.nextElementSibling;
                button.classList.toggle('active');
                answer.classList.toggle('active');
            });
        });
    </script>
</body>
</html>