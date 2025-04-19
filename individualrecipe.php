<?php
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// Flags and messages
$addedToFavorites = false;
$ratingMessage = '';
$discussionMessage = '';

// Handle Add to Favorites
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_favorite'])) {
    if ($isLoggedIn) {
        // TODO: Save to database
        $addedToFavorites = true;
    } else {
        // Redirect to login page
        header('Location: loginpage.html');
        exit();
    }
}

// Handle Rating Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_rating'])) {
    if ($isLoggedIn) {
        $rating = $_POST['rating'];
        // TODO: Save rating to database
        $ratingMessage = "Thanks! You rated this recipe $rating star(s).";
    } else {
        $ratingMessage = "You must be logged in to rate.";
    }
}

// Handle Discussion Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_discussion'])) {
    if ($isLoggedIn) {
        $comment = htmlspecialchars($_POST['discussion']);
        // TODO: Save comment to database
        $discussionMessage = "Comment submitted: " . $comment;
    } else {
        $discussionMessage = "You must be logged in to comment.";
    }
}
?>
