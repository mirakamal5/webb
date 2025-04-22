<?php
session_start();
require_once 'config.php';
$isLoggedIn = isset($_SESSION['user_id']);

// logged in?
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must login first.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? '';
$email = $_SESSION['email'] ?? '';

// profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = trim($_POST['bio'] ?? '');
    $hobbies = trim($_POST['hobbies'] ?? '');
    $Userrole = trim($_POST['Userrole'] ?? 'Baker');

    $bio = $bio !== '' ? $bio : 'No bio yet';
    $hobbies = $hobbies !== '' ? $hobbies : 'Still looking for new hobbies...';
    $Userrole = $Userrole !== '' ? $Userrole : 'Baker';

    //  image upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["profile_pic"]["name"]);
        $targetFile = $targetDir . time() . "_" . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFile)) {
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

    // no image
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

// user info
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

// recipes posted by the user
$stmtRecipes = $con->prepare("SELECT * FROM recipe WHERE user_id = :id ORDER BY created_at DESC");
$stmtRecipes->execute([':id' => $user_id]);
$recipes = $stmtRecipes->fetchAll(PDO::FETCH_ASSOC);

// rating
$rating = round($user['rating'] ?? 0);
$fullStars = str_repeat('<span style="color: #dc889a; font-size: 22px; line-height: 0.7;">★</span>', $rating);
$emptyStars = str_repeat('<span style="color: #dc889a; font-size: 22px; line-height: 0.7;">☆</span>', 5 - $rating);
$ratingStars = $fullStars . $emptyStars;

$ratingNumber = '<span style="color: #333; font-size: 30px; font-weight: bold;">' . $rating . '</span>';

//get posted recipes
$postedQuery = $con->prepare("SELECT * FROM recipe WHERE user_id = ?");
$postedQuery->execute([$user_id]);
$postedRecipes = $postedQuery->fetchAll(PDO::FETCH_ASSOC);

// get favorite recipes
$favQuery = $con->prepare("
    SELECT r.* FROM recipe r
    INNER JOIN favorites f ON r.id = f.recipe_id
    WHERE f.user_id = ?
");
$favQuery->execute([$user_id]);
$favRecipes = $favQuery->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style3.css">
    <style>
        .tabs ul li.active-tab {
            border-radius: 10px;
            color:rgb(177, 43, 72);
        }
        .save-btn-custom {
            background: none;
            border: none;
            color:rgb(65, 54, 59);
            font-weight: normal;
            padding: 0;
            cursor: pointer;
        }

        .save-btn-custom:hover,
        .save-btn-custom:focus {
            color:rgb(65, 54, 59);
            font-weight: bold;
            outline: none;
        }
        .tab-content{
            width:100%;
        }
        .tab-content .recipe-card{
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            width: 250px; 
            height: 350px;
            background-color:rgb(254, 227, 234) ;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding:0px;
            height: auto;
        }

        .tab-content .favorite-container {
            position: absolute;   
            top: 10px;            
            right: 10px;         
            background-color:rgb(220, 219, 220) ;
            padding:8px;
            border-radius: 50%;  
        }

        .tab-content .favorite-icon i {
            color:rgb(252, 109, 147) ;           /* Make the heart red */
            font-size: 24px;      /* Adjust the size of the heart */
        }

        .tab-content .recipe-card .recipe-img{
            height:270px;
            width:100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }
        .tab-content .recipe-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center; 
            text-align: center;         
        }
        .btn-pink {
            background-color:rgb(229, 155, 174); 
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
        a {
            text-decoration: none; 
            color: inherit;   
            display: block;   
        }
        .recipe-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .recipe-card:hover {
            transform: scale(1.02);
        }

    </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
            <?php if (!$isLoggedIn): ?>
                <button class="btn btn-outline-danger me-2" onclick="window.location.href='login.php'">Log In</button>
            <?php else: ?>
                <button class="btn btn-outline-danger me-2" onclick="window.location.href='#'"><?php echo htmlspecialchars($user['username']); ?>'s profile</button>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container">
    <section class="userDetails card">
        <div class="profile">
            <figure>
                <img src="<?php echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'images/default.png'; ?>" alt="Profile Picture" width="150px" >
            </figure>
        </div>

        <div class="userName">
            <h1 class="name"><?php echo htmlspecialchars($user['username']); ?></h1>
            <p style="color: #dc889a"><?php echo htmlspecialchars($user['Userrole']); ?></p>
        </div>

        <div class="rank">
            <h1 class="heading">My Ratings</h1>
            <span><?php echo $rating; ?></span>
            <div class="rating"><?php echo $ratingStars; ?></div>
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
                <li class="timeline active-tab" onclick="showTab('posted')">
                    <i class="ri-eye-fill ri"></i><span>Recipes Posted</span>
                </li>
                <li class="timeline" onclick="showTab('favorites')">
                    <i class="ri-heart-fill ri"></i><span>Favorites</span>
                </li>
            </ul>
        </div>

        <div id="postedTab" class="tab-content">
            <?php if (count($postedRecipes) > 0): ?>
                <div class="row d-flex flex-wrap justify-content-between">
                    <?php foreach ($postedRecipes as $recipe): ?>
                        <div class="recipe-card">
                            <img src="images/<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>" class="recipe-img">
                            <div class="card-body">
                                <a href="individual-recipes.php?id=<?php echo $recipe['id']; ?>"><?php echo htmlspecialchars($recipe['name']); ?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php
                    $count = count($postedRecipes);
                    $placeholders = 3 - $count;
                    for ($i = 0; $i < $placeholders; $i++): ?>
                        <div class="col-md-4 mb-4"></div>
                    <?php endfor; ?>
                </div>
            <?php else: ?>
                <p style="color: grey;">You have not posted any recipes yet.</p>
            <?php endif; ?>
            <a href="AddYourRecipe.php" style="color: inherit;text-decoration: none;">
                <button class="heart-button" id="upload-btn">🩷</button>
                <span>Add recipe</span>
            </a>
        </div>

        <div id="favoritesTab" class="tab-content" style="display: none;">
            <?php if (count($favRecipes) > 0): ?>
                <div class="row d-flex flex-wrap justify-content-between">
                    <?php foreach ($favRecipes as $recipe): ?>
                        <div class="recipe-card">
                            <div class="favorite-container">
                                <span class="favorite-icon">
                                    <i class="fa-solid fa-heart"></i>
                                </span>
                            </div>
                            <img src="images/<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>" class="recipe-img" style="height:200px;">
                            <div class="card-body">
                                <h5><?php echo htmlspecialchars($recipe['name']); ?></h5>
                                <a href="#" class="btn-pink">View Recipe</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php
                    // if less than 3 recipes
                    $count = count($favRecipes);
                    $placeholders = 3 - $count;
                    for ($i = 0; $i < $placeholders; $i++): ?>
                        <div class="col-md-4 mb-4"></div>
                    <?php endfor; ?>
                </div>
            <?php else: ?>
                <p style="color: grey;">You have not favorited any recipes yet.</p>
            <?php endif; ?>
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

            document.getElementById("UserroleInput").addEventListener("input", (e) => {
                document.getElementById("UserroleCharCount").textContent = e.target.value.length;
            });

            document.getElementById("bioInput").addEventListener("input", (e) => {
                document.getElementById("bioCharCount").textContent = e.target.value.length;
            });

            document.getElementById("hobbiesInput").addEventListener("input", (e) => {
                document.getElementById("hobbiesCharCount").textContent = e.target.value.length;
            });

            let saveButton = document.querySelector(".save-btn");  
            if (!saveButton) {
                saveButton = document.createElement("button");
                saveButton.className = "save-btn-custom mt-3";
                saveButton.style.border = "none"; 
                saveButton.innerHTML = '<span style="font-size: 20px;">🩷</span> <span style="font-size: 14px;">Save Changes</span>';
                saveButton.style.backgroundColor= "transparent"; 

                const lineBreak = document.createElement("br");
                spanText.parentNode.appendChild(lineBreak); 
                spanText.parentNode.appendChild(saveButton);
            }

            saveButton.addEventListener("click", () => {
                const bioVal = document.getElementById("bioInput").value.trim() || bioDefault;
                const hobbiesVal = document.getElementById("hobbiesInput").value.trim() || hobbiesDefault;
                const UserroleVal = document.getElementById("UserroleInput").value.trim() || UserroleDefault;

                fetch("profile page.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `bio=${encodeURIComponent(bioVal)}&hobbies=${encodeURIComponent(hobbiesVal)}&Userrole=${encodeURIComponent(UserroleVal)}`
                })
                .then(res => res.text())
                .then(data => {
                    if (data.includes("Profile updated successfully")) {
                        alert("Changes saved!");
                        window.location.reload();  
                    } else {
                        alert("Failed to save. Server response:\n" + data);
                    }
                })
                .catch(err => console.error(err));
            });
        });
    });
    </script>

    <script>
        function showTab(tab) {
            const posted = document.getElementById("postedTab");
            const favorites = document.getElementById("favoritesTab");
            const tabs = document.querySelectorAll(".tabs ul li");

            // Remove active from all tabs
            tabs.forEach(t => t.classList.remove("active-tab"));

            // Show the selected tab
            if (tab === 'posted') {
                posted.style.display = "block";
                favorites.style.display = "none";
                tabs[0].classList.add("active-tab");
            } else {
                posted.style.display = "none";
                favorites.style.display = "block";
                tabs[1].classList.add("active-tab");
            }
        }
    </script>

</body>
</html>
