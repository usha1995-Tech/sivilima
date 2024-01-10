<?php



?>
<!--user panel navbar-->
<header class="header">
<div class="header-1">
   <div class="flex">
   <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
<p>New <a href="login.php">Login</a>||<a href="register.php">Register</a></p>
</div>
</div>
<div class="header-2">
    <div class="flex">
   
    <a href="home.php" class="logo">Sivilima</a>
      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About</a>
         <a href="shop.php">Shop</a>
         <a href="oders.php">Orders</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <a href="search_page.php" class="fas fa-search"></a>
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
         ?>
         
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $count_wishlist_items->rowCount(); ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $count_cart_items->rowCount(); ?>)</span></a>
      </div>

      <div class="profile">
      <?php
        $select_profile = $conn->prepare("SELECT * FROM `users`WHERE id=?");
        $select_profile->execute([$user_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        
        ?>
        <p><?= $fetch_profile['name']; ?></p>
        <p><?= $fetch_profile['email']; ?></p>
        
        
        <a href="logout.php" class="delete-btn">logout</a>
    

</div>
      </div>
    </div>
</header>