<!DOCTYPE html>
<html>
<head>
  <title>Checkout Page</title>
  <style>
    
    .checkout-form {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: whitesmoke;
    }

    .checkout-form input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    .checkout-form button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .checkout-form button:hover {
      background-color: #0056b3;
      opacity: 0.8;
    }

    .checkout-form p {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <?php include 'cart.php'; ?>
  <form class="checkout-form" id="paymentForm" action="" method="POST">
    <input type="text" id="name" name="name" placeholder="Name">
    <input type="text" id="email" name="email" placeholder="Email">
    <input type="text" id="phonenumber" name="phone" placeholder="Phone Number">
    <input type="hidden" name="amount" value="<?php echo $total; ?>">
    <p>Total: <?php echo $total; ?></p>
    <button type="submit" onclick="payWithPaystack()">Pay</button>
  </form>
  <script src="https://js.paystack.co/v1/inline.js"></script>

  <?php

require 'vendor/autoload.php';

include 'configs.php';

// Function to generate a unique invoice ID
function generateInvoiceId() {
    return date('YmdHis') . rand(1000, 9999); // Combining timestamp with a random number
}

// Initialize variables to avoid undefined index warnings
$name = $email = $phone = $amount = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are set
    if(isset($_POST['name'])) {
        $name = $_POST['name'];
    }
    if(isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    if(isset($_POST['phone'])) {
        $phone = $_POST['phone'];
    }
    if(isset($_POST['amount'])) {
        $amount = $_POST['amount'];
    }
}

$currency = "KES";

// Generate invoice ID
$invoiceId = generateInvoiceId();

// MongoDB connection
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->muzikiszn; // Your database name
$collection = $database->order; // Your collection name

// Insert transaction details into MongoDB
$insertResult = $collection->insertOne([
    'invoice_id' => $invoiceId,
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'amount' => $amount,
    'currency' => $currency,
    'timestamp' => new MongoDB\BSON\UTCDateTime()
]);

if ($insertResult->getInsertedCount() == 1) {
    echo "Transaction details inserted into MongoDB successfully.";
} else {
    echo "Failed to insert transaction details into MongoDB.";
}
?>





<script type="text/javascript">
    const paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener("submit", payWithPaystack, false);

    function payWithPaystack(e) {
      e.preventDefault();
      let handler = PaystackPop.setup({
        key: '<?php echo $PublicKey; ?>', // Replace with your public key
        email: '<?php echo $email; ?>',
        amount: <?php echo $amount; ?> * 100,
        currency: '<?php echo $currency; ?>', // Use GHS for Ghana Cedis or USD for US Dollars or KES for Kenya Shillings
        ref: '<?php echo $invoiceId; ?>', // Use the invoice ID as the reference
        // label: "Optional string that replaces customer email"
        onClose: function() {
          alert('Transaction was not completed, window closed.');
        },
        callback: function(response) {
          let message = 'Payment complete! Reference: ' + response.reference;
          alert(message);
          window.location.href = "http://localhost/PayStack-With-PHP/verify_transaction.php?reference=" + response.reference;
        }
      });

      handler.openIframe();
    }
</script>
</body>
</html>
