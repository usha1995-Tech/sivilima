<?php

include 'config.php';


session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};


if(isset($_POST['submit'])){/*submit kiyala danne form eke name ekata dana name eka */
    $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $submit = $conn->prepare("UPDATE `users` SET  email = ? WHERE id = ?");
   $submit->execute([$email, $user_id]);

$new_pass = md5($_POST['new_pass']);
$new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
$confirm_pass = md5($_POST['confirm_pass']);
$confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

if(!empty($new_pass) AND !empty($confirm_pass)){
    if($new_pass != $confirm_pass){
        echo "<script>alert('confirm password not matched!')</script>"; 

    }else{
       $update_pass_query = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
       $update_pass_query->execute([$confirm_pass, $user_id]);
       echo "<script>alert('password updated successfully!')</script>"; 
    }
 }
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update</title>

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/main.css">

</head>
<body>
<?php include 'header.php' ;?>

    <!-- new password  form -->
    <section class="form-container">
        <form action="" enctype="multipart/form-data" method="POST">
            <h3>update password</h3>
            
            <input type="email" name="email" class="box" placeholder="enter your email" required>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         
            <input type="submit" name="submit" value="update" class="btn" >
            <a href="home.php" class="option-btn">back</a>
        </form>

    </section>

    <?php
include'footer.php';
   ?>
    
</body>
</html>