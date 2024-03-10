<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Set MongoDB connection parameters
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->muzikiszn; // Change 'your_database_name' to your actual database name
$collection = $database->user; // Change 'users' to your actual collection name

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];

    // Find user by email
    $user = $collection->findOne(['email' => $email]);

    // Check if user exists
    if ($user) {
        // Generate a unique token (you can use PHP's built-in function uniqid())
        $token = uniqid();

        // Store the token in the user's document in the database
        $collection->updateOne(['_id' => $user['_id']], ['$set' => ['reset_token' => $token]]);

        // Send an email to the user with the reset link containing the token
        try {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

          

            // Set mailer to use SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Specify SMTP server
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'your_email@gmail.com'; // SMTP username
            $mail->Password = 'your_password'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption
            $mail->Port = 587; // TCP port to connect to

            // Set sender and recipient
            $mail->setFrom('your_email@gmail.com', 'Your Name');
            $mail->addAddress($email, $user['name']); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Password Reset Instructions';
            $mail->Body = "Hello " . $user['name'] . ",<br><br>Click <a href='http://localhost:8000/reset_password.php?token=$token'>here</a> to reset your password.<br><br>Best regards,<br>Your Name";

            // Send email
            $mail->send();

            echo "An email with instructions to reset your password has been sent to your email address.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No user found with that email address.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        
        div {
            margin: 0 auto;
            width: 300px;
            text-align: center;
        }
        input {
            margin: 10px 0;
            width: 100%;
            height: 30px;
            padding: 0 10px;
            border: none;
            border-radius: 5px;

        }
        button {
            width: 100%;
            height: 30px;
            background-color: #4CAF50;
            color: white;
            border: none;

        }
    </style>
</head>
<body>
<div>
    <div>
        PASSWORD RESET
    </div>
    <form action="password_reset.php" method="post">
        <input type="text" placeholder="Enter email" name="email" required>
        <button type="submit">Reset Password</button>
    </form>
</div>
</body>
</html>