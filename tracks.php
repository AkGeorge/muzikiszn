<?php

session_start(); // Start session

require 'vendor/autoload.php';

use MongoDB\BSON\ObjectId;



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




// MongoDB connection parameters
$host = 'localhost';
$port = 27017;
$dbName = 'muzikiszn';
$collectionName = 'beats';

// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://$host:$port");
$database = $mongoClient->$dbName;
$collection = $database->$collectionName;

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch tracks uploaded by the logged-in user
$tracks = $collection->find(['user_id' => $_SESSION['user_id']]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tracks</title>

    <style>
            body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(to right, #2d8bd7, #f9f9f9);
        }

        h1 {
            text-align: center;
            font-family: 'Courier New', Courier, monospace;
        }

        #tracks-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 20px;
        }

        .track {
            border: 1px solid black;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            background: linear-gradient(to left,rgb(135, 135, 188),rgb(96, 122, 216));
            margin-top: 10px;
            height: 400px;
        }

        .track:hover {
            background: linear-gradient(to left,rgb(74, 58, 76),rgb(216, 135, 196));
            color: white;
        }

        #audio-player {
            width: 100%;
            margin-top: 20px;
        }

        .audio-controls {
            width: 100%;
        }

        .download-link {
            text-decoration: none;
            color: black;
        }
        .dashboard-search-bar{
            width:600px;
            height:50px ;
            margin-left: 30%;
            margin-top: 150px;
            align-content: center;  
            }
    </style>
</head>

<body>

<h1>My Tracks</h1>
    <div>
          <input class="dashboard-search-bar" type="text" id="searchInput" placeholder="Search here" onkeyup="searchTracks()">
    </div>

<div id="tracks-container">

<?php
// Display tracks uploaded by the logged-in user
foreach ($tracks as $track) {
    echo "<div class='track-holder'>";
    echo "<div class='track' >";
    echo "<h2>{$track['uploadedaudio']}</h2>";
    echo "<p>Key: {$track['keyInfo']}</p>";
    echo "<p>BPM: {$track['bpm']}</p>";
    echo "<p>Price: {$track['price']}</p>";
    echo "<p>Tags: {$track['tags']}</p>";
    echo "<p>Genre: {$track['genre']}</p>";
    echo "<p>Date: {$track['date']}</p>";
    
    echo '<audio controls class="audio-controls">';
    echo '<source src="data:audio/mpeg;base64,' . base64_encode($track['data']->getData()) . '" type="audio/mpeg">';
    echo 'Your browser does not support the audio element.';
    echo '</audio>';
    echo '<button id="addItemBtn" title="Add to cart" onclick="addItem(' . $track['price'] . ')">Add to Cart</button>';
    // echo '<button id="removeItemBtn" title="Remove from cart"onclick="removeItem(' . $track['price'] . ')">Remove from cart </button> <br>';
    // echo '<a class="download-link" href="data:audio/mpeg;base64,' . base64_encode($track['data']->getData()) . '" download="' . $track['uploadedaudio'] . '">Download</a>';
    echo "<p>By : " . $_SESSION['name'] . "</p>";
    echo '<div id="cartCounter"></div>';
    echo '</div>';
    echo '</div>';
}

// Check if search query is provided
if (isset($_GET['search'])) {
    $searchText = $_GET['search'];

    // MongoDB query to search tracks by track name
    $filter = ['uploadedaudio' => ['$regex' => $searchText, '$options' => 'i']]; // 'i' option for case-insensitive search
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

<script>
    
    function addItem(price) {
        alert('Added to cart');
    }

    function removeItem(price) {
        alert('Removed from cart');
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
