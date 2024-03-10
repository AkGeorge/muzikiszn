<?php
session_start();

if(isset($_POST['id']) && isset($_POST['uploadedaudio']) && isset($_POST['price'])) {
  $id = $_POST['id'];
  $uploadedaudio = $_POST['uploadedaudio'];
  $price = $_POST['price'];

  // Add item to cart session variable
  if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
  }
  $_SESSION['cart'][] = array('id' => $id, 'uploadedaudio' => $uploadedaudio, 'price' => $price);
  
  echo "Item added to cart successfully.";
} else {
  echo "Error: Missing parameters.";
}
?>
