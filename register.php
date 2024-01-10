<?php
//link database
include 'config.php';

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_STRING);

    $pass = md5($_POST['pass']);
    $pass = filter_var($pass,FILTER_SANITIZE_STRING);

    $cpass = md5($_POST['cpass']);
    $cpass = filter_var($cpass,FILTER_SANITIZE_STRING);

    $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select->execute([$email]);

    if($select->rowCount() >0){
        echo "<script>alert('User email already exist!')</script>";
    }else{
        if($pass != $cpass){
    echo "<script>alert('Password not matched!')</script>";
        }else{
            $insert = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
            $insert->execute([$name, $email, $pass]);
            
             echo "<script>alert('Registered successfully!')</script>";
            //header('location:login.php');
           
            
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
    <title>register</title>

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/main.css">

</head>
<body>


    <!-- register form -->
    <section class="form-container">
        <form action="" enctype="multipart/form-data" method="POST">
            <h3>register now</h3>
            <input type="text" name="name" class="box" placeholder="enter your name" required>
            <input type="email" name="email" class="box" placeholder="enter your email" required>
            <input type="password" name="pass" class="box" placeholder="enter your password" required>
            <input type="password" name="cpass" class="box" placeholder="confirm your password" required>
            <input type="submit" name="submit" value="register now" class="btn" >
            <p>already have an account?<a href="login.php">login now</a></p>
        </form>

    </section>

    
</body>
</html>