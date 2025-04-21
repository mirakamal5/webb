<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']) ? 'true' : 'false';
?>
<!DOCTYPE html>
<!-- page created by Rim Serhan -->
<html lang="en">
<head>
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
                    <a class="nav-link active" aria-current="page" href=" index.html">Home</a>
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
                        <li><a class="dropdown-item" href="recipes.html">Explore</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Login Button and Profile Icon -->
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
    <section class="contact">
        <div class="content">
            <h2>Contact Us</h2>
            <p>We'd love to talk to you</p>
        </div>
        <div class="container">
            <div class="contactInfo">
                <div class="box">
                    <div class="Icon">
                        <i class="fa fa-star" aria-hidden="true" style="color:#f5a4b5;"></i>
                    </div>
                    <div class="text">
                        <h3>Rim Serhan</h3>
                        <a  href = "mailto:rim.serhan@lau.edu">rim.serhan@lau.edu</a>
                    </div>
                </div>

                <div class="box">
                    <div class="Icon">
                        <i class="fa fa-heart" aria-hidden="true" style="color:#dc889a;"></i>
                    </div>
                    <div class="text">
                        <h3>Ranim Ibrahim</h3>
                        <a  href = "mailto:ranim.ibrahim@lau.edu">ranim.ibrahim@lau.edu</a>
                    </div>
                </div>

                <div class="box">
                    <div class="Icon">
                        <i class="fa fa-star" aria-hidden="true" style="color:#f5a4b5;"></i>
                    </div>
                    <div class="text">
                        <h3>Yassine El Zeort</h3>
                        <a  href = "yassine.elzeort@lau.edu">yassine.elzeort@lau.edu</a>
                    </div>
                </div>

                <div class="box">
                    <div class="Icon">
                        <i class="fa fa-heart" aria-hidden="true" style="color:#dc889a;"></i>
                    </div>
                    <div class="text">
                        <h3>Mira kamal</h3>
                        <a  href = "mailto:mira.kamal@lau.edu">mira.kamal@lau.edu</a>
                    </div>
                </div>
            </div>
            <div class="contactForm">
                <form action="process_contact.php" method="POST">
                    <h2>Send message</h2>
                    <div class="inputBox">
                        <label for="fname">Full Name:</label><br>
                        <input type="text" id="fname" name="fname" placeholder="Name" required="required">
                    </div>
                    <div class="inputBox">
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" placeholder="Email" required="required">
                    </div>
                    <div class="inputBox">
                        <label for="message">Message:</label><br>
                        <textarea required="required" id="message" name="message" placeholder="Type your message..."></textarea>
                    </div>
                    <div class="inputBox">
                        <input type="submit" name="" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="containerf">
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
                        <li><a href="#">My Profile</a></li>
                        <li><a href="recipes.html">All Recipes</a></li>
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
</body>
</html>