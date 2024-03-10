
<?php
use MongoDB\BSON\Binary;

require 'vendor/autoload.php';
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

// MongoDB connection parameters
$host = 'localhost';
$port = 27017;
$dbName = 'muzikiszn';
$collectionName = 'beats';

// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://$host:$port");
$database = $mongoClient->$dbName;
$collection = $database->$collectionName;
$mongoDB = $mongoClient->$dbName;
$userCollection = $database->user;
$beatsCollection = $database->beats;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have retrieved the user's _id from the session or any other source
    $userId = $_SESSION['user_id']; // Replace 'user_id' with the actual session variable storing the user's _id
    
    // Retrieve form data
    $uploadedAudio = $_POST['uploadedAudio'];
    $keyInfo = $_POST['keyInfo'];
    $bpm = $_POST['bpm'];
    $price = $_POST['price'];
    $tags = $_POST['tags'];
    $genre = $_POST['genre'];
    $date = $_POST['date'];

    // Check if file is uploaded
    if(isset($_FILES['fileToUpload'])) {
        $file = $_FILES['fileToUpload'];

        // Get the temporary location of the file
        $tmpFilePath = $file['tmp_name'];

        // Make sure file was uploaded without errors
        if($tmpFilePath != "" && $file['error'] == 0) {
            // Read the file contents
            $mp3Data = file_get_contents($tmpFilePath);

            // Prepare document to insert into MongoDB
            $document = [
                'user_id' => $userId,
                'data' => new Binary($mp3Data, Binary::TYPE_GENERIC),
                'uploadedaudio' => $uploadedAudio,
                'keyInfo' => $keyInfo,
                'bpm' => $bpm,
                'price' => $price,
                'tags' => $tags,
                'genre' => $genre,
                'date' => $date
            ];

            // Insert the document into MongoDB
            $result = $collection->insertOne($document);

            if ($result->getInsertedCount() > 0) {
                echo "MP3 file uploaded successfully.";
            } else {
                echo "Failed to upload MP3 file.";
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No file uploaded.";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>

<title>Upload Audio</title>
    <style>
        .upload-bg{
            background: linear-gradient(to right,rgb(119, 119, 205),rgb(98, 112, 162));
        }
        .upload-container{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
            border: 1px solid #e1d3d3;
            border-width: 3px;
            border-radius: 12px;
        }
        .upload-txt{
            color: #fff;
            font-size: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            
            

        }
    </style>

</head>
<body class="upload-bg">
<div class="upload-container">
<form action="upload.php" method="post" enctype="multipart/form-data">
    <h1 class="upload-txt">Select MP3 file to upload:</h1>
    Select File: <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="submit">
    
    </div>
<div>
    <h2 class="upload-txt">Uploaded MP3 file:</h2>
    <input type="text" name="uploadedAudio" id="uploadedAudio" placeholder="Beat name" required>
</div>
<div>
    <h2 class="upload-txt">Key:</h2>
    <input type="text" name="keyInfo" id="keyInfo" placeholder="Key" required>
</div>
<div>
    <h2 class="upload-txt">BPM:</h2>
    <input type="number" name="bpm" id="bpm" placeholder="BPM" required>
</div>
<div>
    <h2 class="upload-txt">Price:</h2>
    <input type="text" name="price" id="price" placeholder="Enter amount" required>
</div>
<div>
    <h2 class="upload-txt">Tags:</h2>
    <input type="text" name="tags" id="tags" placeholder="Input tags" required>
</div>
<div>
    <h2 class="upload-txt">Genre:</h2>
    <input type="text" name="genre" id="genre" placeholder="Input genre"  required>
</div>
<div>
    <h2 class="upload-txt">Date:</h2>
    <input type="text" name="date" id="date" placeholder="Date" readonly>
</div>

</form>


<script>


// Function to handle file change event
document.getElementById("audio").addEventListener("change", function(event) {
    var file = event.target.files[0];
    var audioPlayer = document.getElementById("audioPlayer");
    var source = document.getElementById("audioSource");

    // Set the source of the audio player to the selected file
    source.src = URL.createObjectURL(file);
    audioPlayer.load();
});

// Function to format input as currency
function formatCurrency(input) {
    // Remove non-numeric characters
    let value = input.value.replace(/[^0-9.]/g, '');

    // Format value as currency
    value = parseFloat(value).toFixed(2);

    // Display formatted value in input field
    input.value = 'KES' + value;
}

// Add event listener to format input as currency when typing
document.getElementById('money').addEventListener('input', function() {
    formatCurrency(this);
});
</script>
<script>
    // Function to set current date
    function setCurrentDate() {
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();

        // Format the date as YYYY-MM-DD
        var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day);

        // Set the value of the date input field
        document.getElementById('date').value = formattedDate;
    }

    // Call the function to set current date when the page loads
    window.onload = function() {
        setCurrentDate();
    };
</script>
</body>
</html> 

