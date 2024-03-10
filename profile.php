<?php

use MongoDB\BSON\ObjectId; 
 
require 'vendor/autoload.php';

session_start();

// Check if the session variable indicating login status is set
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// If logged in, continue with the page content

// MongoDB connection
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->muzikiszn; // Replace 'your_database_name' with your actual database name
$userCollection = $database->user;
$profileCollection = $database->profile;

// Fetch existing profile information if available
$existingProfile = $profileCollection->findOne(['user_id' => $_SESSION['user_id']]);

// Initialize variables to store existing profile data
$firstName = '';
$lastName = '';
$email = '';
$phone = '';
$address = '';

// If existing profile data is found, populate the form fields
if ($existingProfile) {
    $firstName = $existingProfile['firstName'];
    $lastName = $existingProfile['lastName'];
    $email = $existingProfile['email'];
    $phone = $existingProfile['phone'];
    $address = $existingProfile['address'];
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have retrieved the user's _id from the session or any other source
    $userId = $_SESSION['user_id']; // Replace 'user_id' with the actual session variable storing the user's _id

    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Prepare document to insert into MongoDB
    $document = [
        'user_id' => ($userId),
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'phone' => $phone,
        'address' => $address
    ];

    // Insert document into "profile" collection
    $insertResult = $profileCollection->insertOne($document);

    if ($insertResult->getInsertedCount() > 0) {
        echo "Profile information saved successfully.";
    } else {
        echo "Failed to save profile information.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <style>
      .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: whitesmoke;
        }

        h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .profile-bg{
            background: linear-gradient(to left,rgb(102, 102, 179),rgb(188, 198, 234));
        }
    </style>
</head>
<body class="profile-bg">
    <div class="container">
        <h2>Profile Settings</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="123-456-7890" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="4" required><?php echo $address; ?></textarea>
            </div>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
