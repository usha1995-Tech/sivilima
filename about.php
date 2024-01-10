<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};




?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About us</title>

     <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/front.css">




</head>
<body>

<?php include'header.php';?>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="image/11.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p><b><em>Sivilima</em></b> is a place which you can buy almost ceiling items one place with various colors,sizes, low price and 100% high quality products and we provide free delivery facilities. And also you can choose to pay your bill using cash on delivery or collect money in shop method.</p>
    
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>











<?php include 'footer.php';?>
<script src = "js/script.js"></script>
    
</body>
</html>