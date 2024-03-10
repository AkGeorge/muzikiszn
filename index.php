<!DOCTYPE html>
<html>
<head>
  <title>MUZIKI SZN</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Assistant:wght@400;600;700&family=Caveat:wght@400;600;700&display=swap" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;600;700&display=swap" rel="stylesheet">
  

  <link rel="stylesheet" href="styles/index.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="body-bg">
  <nav class="nav-bar">
    <div class="muziki-szn">
      <h1>
        <a class="logo" href="/"> MUZIKI SZN </a><br>
        <!-- <i
         id="ham" class="fa fa-bars"></i> -->
      </h1>
      <div ><form action="">
        <span><i class="fa-solid fa-magnifying-glass"></i></span>
        <input class="search-bar" type="text"  placeholder="search" onkeyup="searchTracks()" >
      </div>
    </form>
      <div class="btn-link">
        <span>
          <a  id="home" class="nav-btns" href="index.html"> Home</a>
        </span>
        <span>
          <a class="nav-btns" href="contact.html"> Contact us</a>
        </span>
        <span>
          <a class="nav-btns" href="signup.php"> Sign Up</a>
        </span>
        <span>|</span>
        <span>
          <a class="nav-btns" href="login.php"> Sign In</a>
        </span>
        <a href="cart.php">
            <span >
                <i title="Cart" class="fa-solid fa-cart-shopping cart-color" >
                
                  <span id="cartCounter">

                  </span>
                </i>
            </span>
          </a>
      </div>
               
    </div>
  </nav>


  <div>
    <form action="">
      <h1 class="txt-1">MAKE YOUR MUSIC DREAM COME TRUE</h1>
      <input class="search-bar-2" type="text" id="searchInput" placeholder="what are you looking for?" onkeyup="searchTracks()">
    </form>


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
// foreach ($beats as $beat) {
//     echo "<h2>{$beat['uploadedaudio']}</h2>";
//     echo "<p>Key: {$beat['keyInfo']}</p>";
//     echo "<p>BPM: {$beat['bpm']}</p>";
//     echo "<p>Price: {$beat['price']}</p>";
//     echo "<p>Tags: {$beat['tags']}</p>";
//     echo '<audio controls>';
//     echo '<source src="data:audio/mpeg;base64,' . base64_encode($beat['data']->getData()) . '" type="audio/mpeg">';
//     echo 'Your browser does not support the audio element.';
//     echo '</audio>';
// }

// Display beats
foreach ($beats as $beat){
  echo "<div class='track-holder'>";
  echo "<div class='track' >";
  echo "<h2>{$beat['uploadedaudio']}</h2>";
  echo "<p>Key: {$beat['keyInfo']}</p>";
  echo "<p>BPM: {$beat['bpm']}</p>";
  echo "<p>Price: {$beat['price']}</p>";
  echo "<p>Tags: {$beat['tags']}</p>";
  echo "<p>Genre: {$beat['genre']}</p>";
  echo "<p>Date: {$beat['date']}</p>";
  echo '<audio controls class="audio-controls">';
  echo '<source src="data:audio/mpeg;base64,' . base64_encode($beat['data']->getData()) . '" type="audio/mpeg">';
  echo 'Your browser does not support the audio element.';
  echo '</audio>';
  
  echo '<button title="Add to cart" onclick="addItem(\'' . $beat['_id'] . '\', \'' . $beat['uploadedaudio'] . '\', \'' . $beat['price'] . '\')">Add to Cart</button>';
  // echo '<button id="removeItemBtn" title="Remove from cart"onclick="removeItem(' . $beat['price'] . ')">Remove from cart </button> <br>';
      // echo '<a class="download-link" href="data:audio/mpeg;base64,' . base64_encode($beat['data']->getData()) . '" download="' . $beat['uploadedaudio'] . '">Download</a>';
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



    <div class="pic-1">
      <img src="assets/pexels-photo-8412420.jpeg">
    </div>
    <div>
      <h1 class="txt-2" >
      COMMENCE YOUR MUSIC JOURNEY <br> START SELLING YOUR BEATS TODAY!
      </h1>
    </div>
    <div class="txt-3">
      <h1>
          Looking for the platform to sell your beats? We got you!
      </h1>
        <p>
          <strong> &#x2713; The right marketplace for quality beats</strong> <br> Be able to browse through and get high quality beats
        </p>
        <p>
          <strong> &#x2713;Affordable beat pricing</strong> <br> Get quality beats at an affordable price
        </p>
        <p>
          <strong> &#x2713;Flawless Purchasing Experience</strong> <br> Utilize the user-friendly interface to purchase beats without any problem
        </p>
        <div>
          <a href="login.php">                                      
          <button class="get-started-btn"> Get started</button>
        </div> </a>
    </div>



    




    <div >
      <img class="pic-2" src="assets/pexels-photo-995301.jpeg">
    </div>
     <div class="txt-5">
      <h1>
        "Music is the divine way to tell beautiful, poetic things to the heart." - Pablo Casals
    </h1>
     </div>
     <div >
      <img class="pic-3" src="assets/pexels-photo-3916376.jpeg">
    </div>
    <div class="txt-6">
      <h1>
        MUZIKI SZN Lets you get access to some of the world's popular genres of music and musical instrumentals.
        These genres range from;<br>&#8226; Pop<br>&#8226; R&B<br>&#8226; Hip-hop<br>&#8226; Amapiano<br>&#8226; Trap<br>&#8226; Afrobeats etc
    </h1>
     </div>
     
    <div> 
      <img class="pic-4" src="assets/pexels-photo-1105666.jpeg" >

      <img class="pic-5" src="assets/pexels-photo-690779.jpeg" >
     
      <img class="pic-6" src="assets/pexels-clam-lo-3355358.jpg" >
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
    <script>
    let cartCounter = 0;
    
    function addItem(id, uploadedaudio, price) {
        // Increment cart counter
        cartCounter++;
        // Update the cart counter display
        updateCartCounter();
        // Redirect to cart.php with beat details as URL parameters
        // window.location.href = 'cart.php?id=' + id + '&uploadedaudio=' + uploadedaudio + '&price=' + price;
        

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
</body>



</html>