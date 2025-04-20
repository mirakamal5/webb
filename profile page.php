<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must login first.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? '';
$email = $_SESSION['email'] ?? '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = trim($_POST['bio'] ?? '');
    $hobbies = trim($_POST['hobbies'] ?? '');
    $Userrole = trim($_POST['Userrole'] ?? 'Baker'); // Still comes from the 'baker' input field

    $bio = $bio !== '' ? $bio : 'No bio yet';
    $hobbies = $hobbies !== '' ? $hobbies : 'Still looking for new hobbies...';
    $Userrole = $Userrole !== '' ? $Userrole : 'Baker';

    // Handle image upload if present
    if (!empty($_FILES['profile_pic']['name'])) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["profile_pic"]["name"]);
        $targetFile = $targetDir . time() . "_" . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFile)) {
                // Save image + profile info in DB
                $stmt = $con->prepare("UPDATE users SET profile_picture = :pic, Userrole = :Userrole, bio = :bio, hobbies = :hobbies WHERE user_id = :id");
                $stmt->execute([
                    ':pic' => $targetFile,
                    ':bio' => $bio,
                    ':hobbies' => $hobbies,
                    ':Userrole' => $Userrole,
                    ':id' => $user_id
                ]);
                $_SESSION['success'] = "Profile updated successfully!";
            } else {
                $_SESSION['error'] = "Error uploading the file.";
            }
        } else {
            $_SESSION['error'] = "Invalid image type.";
        }
        header("Location: profile page.php");
        exit();
    }

    // If no image, just update text info
    $stmt = $con->prepare("UPDATE users SET bio = :bio, hobbies = :hobbies, Userrole = :Userrole WHERE user_id = :id");
    $stmt->execute([
        ':bio' => $bio,
        ':hobbies' => $hobbies,
        ':Userrole' => $Userrole,
        ':id' => $user_id
    ]);
    $_SESSION['success'] = "Profile updated successfully!";
    header("Location: profile page.php");
    exit();
}



// Fetch user info
$stmt = $con->prepare("SELECT u.username, u.email, u.bio, u.hobbies, u.Userrole, u.profile_picture,
        (SELECT AVG(r.rating) FROM user_ratings r WHERE r.user_id = u.user_id) AS rating
    FROM users u 
    WHERE u.user_id = :id 
    LIMIT 1
");
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<p style='color: red;'>User not found in the database. (user_id = $user_id)</p>";
    exit();
}


// Rating Logic
$rating = round($user['rating'] ?? 0);
$fullStars = str_repeat('<span style="color: #dc889a; font-size: 22px; line-height: 0.7;">★</span>', $rating);
$emptyStars = str_repeat('<span style="color: #dc889a; font-size: 22px; line-height: 0.7;">☆</span>', 5 - $rating);
$ratingStars = $fullStars . $emptyStars;

