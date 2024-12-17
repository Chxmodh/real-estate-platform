<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:listings.php');
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
    <title>View Property</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->
    
<!-- view property section starts -->

<section class="view-property">

    <?php
        $select_property = $conn->prepare("SELECT * FROM `property` WHERE id = ?  LIMIT 1");
        $select_property->execute([$get_id]);
        if($select_property->rowCount() > 0){
            while($fetch_property = $select_property->fetch(PDO::FETCH_ASSOC)){
            $property_id = $fetch_property['id'];

            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
            $select_user->execute([$fetch_property['user_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
            
        
    ?>
    <div class="details">
        <div class="swiper images-container">
            <div class="swiper-wrapper">
                <img src="../uploaded_files/<?= $fetch_property['image_01']; ?>" alt="" class="swiper-slide">
                <?php if(!empty($fetch_property['image_02'])){ 
                    echo '<img src="../uploaded_files/'.$fetch_property['image_02'].'" class="swiper-slide" alt="">';
                }?>   
                
                <?php if(!empty($fetch_property['image_03'])){ 
                    echo '<img src="../uploaded_files/'.$fetch_property['image_03'].'" class="swiper-slide" alt="">';
                }?> 

                <?php if(!empty($fetch_property['image_04'])){ 
                    echo '<img src="../uploaded_files/'.$fetch_property['image_04'].'" class="swiper-slide" alt="">';
                }?>
                
                <?php if(!empty($fetch_property['image_05'])){ 
                    echo '<img src="../uploaded_files/'.$fetch_property['image_05'].'" class="swiper-slide" alt="">';
                }?> 

            </div>
            <div class="swiper-pagination"></div>
        </div>
        <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
        <p class="address"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
        <div class="info">
            <p><i class="fa-regular fa-dollar-sign"></i><span><?= $fetch_property['price']; ?></span></p>
            <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
            <p><i class="fas fa-phone"></i><a href="tel:1234567890"><?= $fetch_user['number']; ?></a></p>
            <p><i class="fas fa-building"></i><span><?= $fetch_property['type']; ?></span></p>
            <p><i class="fas fa-house"></i><span><?= $fetch_property['offer']; ?></span></p>
            <p><i class="fas fa-calendar"></i><span><?= $fetch_property['date']; ?></span></p>
        </div>
        <h3 class="title">details</h3>

        <div class="flex">
            <div class="box">
                <p><i>Floor Type :</i><span><?= $fetch_property['floor']; ?></span></p>
                <p><i>Deposit amount : </i><span><span class="fa-regular fa-dollar-sign" style="margin-right: .5rem;"></span><?= $fetch_property['deposit']; ?></span></p>
                <p><i>status :</i><span><?= $fetch_property['status']; ?></span></p>
                <p><i>bedroom :</i><span><?= $fetch_property['bedroom']; ?></span></p>
                <p><i>bathroom :</i><span><?= $fetch_property['bathroom']; ?></span></p>
                <p><i>balcony :</i><span><?= $fetch_property['balcony']; ?></span></p>
            </div>
            <div class="box">
                <p><i>carpet area :</i><span><?= $fetch_property['carpet']; ?>sqft</span></p>
                <p><i>age :</i><span><?= $fetch_property['age']; ?> years</span></p>
                <p><i>total floors :</i><span><?= $fetch_property['total_floors']; ?></span></p>
                <p><i>Ownership :</i><span><?= $fetch_property['ownership']; ?></span></p>
                <p><i>furnished :</i><span><?= $fetch_property['furnished']; ?></span></p>
                <p><i>loan :</i><span><?= $fetch_property['loan']; ?></span></p>
            </div>
        </div>
        <h3 class="title">amenities</h3>
        <div class="flex">
            <div class="box">
                <p><i class="fas fa-<?php if($fetch_property['lift'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>lifts</span></p>
                <p><i class="fas fa-<?php if($fetch_property['security_guard'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>security guards</span></p>
                <p><i class="fas fa-<?php if($fetch_property['play_ground'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>play ground</span></p>
                <p><i class="fas fa-<?php if($fetch_property['garden'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>gardens</span></p>
                <p><i class="fas fa-<?php if($fetch_property['water_supply'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>water supply</span></p>
                <p><i class="fas fa-<?php if($fetch_property['power_backup'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>power backup</span></p>
            </div>

            <div class="box">
                <p><i class="fas fa-<?php if($fetch_property['parking_area'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>parking area</span></p>
                <p><i class="fas fa-<?php if($fetch_property['gym'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>gym</span></p>
                <p><i class="fas fa-<?php if($fetch_property['shopping_mall'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>shopping mall</span></p>
                <p><i class="fas fa-<?php if($fetch_property['hospital'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>hospital</span></p>
                <p><i class="fas fa-<?php if($fetch_property['school'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>schools</span></p>
                <p><i class="fas fa-<?php if($fetch_property['market_area'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>market area</span></p>
            </div>
        </div>
        <h3 class="title">description</h3>
        <p class="description"><?= $fetch_property['description']; ?></p>

        <form action="" method="POST" class="flex-btn">
        <input type="hidden" name="delete_id" value="<?= $property_id; ?>">
            <a href="listings.php" class="option-btn">Go back</a>
            <input type="submit" value="delete listing" onclick="return confirm('delete this property?');" name="delete" class="delete-btn">
        </form>

    </div>

    <?php
        }
    }else{
        echo'<p class="empty">property not found!</p>';
    }
    ?>

</section>

<!-- view property section ends -->



















<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<!-- sweet alert cdn link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

<script>
var swiper = new Swiper(".images-container", {
    loop: true,
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 200,
        modifier: 1,
        slideShadows: true,
    },
    pagination: {
        el: ".swiper-pagination",
    },
});
</script>

</body>
</html>