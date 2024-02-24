
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
    
    
  </style>

</head>
<body>
      <div  class="cart">
        
        <h1>Shopping Cart</h1>
        
        </div>
            
  
      
      <div id="container">
            <div id="root"></div>
            <div class="sidebar">
                <div class="head"><p>My Cart</p></div>
             
                <div id=container>
               
            <?php
              // Retrieve beat details from URL parameters
              $id = $_GET['id'];
              $uploadedaudio = $_GET['uploadedaudio'];
              $price = $_GET['price'];
            ?>
            </div>
                <!-- Display beat information -->
                <h2><?php echo $uploadedaudio; ?></h2>
                <p>Price: <?php echo $price; ?></p>
                <button onclick="addItem()">Calculate</button>
           
                <div class="foot">
                    <h3>Total</h3>
                    <h2 id="total">KES 0.00</h2>
                </div>
            </div>
        </div>
        </div>
      

</body> 

<script>
  
    var price = $price;
    var cart = [];
    function addItem(){
        cart.push(price);
        displayart();
    }
    
    function displayart(){
        let total=0;
        document.getElementById("total").innerHTML = cart.map((price)=>
        {
            total=total+price;
            document.getElementById("total").innerHTML = "$ "+total+".00";
            return(
                `<div class='cart-item'>
                <p>${uploadedaudio}</p>
                <h2>$ ${price}.00</h2>`+
                `</div>`);
            

    }).join('');
    } 
</script>

</html> 
