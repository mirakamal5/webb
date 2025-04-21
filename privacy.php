<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']) ? 'true' : 'false';
?>
<!DOCTYPE html>
<!-- page created by Mira Kamal -->
<html lang="en">
<head>    
    <meta charset="UTF-8">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Privacy Policy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {            
            background-image: url('../images/cakes.jpg'); 
            background-size: 160% auto; 
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #fbf3ed;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #d46a7e;
            font-family: 'Poppins', sans-serif;
            font-size: 3em;
        }

        h2 {
            color: #d46a7e;
            font-family: 'Poppins', sans-serif;
            font-size: 2em;
            margin-top: 20px;
        }

        p {
            font-family: 'Poppins', sans-serif;
            color: #6D6875;
            line-height: 1.6;
        }

        ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        ul li {
            margin-bottom: 10px;
        }

        .mission {
            margin-top: 20px;
            background: #fbf3ed;
            padding: 15px;
            border-radius: 10px;
            font-style: italic;
            color: #caa2bb;
        }

        .socials {
            margin-top: 20px;
        }

        .socials a {
            margin: 0 10px;
            color: #E76F51;
            text-decoration: none;
            font-size: 24px;
        }

        /* Navbar Styles */
        .custom-navbar {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            background-color: #fbf3ed !important; /* Fix for navbar background color */
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
        <h1>Privacy Policy</h1>
        <p>
            Welcome to bake وبس! We are committed to protecting your privacy and ensuring that your personal information is handled responsibly. This Privacy Policy explains how we collect, use, and safeguard your data when you use our website to explore, add, or share recipes. By using our platform, you agree to the practices described in this policy.
        </p>

        <h2>1. Information We Collect</h2>
        <p>
            We collect the following types of information to provide and improve our services:
        </p>
        <ul>
            <li><strong>Personal Information:</strong> When you create an account, we collect your name, email address, username, and password.</li>
            <li><strong>Recipe Data:</strong> Recipes you submit, including ingredients, instructions, photos, and any additional details you provide.</li>
            <li><strong>Usage Data:</strong> Information about how you interact with our website, such as pages visited, recipes viewed, and search queries.</li>
            <li><strong>Cookies and Tracking Technologies:</strong> We use cookies and similar tools to enhance your experience, remember your preferences, and analyze website traffic.</li>
        </ul>

        <h2>2. How We Use Your Information</h2>
        <p>
            We use the information we collect for the following purposes:
        </p>
        <ul>
            <li>To enable you to create, share, and explore recipes on our platform.</li>
            <li>To improve our website’s functionality and user experience.</li>
            <li>To communicate with you about your account, updates, promotions, or other relevant information.</li>
            <li>To analyze website usage and trends to better understand our community’s needs.</li>
        </ul>

        <h2>3. Sharing Your Information</h2>
        <p>
            We respect your privacy and only share your information in the following circumstances:
        </p>
        <ul>
            <li><strong>Public Content:</strong> Recipes and usernames you submit may be visible to other users of the website.</li>
            <li><strong>Service Providers:</strong> We may share data with trusted third-party service providers who assist us in operating the website, such as hosting, analytics, or customer support.</li>
            <li><strong>Legal Requirements:</strong> We may disclose information if required by law or to protect the rights, safety, or property of our users or the public.</li>
        </ul>
        <p>
            We do not sell your personal information to third parties.
        </p>

        <h2>4. Your Rights and Choices</h2>
        <p>
            You have the following rights regarding your personal information:
        </p>
        <ul>
            <li><strong>Access:</strong> You can request a copy of the personal information we hold about you.</li>
            <li><strong>Correction:</strong> You can update or correct your account information at any time through your account settings.</li>
            <li><strong>Deletion:</strong> You can request the deletion of your account and associated data.</li>
            <li><strong>Opt-Out:</strong> You can opt out of receiving promotional emails by following the unsubscribe link in the email.</li>
            <li><strong>Cookies:</strong> You can manage cookies and tracking technologies through your browser settings.</li>
        </ul>

        <h2>5. Data Security</h2>
        <p>
            We take reasonable measures to protect your personal information from unauthorized access, loss, or misuse. However, no online platform can guarantee absolute security. We encourage you to use strong passwords and keep your account information confidential.
        </p>

        <h2>6. Children’s Privacy</h2>
        <p>
            Our website is not intended for users under the age of 13. We do not knowingly collect personal information from children. If we become aware that a child has provided us with personal information, we will take steps to delete it.
        </p>

        <h2>7. International Users</h2>
        <p>
            If you are accessing our website from outside Lebanon, please be aware that your information may be transferred to, stored, and processed in Lebanon, where our servers are located. By using our website, you consent to this transfer.
        </p>

        <h2>8. Changes to This Policy</h2>
        <p>
            We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. Any updates will be posted on this page with a revised “Last Updated” date. We encourage you to review this policy periodically to stay informed about how we are protecting your information.
        </p>

        <h2>9. Contact Us</h2>
        <p>
            If you have any questions, concerns, or requests regarding this Privacy Policy or your personal information, please contact us at [Insert Contact Email]. We’re here to help!
        </p>

        <div class="mission">
            <p>"Your privacy is our priority. We’re here to ensure your baking adventures are safe and enjoyable!"</p>
        </div>
        <div class="socials">
            <a href="#">&#9825;</a>
            <a href="#">&#127856;</a>
            <a href="#">&#127851;</a>
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
</body>
</html>