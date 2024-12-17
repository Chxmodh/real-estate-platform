<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

$select_admins = $conn->prepare("SELECT * FROM `admins` WHERE id = ? LIMIT 1");
$select_admins->execute([$admin_id]);
$fetch_admin = $select_admins->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 

   if(!empty($name)){
      $verify_name = $conn->prepare("SELECT name FROM `admins` WHERE name = ? LIMIT 1");
      $verify_name->execute([$name]);
      if($verify_name->rowCount() > 0){
         $warning_msg[] = 'Name already taken!';
      }else{
         $update_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
         $update_name->execute([$name, $admin_id]);
         $success_msg[] = 'Name updated!';
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $fetch_admin['password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $c_pass = sha1($_POST['c_pass']);
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $warning_msg[] = 'Old password not matched!';
      }elseif($c_pass != $new_pass){
         $warning_msg[] = 'Confirm password not matched!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
            $update_pass->execute([$c_pass, $admin_id]);
            $success_msg[] = 'Password updated!';
         }else{
            $warning_msg[] = 'Please enter new password!';
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->
    
<!-- update section starts -->

<section class="form-container">

   <form action="" method="POST">
      <h3>update your profile</h3>
      <input type="text" name="name" placeholder="<?= $fetch_admin['name']; ?>" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')"> 
      <input type="password" name="old_pass" placeholder="Enter old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Enter new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="c_pass" placeholder="Confirm new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Prevents the user from entering any spaces in the input. -->
      <input type="submit" value="update now" name="submit" class="btn">
   </form>

</section>

<!-- update section ends -->





















<!-- sweet alert cdn link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>