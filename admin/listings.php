<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `property` WHERE id = ? LIMIT 1");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){

      $fetch_images = $verify_delete->fetch(PDO::FETCH_ASSOC);
      $delete_image_01 = $fetch_images['image_01'];
      $delete_image_02 = $fetch_images['image_02'];
      $delete_image_03 = $fetch_images['image_03'];
      $delete_image_04 = $fetch_images['image_04'];
      $delete_image_05 = $fetch_images['image_05'];

      unlink('../uploaded_files/'.$delete_image_01);

      if(!empty($delete_image_02)){
         unlink('../uploaded_files/'.$delete_image_02);
      }
      if(!empty($delete_image_03)){
         unlink('../uploaded_files/'.$delete_image_03);
      }
      if(!empty($delete_image_04)){
         unlink('../uploaded_files/'.$delete_image_04);
      }
      if(!empty($delete_image_05)){
         unlink('../uploaded_files/'.$delete_image_05);
      }

      $delete_saved = $conn->prepare("DELETE FROM `saved` WHERE property_id = ?");
      $delete_saved->execute([$delete_id]);
      $delete_requests = $conn->prepare("DELETE FROM `requests` WHERE property_id = ?");
      $delete_requests->execute([$delete_id]);
      $delete_listings = $conn->prepare("DELETE FROM `property` WHERE id = ?");
      $delete_listings->execute([$delete_id]);

      $success_msg[] = "Property deleted!";

   }else{
      $warning_msg[] = "Property already deleted!";
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listings</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->
    
<!-- listing section starts -->

<section class="listings">

   <h1 class="heading">Properties Listed</h1>

   <form action="" method="POST" class="search-form">
      <input type="text" name="search_box" placeholder="search listings..." maxlength="100" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>

   <div class="box-container">
   <?php
      if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
         $search_box = $_POST['search_box'];
         $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
         $select_listings = $conn->prepare("SELECT * FROM `property` WHERE property_name LIKE '%{$search_box}%' OR address LIKE '%{$search_box}%' ORDER BY date DESC");
         $select_listings->execute();
      }else{
         $select_listings = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC");
         $select_listings->execute();
      }

      if($select_listings->rowCount() > 0){
         while($fetch_property = $select_listings->fetch(PDO::FETCH_ASSOC)){

         $property_id = $fetch_property['id'];

         $select_users = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_users->execute([$fetch_property['user_id']]);
         $fetch_user = $select_users->fetch(PDO::FETCH_ASSOC);

         if(!empty($fetch_property['image_02'])){
            $image_02_count = 1;
         }else{
            $image_02_count = 0;
         }
         if(!empty($fetch_property['image_03'])){
            $image_03_count = 1;
         }else{
            $image_03_count = 0;
         }
         if(!empty($fetch_property['image_04'])){
            $image_04_count = 1;
         }else{
            $image_04_count = 0;
         }
         if(!empty($fetch_property['image_05'])){
            $image_05_count = 1;
         }else{
            $image_05_count = 0;
         }
            
         $total_images = (1 + $image_02_count + $image_03_count + $image_04_count + $image_05_count);
      ?>
   <div class="box">
      <div class="thumb">
         <p><i class="fas fa-image"></i><span><?= $total_images; ?></span></p>
         <img src="../uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
      </div>
   

   <p class="price"><i class="fa-regular fa-dollar-sign"></i><?= $fetch_property['price']; ?></p>
   <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
   <p class="address"><i class="fas fa-map-marker-alt"></i><?= $fetch_property['address']; ?></p>
   <form action="" method="POST" class="flex-btn">
      <input type="hidden" name="delete_id" value="<?= $property_id; ?>">
      <a href="view_property.php?get_id=<?= $property_id; ?>" class="btn">view property</a>
      <input type="submit" value="delete listing" onclick="return confirm('delete this property?');" name="delete" class="delete-btn">
   </form>
   </div>

   <?php
         }

      }elseif(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
         echo '<p class="empty">No results found!</p>';
      }else{
         echo '<p class="empty">No property listed yet!</p>';
      }
   ?>

   </div>

</section>















<!-- listing section ends -->





<!-- sweet alert cdn link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>