<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   // header('location:login.php');
}

if(isset($_POST['submit'])){

   $id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
   $c_pass = sha1($_POST['c_pass']);
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING); 

   $verify_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? LIMIT 1");
   $verify_admin->execute([$name]);

   if($verify_admin->rowCount() > 0){
      $warning_msg[] = 'Name already taken!';
   }else{
      if($pass != $c_pass){
         $warning_msg[] = 'Password not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admins`(id, name, password) VALUES(?,?,?)");
         $insert_admin->execute([$id, $name, $c_pass]);
         $success_msg[] = 'Admin registered successfully!';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

<!-- register section starts -->

<section class="form-container">

   <form action="" method="POST">
      <h3>create a new admin account</h3>
      <input type="text" name="name" required placeholder="enter username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')"> 
      <input type="password" name="pass" placeholder="enter password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="c_pass" placeholder="confirm password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Prevents the user from entering any spaces in the input. -->
      <input type="submit" value="register now" name="submit" class="btn">
   </form>

</section>


<!-- register section ends -->






















<!-- sweet alert cdn link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>