<?php
include 'config.php'; // assuming this sets up $conn as a PDO object

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['fname'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    try {
        // Insert into database using PDO
        $stmt = $conn->prepare("INSERT INTO contact_messages (full_name, email, message) VALUES (:name, :email, :message)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':message' => $message
        ]);

        // Define multiple recipients
        $recipients = [
            "rim.serhan@lau.edu",
            "ranim.ibrahim@lau.edu",
            "yassine.elzeort@lau.edu",
            "mira.kamal@lau.edu"
        ];

        $subject = "New Contact Form Submission";
        $body = "You have a new message from the contact form:\n\n"
              . "Full Name: $name\n"
              . "Email: $email\n\n"
              . "Message:\n$message";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Loop through each recipient to send the email individually
        foreach ($recipients as $to) {
            mail($to, $subject, $body, $headers);
        }

        echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='contactUs.html';</script>";
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>