$ratingNumber = '<span style="color: #333; font-size: 30px; font-weight: bold;">' . $rating . '</span>';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style3.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <nav class="navbar custom-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/final.png" alt="Website Logo" width="80" height="50">
            </a>
            <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item me-3"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="about us.html">About Us</a></li>
                
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" id="recipeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Recipes
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="recipeDropdown">
                        <li><a class="dropdown-item" href="AddYourRecipe.php">Add</a></li>
                        <li><a class="dropdown-item" href="recipes.php">Explore</a></li>
                    </ul>
                </li>

            </ul>
            <div class="d-flex">
                <button id="loginButton" class="btn btn-outline-danger me-2" onclick="window.location.href='loginpage.html'">Log In</button>
                <div id="profileIcon" class="d-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#c42348" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <section class="userDetails card">
            <div class="profile">
                <figure>
                    <img src="<?php echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'images/default.png'; ?>" alt="Profile Picture" width="150px" height="200px">
                </figure>
            </div>

            <div class="userName">
                <h1 class="name"><?php echo htmlspecialchars($user['username']); ?></h1>
                <p style="color: #dc889a"><?php echo htmlspecialchars($user['Userrole']); ?></p>
            </div>

            <div class="rank">
                <h1 class="heading">My Ratings</h1>
                <span><?php echo $rating; ?></span>
                <div class="rating">
                    <?php echo $ratingStars; ?>
                </div>
            </div>

            <form id="profilePicForm" method="POST" enctype="multipart/form-data">
                <div class="cf">
                    <br>
                    <button class="heart-button" id="upload-btn" type="button">🩷</button>
                    <span>Change profile picture</span>
                    <input type="file" name="profile_pic" id="file-input" style="display: none;" onchange="submitProfilePic()">
                </div>
            </form>
        </section>

        <section class="bio card">
            <div class="work">
                <h1 class="heading">Bio</h1>
                <div class="primary">
                    <p><?php echo htmlspecialchars($user['bio'] ?: 'No bio yet'); ?></p>
                </div>
            </div>

            <div class="skills">
                <h1 class="heading">Hobbies</h1>
                <p><?php echo htmlspecialchars($user['hobbies'] ?: 'Still looking for new hobbies...'); ?></p>
            </div>
            <div class="cf">
                <br>
                <button class="heart-button" id="upload-btn">🩷</button>
                <span>Edit profile</span>
            </div>
        </section>

        <section class="timeline_about card">
            <div class="tabs">
                <ul>
                    <li class="timeline"><i class="ri-eye-fill ri"></i><span>Recipes Posted</span></li>
                    <li class="timeline"><i class="ri-eye-fill ri"></i><span>Favorites</span></li>
                </ul>
            </div>
            <div class="basic_info">
                <br>
                <a href="AddYourRecipe.html">
                    <button class="heart-button" id="upload-btn">🩷</button>
                    <span>Add recipe</span>
                </a>
            </div>
        </section>
    </div>

    <footer class="footer">
        <div class="containerf">
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

    <!-- JavaScript -->
    <script>
        document.getElementById("upload-btn").onclick = function () {
            document.getElementById("file-input").click();
        };

        function submitProfilePic() {
            const form = new FormData(document.getElementById("profilePicForm"));

            fetch("profile page.php", {
                method: "POST",
                body: form
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes("Profile updated successfully")) {
                    alert("Profile picture updated successfully.");
                    window.location.reload();
                } else {
                    alert("Response: "+ data);
                    console.log(data); // Helpful for debugging
                }
            })
            .catch(error => console.error("Error:", error));
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll(".tabs ul li");
            const basicInfo = document.querySelector(".basic_info");
    
            const recipesContent = 
                <br>
                <a href="AddYourRecipe.html">
                    <button class="heart-button" id="upload-btn">🩷</button>
                    <span>Add recipe</span>
                </a>
            ;
    
            const favoritesContent =  
                <p> Favorites is Empty </p>    
            ;

            basicInfo.innerHTML = recipesContent; 
            tabs[0].classList.add("active"); 
            tabs[0].style.color = "#c42348"; 
            tabs[1].style.color = "grey";

            tabs[0].addEventListener("click", function () {
                basicInfo.innerHTML = recipesContent;
                tabs[0].style.color = "#c42348";
                tabs[1].style.color = "grey";
            });
    
            tabs[1].addEventListener("click", function () {
                basicInfo.innerHTML = favoritesContent;
                tabs[1].style.color = "#c42348";
                tabs[0].style.color = "grey"; 
            });
            tabs.forEach(tab => {
                tab.addEventListener("click", function () {
                tabs.forEach(t => t.classList.remove("active"));
                this.classList.add("active");
                });
            });
            
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const editBtn = document.querySelector(".bio .cf .heart-button");
        const spanText = editBtn.nextElementSibling;
        let editing = false;

        editBtn.addEventListener("click", () => {
            if (editing) return;

            editing = true;
            spanText.textContent = "Editing...";

            const UserroleTag = document.querySelector(".userName p");
            const bioText = document.querySelector(".work .primary p");
            const hobbiesText = document.querySelector(".skills p");

            const UserroleDefault = "Baker";
            const bioDefault = "No bio yet";
            const hobbiesDefault = "Still looking for new hobbies...";

            const currentUserrole = UserroleTag.textContent.trim() || UserroleDefault;
            const currentBio = bioText.textContent.trim() || bioDefault;
            const currentHobbies = hobbiesText.textContent.trim() || hobbiesDefault;

            // Replace with form elements
            UserroleTag.innerHTML = `
                <input type="text" id="UserroleInput" maxlength="8" value="${currentUserrole}" class="form-control" style="width: 120px; display: inline;">
                <small><span id="UserroleCharCount">${currentUserrole.length}</span>/8</small>
            `;

            bioText.innerHTML = `
                <textarea id="bioInput" maxlength="270" class="form-control">${currentBio}</textarea>
                <small><span id="bioCharCount">${currentBio.length}</span>/270</small>
            `;

            hobbiesText.innerHTML = `
                <textarea id="hobbiesInput" maxlength="150" class="form-control">${currentHobbies}</textarea>
                <small><span id="hobbiesCharCount">${currentHobbies.length}</span>/150</small>
            `;

            // Character count updates
            document.getElementById("UserroleInput").addEventListener("input", (e) => {
                document.getElementById("UserroleCharCount").textContent = e.target.value.length;
            });

            document.getElementById("bioInput").addEventListener("input", (e) => {
                document.getElementById("bioCharCount").textContent = e.target.value.length;
            });

            document.getElementById("hobbiesInput").addEventListener("input", (e) => {
                document.getElementById("hobbiesCharCount").textContent = e.target.value.length;
            });

            // Create Save Button
            let saveButton = document.querySelector(".save-btn");  // Check if the button already exists
            if (!saveButton) {
                saveButton = document.createElement("button");
                saveButton.className = "save-btn-custom mt-3";
                saveButton.style.border = "none"; 
                saveButton.innerHTML = '<span style="font-size: 20px;">🩷</span> <span style="font-size: 14px;">Save Changes</span>';
                saveButton.style.backgroundColor= "transparent"; 

                // Append the save button right after the "Editing..." text
                const lineBreak = document.createElement("br");
                spanText.parentNode.appendChild(lineBreak); 
                spanText.parentNode.appendChild(saveButton);
            }

            saveButton.addEventListener("click", () => {
                const bioVal = document.getElementById("bioInput").value.trim() || bioDefault;
                const hobbiesVal = document.getElementById("hobbiesInput").value.trim() || hobbiesDefault;
                const UserroleVal = document.getElementById("UserroleInput").value.trim() || UserroleDefault;

                // Send data via fetch to PHP
                fetch("profile page.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `bio=${encodeURIComponent(bioVal)}&hobbies=${encodeURIComponent(hobbiesVal)}&Userrole=${encodeURIComponent(UserroleVal)}`
                })
                .then(res => res.text())
                .then(data => {
                    if (data.includes("Profile updated successfully")) {
                        alert("Changes saved!");
                        window.location.reload();  // Reload to show updated data
                    } else {
                        alert("Failed to save. Server response:\n" + data);
                    }
                })
                .catch(err => console.error(err));
            });
        });
    });


    </script>

</body>
</html>
