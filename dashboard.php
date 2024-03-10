<?php

use MongoDB\BSON\ObjectId;


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

// Function to update play count for a track
function updatePlayCount($beatId)
{
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

    // Find the track by its ID and increment the play count
    $collection->updateOne(
        ['_id' => new ($beatId)],
        ['$inc' => ['plays' => 1]]
    );
}
// Function to get total play count from all tracks
function getTotalPlayCount()
{
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

    // Aggregate to calculate total play count
    $totalPlayCount = $collection->aggregate(
        [
            [
                '$group' => [
                    '_id' => null,
                    'totalPlays' => ['$sum' => '$plays']
                ]
            ]
        ]
    )->toArray();

    // If there are results, return the total play count, otherwise return 0
    return isset($totalPlayCount[0]['totalPlays']) ? $totalPlayCount[0]['totalPlays'] : 0;
}

// Check if a track has been played
if (isset($_POST['beat_id'])) {
    $beatId = $_POST['beat_id'];
    updatePlayCount($beatId);
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

            <a  href="cart.php"> <i title="Cart"  class="fa-solid fa-cart-shopping cart-color" >
                    <span id="cartCounter">

                    </span>
                </i>
            </a>
          </span>
          
        </div>
      </div>
    </nav>

      <div>
          <input class="dashboard-search-bar" type="text" id="searchInput" placeholder="Search here" onkeyup="searchTracks()">
      </div>

      <div class="dashboard-text">
          <h1>WELCOME BACK</h1>
      </div>
    

          <div class="dashboard-features">
              <div class="plays">
                <h3>PLAYS: <?php echo getTotalPlayCount(); ?> </h3>
                </div>
              <div class="revenue">
                <h3>  REVENUE: </h3>
                </div>
              <div class="items-sold">
                <h3> ITEMS SOLD: </h3>
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
// Display beats
foreach ($beats as $beat){
  echo "<div class='track-holder'>";
  echo "<div class='track' >";
  echo "<h2>{$beat['uploadedaudio']}</h2>";
  echo "<p>Key: {$beat['keyInfo']}</p>";
  echo "<p>BPM: {$beat['bpm']}</p>";
  echo "<p>Price: " . floatval($beat['price']) . "</p>";
  echo "<p>Tags: {$beat['tags']}</p>";
  echo "<p>Genre: {$beat['genre']}</p>";
  echo "<p>Date: {$beat['date']}</p>";
  echo '<audio controls class="audio-controls">';
  echo '<source src="data:audio/mpeg;base64,' . base64_encode($beat['data']->getData()) . '" type="audio/mpeg">';
  echo 'Your browser does not support the audio element.';
  echo '</audio>';

  echo '<button title="Add to cart" onclick="addItem(\'' . $beat['_id'] . '\', \'' . $beat['uploadedaudio'] . '\', \'' . $beat['price'] . '\')">Add to Cart</button>';
  echo '<div id="cartCounter"></div>';
  $colname = 'user'; // Collection name where user data is stored

// Fetch the name of the uploader from the 'user' collection based on 'user_id'
$userCollection = $database->$colname; // Get the collection object
$user = $userCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($beat['user_id'])]); // Fetch the user document

// Check if the user document is found
if ($user) {
    echo "By: " . $user['name']; // Display the uploader's name
} else {
    echo "Unknown"; // Handle the case where uploader is not found
}
  
  
  echo '</div>';
  echo '</div>';
}



          
            

                  // Check if search query is provided
          if (isset($_GET['search'])) {
            $searchText = $_GET['search'];

            // MongoDB query to search tracks by track name or genre
            $filter = [
                '$or' => [
                    ['uploadedaudio' => ['$regex' => $searchText, '$options' => 'i']], // Search by track name
                    ['genre' => ['$regex' => $searchText, '$options' => 'i']] // Search by genre
                ]
            ]; // 'i' option for case-insensitive search
            $beats = $collection->find($filter);
          } else {
            // If no search query provided, fetch all tracks
            $beats = $collection->find();
          }

          // Loop through and display tracks
          foreach ($beats as $beat) {
            // Display track details as before
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
    const cartItems = [];
    function addItem(id, uploadedaudio, price) {
        // Increment cart counter
        cartCounter++;
        // Update the cart counter display
        updateCartCounter();
        

        // new code
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "add_to_cart.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Handle response if needed
              console.log(xhr.responseText);
            }
          };
          xhr.send("id=" + id + "&uploadedaudio=" + uploadedaudio + "&price=" + price);
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

    // function goToCart() {
    //     // Construct the URL with cart items as parameters
    //     var url = 'cart.php';
    //     if (cartItems.length > 0) {
    //         url += '?';
    //         // Loop through cartItems array to add each item as a parameter
    //         for (var i = 0; i < cartItems.length; i++) {
    //             url += 'id' + i + '=' + cartItems[i].id + '&';
    //             url += 'uploadedaudio' + i + '=' + cartItems[i].uploadedaudio + '&';
    //             url += 'price' + i + '=' + cartItems[i].price + '&';
    //         }
    //         // Remove the last '&' character
    //         url = url.slice(0, -1);
    //     }
    //     // Redirect to cart.php with cart items as parameters
    //     console.log(url);
    //     // window.location.href = url;
    // }
    // Function to increment play count
    function incrementPlayCount(beatId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true); // The current URL, which is this file itself
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("beat_id=" + beatId);
    }

    
</script>
<script>
  function searchTracks() {
    // Get the value entered in the search input
    var searchText = document.getElementById('searchInput').value.toLowerCase();

    // Get all track elements
    var trackElements = document.getElementsByClassName('track-holder');

    // Loop through each track element
    for (var i = 0; i < trackElements.length; i++) {
        // Get the track name within the current track element
        var trackName = trackElements[i].querySelector('h2').innerText.toLowerCase();

        // Check if the track name contains the search text
        if (trackName.includes(searchText)) {
            // If it matches, display the track
            trackElements[i].style.display = 'block';
        } else {
            // If it doesn't match, hide the track
            trackElements[i].style.display = 'none';
        }
    }
}
</script>



</html>