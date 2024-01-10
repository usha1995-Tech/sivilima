<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
  
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
  
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address =  $_POST['street'] .' '. $_POST['city'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if($cart_query->rowCount() > 0){
      while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
         $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].' )';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $total_products = implode(', ', $cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND  email = ? AND number = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name,  $email, $number, $method, $address, $total_products, $cart_total]);

   if($cart_total == 0){
    echo "<script>alert('Your cart is empty!')</script>";
   }elseif($order_query->rowCount() > 0){
    echo "<script>alert('Order placed already!')</script>";
   }else{
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name,  email,number, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name,  $email, $number, $method, $address, $total_products, $cart_total, $placed_on]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      echo "<script>alert('order placed successfully!')</script>";
   }

}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>
     <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/front.css">

</head>
<body>
<?php include'header.php';?>


<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart_items->execute([$user_id]);
      if($select_cart_items->rowCount() > 0){
         while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span>(<?= 'Rs'.$fetch_cart_items['price'].'/- x '. $fetch_cart_items['quantity']; ?>)</span> </p>
   <?php
    }
   }else{
      echo '<p class="empty">your cart is empty!</p>';
   }
   ?>
   <div class="grand-total">Grand Total : <span>Rs<?= $cart_grand_total; ?>/-</span></div>
</section>

<section class="checkout-orders">

   <form action="" method="POST">
<!-- oder eka confirm karala oder karana form eka -->
      <h3>Place Your Order</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" required>
         </div>
      
         <div class="inputBox">
            <span>Your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" required>
         </div>
      

         <div class="inputBox">
            <span>Contact number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" required>
         </div>
       

         <div class="inputBox">
            <span>Payment method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">cash on delivery</option>
               <option value="pay bill in the shop">pay bill in the shop</option>  
            </select>
         </div>
   
         <div class="inputBox">
            <span>Address  :</span>
            <input type="text" name="street" placeholder=" address name" class="box" required>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" placeholder="city name " class="box" required>
         </div>
         

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>







<?php include 'footer.php';?>
<script src = "js/script.js"></script>
    
</body>
</html>