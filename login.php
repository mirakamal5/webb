<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<!-- page created by Yassine Zeort -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    

     <!-- mira -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <style>

        
        /* Navbar Styles */
        .custom-navbar {
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        background-color: #fbf3ed !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        padding: 15px 20px;
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

                <!-- Login Button and Profile Icon -->
                <div class="d-flex">
                    <?php if (!$isLoggedIn): ?>
                        <button class="btn btn-outline-danger me-2" onclick="window.location.href='login.php'">Log In</button>
                    <?php else: ?>
                        <button class="btn btn-outline-danger me-2" onclick="window.location.href='#'">Logging In...</button>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    
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
            
    <div class="custom-container">
        <div class="form-box login">
            <form action="loginprocess.php" method="POST">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required> 
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required> 
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="forgot-link">
                    <a href="#">Forget password</a>
                </div>
                <div class="input-box">
                    <!-- <input type="checkbox" name="remember" id="remember"> -->
                    <!-- <label for="remember">Remember Me</label> -->
                </div>
                <button type="submit" class="custom-btn">Login</button>
                <p>or login with social platforms</p>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-google' ></i></a>
                    <a href="#"><i class='bx bxl-facebook' ></i></a>
                    <a href="#"><i class="bx bxl-instagram"></i></a>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <form action="register.php" method="POST">
                <h1>Registration </h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required> 
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="email" placeholder="Email" required> 
                    <i class='bx bxs-envelope' ></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required> 
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="custom-btn">Register</button>
                <p>or register with social platforms</p>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-google' ></i></a>
                    <a href="#"><i class='bx bxl-facebook' ></i></a>
                    <a href="#"><i class="bx bxl-instagram"></i></a>
                </div>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome!</h1>
                <p>Don't have an account?</p>
                <button class="custom-btn register-custom-btn">Register</button>
            </div>
            
            <div class="toggle-panel toggle-right">
                <h1>Welcome Back!</h1>
                <p>Already have an account?</p>
                <button class="custom-btn login-custom-btn">Login</button>
            </div>

        </div>
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
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.querySelector(".custom-container");
            const registerBtn = document.querySelector(".register-custom-btn"); 
            const loginBtn = document.querySelector(".login-custom-btn"); 
        
            if (registerBtn) {
                registerBtn.addEventListener("click", function () {
                    container.classList.add("active"); // Switch to Register Form
                });
            }
        
            if (loginBtn) {
                loginBtn.addEventListener("click", function () {
                    container.classList.remove("active"); // Switch to Login Form
                });
            }
        });
        </script>
        
        

    <script src="script.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const alerts = document.querySelectorAll('.alert');

            if (alerts.length > 0) {
                setTimeout(() => {
                    alerts.forEach(alert => {
                        alert.style.transition = "opacity 0.5s ease";
                        alert.style.opacity = '0';
                        setTimeout(() => {
                            alert.remove();
                        }, 500);
                    });
                }, 4000);
            }
        });
    </script>

</body>
</html>
