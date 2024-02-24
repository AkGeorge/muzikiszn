<?php
session_start(); // Start session

if(isset($_POST['add_to_cart']) && isset($_POST['beat_id'])) {
    $beat_id = $_POST['beat_id'];
    // You can add the beat to the cart session or database here
    // For simplicity, I'm just redirecting back to the previous page
    header('Location: index.php');
    exit;
}



if(isset($_POST['remove_from_cart']) && isset($_POST['beat_id'])) {
    $beat_id = $_POST['beat_id'];
    // You can remove the beat from the cart session or database here
    // For simplicity, I'm just redirecting back to the previous page
    header('Location: index.php');
    exit;
}
?>