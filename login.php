<?php
//link database
include 'config.php';

session_start();


if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $sql = "SELECT * FROM `users` WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $pass]);
    $rowCount = $stmt->rowCount();  
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    if($rowCount > 0){
 
       if($row['user_type'] == 'admin'){
 
          $_SESSION['admin_id'] = $row['id'];
          header('location:admin_page.php');
 
       }elseif($row['user_type'] == 'user'){
 
          $_SESSION['user_id'] = $row['id'];
          header('location:home.php');
 
       }else{
         echo "<script>alert('incorrect email or password!')</script>";
       }
 
    }}
   
 


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/main.css">

</head>
<body>


    <!-- login form -->
    <section class="form-container">
        <form action="" enctype="multipart/form-data" method="POST">
            <h3>login now</h3>
            <input type="email" name="email" class="box" placeholder="enter your email" required>
            
            <input type="password" name="pass" class="box" placeholder="enter your password" required>
 
            <input type="submit" name="submit" value="login now" class="btn" >
            <!--<a href="home.php" class="option-btn">back</a>-->
            <p>don't have an account?<a href="register.php">register now</a></p>
            <p>forgot password?<a href="edit.php">create new</a></p>
            
        </form>

    </section>
 
    
</body>
</html>