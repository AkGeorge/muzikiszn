<?php
session_start();
?>
<!DOCTYPE html> 
<html lang="en">
<head>

  <title>Shopping Cart</title>
  <style>
    .cart{
      text-align: center;
      margin-top: 100px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      
    }
    body{
      background-color: rgb(217, 220, 229)}

    #container{
        display: flex;
        width: 70%;
        margin-bottom: 30px;
        
    }
    #root{
        width: 60%;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 20px;
    }
    .sidebar{
        width: 40%;
        border-radius: 5px;
        background-color: #eee;
        margin-left: 1px;
        padding: 15px;
        text-align: center;
        
    }
    .head{
        background-color: goldenrod;
        border-radius: 3px;
        height: 40px;
        padding: 10px;
        margin-top: 20px;
        color: white;
        display: flex;
        align-items: center;
    }
    .foot{
        display: flex;
        justify-content: space-between;
        
        padding: 10px 0px;
        border-top: 1px solid #333;
        margin-top: 10px;
    }
    .cart-btns{
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: none;
        border-radius: 5px;
        background-color: goldenrod;
        color: white;
        cursor: pointer;
    }
    
    
  </style>

</head>
<body>
  <div class="cart">
    <h1>Shopping Cart</h1>
  </div>

  <div id="container">
    <div id="root"></div>
    <div class="sidebar">
      <div class="head">
        <p>My Cart</p>
      </div>
      <div id="cart-items">
        <?php
        if(isset($_SESSION['cart'])) {
          foreach($_SESSION['cart'] as $index => $item) {
            echo "<div class='cart-item'>";
            echo "<p>" . $item['uploadedaudio'] . " - KES " . $item['price'] . ".00</p>";
            // Add a form with a hidden input to pass the index of the item to remove
            echo "<form method='post'>";
            echo "<input type='hidden' name='remove_item_index' value='$index'>";
            echo "<button type='submit' name='remove_item'><span class='bin-icon'>&#128465;</span></button>";
            echo "</form>";
            echo "</div>";
          }
        } else {
          echo "<p>Your cart is empty.</p>";
        }
        ?>
      </div>
      <div class="foot">
        <h3>Total</h3>
        <h2 id="total">
          <?php
          if(isset($_SESSION['cart'])) {
            $total = 0;
            foreach($_SESSION['cart'] as $item) {
              $total += floatval($item['price']); // Convert price to a numeric value
            }
            echo "KES " . $total . ".00";
          } else {
            echo "KES 0.00";
          }
          
          ?>
        </h2>
      </div>
        <div class="empty-cart">
          <form method="post">
            <button class="cart-btns" type="submit" name="empty_cart" class="empty">
              Empty Cart
            </button>
          </form>
          <!-- Checkout button -->
          <form method="post" action="checkout.php">
            <button class="cart-btns" type="submit" name="checkout" class="checkout"  >
              Checkout
            </button>
          </form>
        </div>
    </div>
  </div>
  
  <?php
  if(isset($_POST['remove_item']) && isset($_POST['remove_item_index']) && isset($_SESSION['cart'])) {
      // Remove the item from the cart array using the index passed via the hidden input
      $index = $_POST['remove_item_index'];
      unset($_SESSION['cart'][$index]);
      // Reorder the array keys after removing an item
      $_SESSION['cart'] = array_values($_SESSION['cart']);
      header("Location: cart.php"); // Redirect to the cart page after removing the item
      exit;
  }

  if(isset($_POST['empty_cart']) && isset($_SESSION['cart'])) {
      // Remove all items from the cart array
      $_SESSION['cart'] = array();
      header("Location: cart.php"); // Redirect to the cart page after removing items
      exit;
  }
  ?>
</body> 
</html>