<?php

// Include MongoDB library
require 'vendor/autoload.php';

// Set MongoDB connection parameters
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->muzikiszn; // Change 'your_database_name' to your actual database name
$collection = $database->user; // Change 'users' to your actual collection name

session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Find user by email
    $user = $collection->findOne(['email' => $email]);
    
//     // Check if user exists and verify password
//     if ($user && password_verify($password, $user['password'])) {
//       // Start session and store user information
//       $_SESSION['user_id'] = $user['_id']; // Assuming '_id' is the user's unique identifier
//       $_SESSION['username'] = $user['username']; // Assuming 'username' is a field in the user document

//       // Redirect to dashboard or another page
//       header("Location: dashboard.php");
//       exit();
//   } else {
//       echo "Invalid email or password";
//   }
// }

    // Check if user exists and verify password
      if ($user && password_verify($password, $user['password'])) {
          echo "Login successful!";
          $_SESSION['user_id'] = $user['_id']; // Assuming '_id' is the user's unique identifier
          $_SESSION['name'] = $user['name']; // Assuming 'username' is a field in the user document
          // Redirect to dashboard or another page
          header("Location: dashboard.php");
          exit();
      } else {
          echo "Invalid email or password";
      }
}
?>












<!DOCTYPE html>
<html>
  <head>
    <title>login page</title>
    <style>
      p{
        font-family: Verdana, Geneva, Tahoma, sans-serif;
      }
      .user-login-title{
        font-size: large;
        font-weight: bold;
        height: 50px;
        
        color: whitesmoke;

      }
      .username-or-email{
        height: 40px;
        width: 300px;
        border-color: black;
        border-radius: 5px;
        margin-bottom: 20px;
        border: solid;
      }
      .password-input{
        height: 40px;
        width: 300px;
        border-color: black;
        border-radius: 5px;
        margin-bottom: 20px;
        border: solid;
      }
      .login-button{
        height: 30px;
        width: 100px;
        border-color: black;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 20px;
        background-color: rgb(82, 152, 222);
      
      }
      .login-button:hover,.signup-button:hover{
        background-color: rgb(86, 50, 171);
        color: whitesmoke;
        transition: 0.5s;
      }
      .color{
        background-color: #610C9F;
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: url("assets/pexels-photo-690779.jpeg");
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
      }
      .login-bg{
        background-color: #1e2227;
        padding: 12px;
        width: 30%;
        height: 300px;
        border: 2px grey solid;
        margin-top: 150px;
        border-radius: 7px;
        border: none;
        
                
      }
      .center{
        display: flex;
        align-items: center;
        justify-content: center;
        color: aliceblue;
      }
    </style>
  </head>

  <body class="color">

    <div class="login-bg">
        
      <div class="user-login-title center" >
          USER LOGIN
        </div>
        <form action="login.php" method="post">  
          <div class="center">
          <input class="username-or-email" type="text" placeholder="Enter email" name="email" required>
        </div>
        <div class="center">
          <input class="password-input" type="password" placeholder="password" name="password" required>
        </div>
        <div class="center">
          <button class="login-button"> 
            Login
          </button>
        </div>
        <div class="center"></form>
          <p>Don't have an account?</p>
          <a href="signup.php">Sign up</a>
      </div>
    </div>
  </body>
</html>