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
        <i
         id="ham" class="fa fa-bars"></i>
      </h1>
      <div ><form action="">
        <span><i class="fa-solid fa-magnifying-glass"></i></span>
        <input class="search-bar" type="text" placeholder="what are you looking for?">
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
      <input class="search-bar-2" type="text" placeholder="search here">
    </form>
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
  echo '<audio controls class="audio-controls">';
  echo '<source src="data:audio/mpeg;base64,' . base64_encode($beat['data']->getData()) . '" type="audio/mpeg">';
  echo 'Your browser does not support the audio element.';
  echo '</audio>';
  
  echo '<button id="addItemBtn" title="Add to cart" onclick="addItem(' . $beat['price'] . ')">Add to Cart</button>';
  // echo '<button id="removeItemBtn" title="Remove from cart"onclick="removeItem(' . $beat['price'] . ')">Remove from cart </button> <br>';
      // echo '<a class="download-link" href="data:audio/mpeg;base64,' . base64_encode($beat['data']->getData()) . '" download="' . $beat['uploadedaudio'] . '">Download</a>';
  echo '<div id="cartCounter"></div>';
  echo '</div>';
  echo '</div>';
}

?> 
        
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
</body>
<script>
    let cartCounter = 0;
    
    function addItem() {
        cartCounter = cartCounter + 1;
        console.log('Item added to cart');
        updateCartCounter();
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