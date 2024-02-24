<?php

// Start or resume session
session_start();

// Check if the session variable indicating login status is set
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// If logged in, continue with the page content


// Logout functionality
if (isset($_POST['logout'])) {
  // Unset all session variables
  session_unset();

  // Destroy the session
  session_destroy();

  // Redirect to the login page
  header("Location: login.php");
  exit();
}
?>




<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard</title>

    <link rel="stylesheet" href="styles/dashboard.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  </head>
  <body class="dashboard-body-bg">
    <nav class="nav-bar">
      <div class="muziki-szn">
        <h1>
         <a class="dshb-logo" href="/"> MUZIKI SZN </a><br>
          
        </h1>
        
        <div class="btn-link">
          <p> Welcome Back : <?php echo $_SESSION['name']; ?></p>
          <form method="post">
              <button type="submit" name="logout">Logout</button>
          </form>
          <span>
    
            <img title="notifications" class="notification-icon" src="assets/notifications.svg"> 
            
            <a href="upload.php"><img title="upload-track" class="upload-icon" src="assets/upload.svg" ></a> 

            <a href="profile.php"> <i title="profile" class="fa-regular fa-user profile-icon"></i> </a>

            <a href="cart.php"> <i title="Cart"  class="fa-solid fa-cart-shopping cart-color" >
                    <span id="cartCounter">

                    </span>
                </i>
            </a>
          </span>
          
        </div>
      </div>
    </nav>

    <div>
        <input class="dashboard-search-bar" type="text" placeholder="search here">
      </div>
        <div class="dashboard-text">
          <h1>WELCOME BACK</h1>
        </div>
    

          <div class="dashboard-features">
            <div class="plays">
                PLAYS
            </div>
            <div class="revenue">
                  REVENUE
            </div>
            <div class="items-sold">
                  ITEMS SOLD
            </div>
            </div>
            <div  >
          <h1>Tracks</h1>
          <a href="tracks.php" class="track-text" >View Your Tracks</a>

        </div>
          <div  >
            <h1>Trending</h1>
      
          </div>

    <div id="tracks-container">
      <?php


          require 'vendor/autoload.php';

          // MongoDB connection parameters
          $host = 'localhost';
          $port = 27017;
          $dbName = 'muzikiszn';
          $collectionName = 'beats';

          // Connect to MongoDB
          $mongoClient = new MongoDB\Client("mongodb://$host:$port");
          $database = $mongoClient->$dbName;
          $collection = $database->$collectionName;

          // Fetch beats from MongoDB
          $beats = $collection->find();

        
          // Display beats
          foreach ($beats as $beat){
            echo "<div class='track-holder'>";
            echo "<div class='track' >";
            echo "<h2>{$beat['uploadedaudio']}</h2>";
            echo "<p>Key: {$beat['keyInfo']}</p>";
            echo "<p>BPM: {$beat['bpm']}</p>";
            echo "<p>Price: {$beat['price']}</p>";
            echo "<p>Tags: {$beat['tags']}</p>";
            echo '<audio controls class="audio-controls">';
            echo '<source src="data:audio/mpeg;base64,' . base64_encode($beat['data']->getData()) . '" type="audio/mpeg">';
            echo 'Your browser does not support the audio element.';
            echo '</audio>';
            
            echo '<button title="Add to cart" onclick="addItem(\'' . $beat['_id'] . '\', \'' . $beat['uploadedaudio'] . '\', \'' . $beat['price'] . '\')">Add to Cart</button>';
            // echo '<button id="removeItemBtn" title="Remove from cart"onclick="removeItem(' . $beat['price'] . ')">Remove from cart </button> <br>';
                // echo '<a class="download-link" href="data:audio/mpeg;base64,' . base64_encode($beat['data']->getData()) . '" download="' . $beat['uploadedaudio'] . '">Download</a>';
            echo '<div id="cartCounter"></div>';
            echo '</div>';
            echo '</div>';
          }

          ?> 
                  
    </div>

   
      <div >
        <img class="dashboard-pic" src="assets/pexels-wallace-chuck-3587476.jpg" >
        <img class="dashboard-pic" src="assets/pexels-photo-4988137.jpeg" >
        <img class="dashboard-pic" src="assets/pexels-pixabay-164745.jpg" >
      </div>
      
      <footer class="footer-section">
        <div>
          <h1>Send personalised emails</h1>
          <input class="email-input" type="text" placeholder="Enter your email">
        </div>
       <div>
        <h1>Social Media</h1>
        <a href="https://www.instagram.com/grgymadeit/" target="_blank">Instagram </a><br>
        <a href="https://twitter.com/grgymadeit" target="_blank">Twitter (X)</a><br>
        <a href="https://web.facebook.com/profile.php?id=100010621934749" target="_blank">Facebook</a>
  
        </div>
        <div>
          <h1>Say Hello</h1>
          0758591170 <br>
          george47were@gmail.com
        </div>
      </footer>
    
  </body>


  <script>
    let cartCounter = 0;
    
    function addItem(id, uploadedaudio, price) {
    // Increment cart counter
    cartCounter++;
    // Update the cart counter display
    updateCartCounter();
    // Redirect to cart.php with beat details as URL parameters
    window.location.href = 'cart.php?id=' + id + '&uploadedaudio=' + uploadedaudio + '&price=' + price;
    }

    function removeItem() {
        if (cartCounter > 0) {
            cartCounter = cartCounter - 1;
            console.log('Item removed from cart');
            updateCartCounter();
        }
    }

    function updateCartCounter() {
        document.getElementById('cartCounter').innerText = cartCounter;
    }
    
</script>



</html>