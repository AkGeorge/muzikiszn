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
            height: 350px;
            
            }

        .track:hover {
            background: linear-gradient(to left,rgb(74, 58, 76),rgb(216, 135, 196));
            color: white;
        }

        #audio-player {
            width: 100%;
            margin-top: 20px;
        }

        .audio-controls{
            width: 100%;
        }
        .download-link{
            text-decoration: none;
            color: black;
        }

    </style>
</head>

<body>

<h1>Tracks</h1>


<div id="tracks-container">


<?php

session_start(); // Start session

require 'vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// MongoDB connection parameters
$host = 'localhost';
$port = 27017;
$dbName = 'muzikiszn';
$collectionName = 'beats';

// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://$host:$port");
$database = $mongoClient->$dbName;
$collection = $database->$collectionName;


// Check if add to cart button is clicked
if(isset($_POST['add_to_cart']) && isset($_POST['beat_id'])) {
    $beat_id = $_POST['beat_id'];
    $beat = $collection->findOne(['_id' => new ($beat_id)]);

    // Store beat information in the session
    $_SESSION['cart'][] = $beat;
    echo 'Added to cart';
    exit; // Stop further execution
}

// Check if remove from cart button is clicked
if(isset($_POST['remove_from_cart']) && isset($_POST['beat_id'])) {
    $beat_id = $_POST['beat_id'];

    // Remove beat from the cart session
    foreach ($_SESSION['cart'] as $key => $beat) {
        if ($beat['_id'] == $beat_id) {
            unset($_SESSION['cart'][$key]);
            echo 'Removed from cart';
            exit; // Stop further execution
        }
    }
}




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
    
    
    echo '<button id="addItemBtn" title="Add to cart" onclick="addItem(' . $beat['price'] . ')">Add to Cart</button>';
    // echo '<button id="removeItemBtn" title="Remove from cart"onclick="removeItem(' . $beat['price'] . ')">Remove from cart </button> <br>';
    // echo '<a class="download-link" href="data:audio/mpeg;base64,' . base64_encode($beat['data']->getData()) . '" download="' . $beat['uploadedaudio'] . '">Download</a>';
    echo '<div id="cartCounter"></div>';

    // echo "<p> By :{$_SESSION['name']}</p>";
    // echo '<a class="download-link" href="data:audio/mpeg;base64,' . base64_encode($beat['data']->getData()) . '" download="' . $beat['uploadedaudio'] . '">Download</a>';
    echo '</div>';
    echo '</div>';
}
?> 
        
</div>

        
</div>

<script>
    
    function addItem(price) {
        alert('Added to cart');
    }

    function removeItem(price) {
        alert('Removed from cart');
    }
</script>   
    
</script>   
</body>
</html>