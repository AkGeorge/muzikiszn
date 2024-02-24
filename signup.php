<?php

require 'vendor/autoload.php';

// MongoDB connection parameters
$mongoHost = 'localhost'; // MongoDB host
$mongoPort = 27017; // MongoDB port
$mongoDBName = 'muzikiszn'; // MongoDB database name
$collectionName = 'user'; // MongoDB collection name

// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://$mongoHost:$mongoPort");
$mongoDB = $mongoClient->$mongoDBName;

//echo "Connected to MongoDB successfully";


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  // Insert data into MongoDB
  $collection = $mongoDB->$collectionName;

  $userDocument = [
      'name' => $name,
      'email' => $email,
      'password' => $passwordHash // Note: Hash the password before storing it for security
  ];
  $insertResult = $collection->insertOne($userDocument);

  // Check if insertion was successful
  if ($insertResult->getInsertedCount() > 0) {
      echo "User registered successfully";
      //Redirect to dashboard or another page
        header("Location: dashboard.php");
        exit();
  } else {
      echo "Error registering user";
  }
}
?>













<!DOCTYPE html>
<html>
  <head>
    <title>sign up page</title>
    <style>
      p{
        font-family: Verdana, Geneva, Tahoma, sans-serif;
      }
      .signup-title{
        font-size: large;
        font-weight: bold;
        height: 50px;
        
        color: whitesmoke;

      }
      .name{
        height: 40px;
        width: 300px;
        border-color: black;
        border-radius: 5px;
        margin-bottom: 12px;
        border: solid;
      }
      .email{
        height: 40px;
        width: 300px;
        border-color: black;
        border-radius: 5px;
        margin-bottom: 12px;
        border: solid;
      }
      .create-password{
        height: 40px;
        width: 300px;
        border-color: black;
        border-radius: 5px;
        margin-bottom: 12px;
        border: solid;
      }
      .confirm-password{
        height: 40px;
        width: 300px;
        border-color: black;
        border-radius: 5px;
        margin-bottom: 12px;
        border: solid;
      }
      
      .signup-button{
        height: 30px;
        width: 100px;
        border-color: black;
        border-radius: 5px;
        background-color: rgb(82, 152, 222);
        cursor: pointer;
      }
      .signup-button:hover{
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
      .signup-bg{
        background-color: #1e2227;
        padding: 20px;
        width: 30%;
        height: 350px;
        border: 2px grey solid;
        margin-top: 10px;
        border-radius: 7px;
        border: none;
        color: white;
      }
      .center{
        display: flex;
        align-items: center;
        justify-content: center;
      }
    </style>
  </head>

  <body class="color">

    <div class="signup-bg">
        
      
          <div class="signup-title center">
            SIGN UP
          </div>
      <form action="signup.php" method="POST">  
          <div class="center">
              <input class="name" type="text" placeholder="Enter your name" name="name" required>
            </div>
          <div class="center">
              <input class="email" type="email" placeholder="Enter your email"  name="email" required>
            </div>
          <div class="center">
              <input class="create-password" type="password" placeholder="Create password"  name="password" required>
            </div>
          <div class="center"> 
              <input class="confirm-password" type="password" placeholder="Confirm password" name="passwor" required>
            </div>
          <div class="center">
              <button class="signup-button"> 
                Register Now
              </button>   
          </div>
          </form>
          <div class="center"></form>
            <p>Already have an account?</p>
            <a href="login.php">Login</a>
          </div>
    </div>
    
  </body>
</html>