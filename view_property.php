<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
} 
//checks if a cookie named user_id exists. used to store user-specific data between page visits
//track user activity across web pages and remeber the user like remember me fucntion, remeber user preferences.

if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
 }else{
    $get_id = '';
    header('location:home.php');
 }

 include 'components/save_send.php';

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
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    
<!-- header section starts -->
<?php include 'components/user_header.php'; ?>
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

            $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
            $select_saved->execute([$property_id, $user_id]);
            
        
    ?>
    <div class="details">
        <div class="swiper images-container">
            <div class="swiper-wrapper">
                <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="" class="swiper-slide">
                <?php if(!empty($fetch_property['image_02'])){ 
                    echo '<img src="uploaded_files/'.$fetch_property['image_02'].'" class="swiper-slide" alt="">';
                }?>   
                
                <?php if(!empty($fetch_property['image_03'])){ 
                    echo '<img src="uploaded_files/'.$fetch_property['image_03'].'" class="swiper-slide" alt="">';
                }?> 

                <?php if(!empty($fetch_property['image_04'])){ 
                    echo '<img src="uploaded_files/'.$fetch_property['image_04'].'" class="swiper-slide" alt="">';
                }?>
                
                <?php if(!empty($fetch_property['image_05'])){ 
                    echo '<img src="uploaded_files/'.$fetch_property['image_05'].'" class="swiper-slide" alt="">';
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
                <p><i>Floor type :</i><span><?= $fetch_property['floor']; ?></span></p>
                <p><i>Deposit amount : </i><span><span class="fa-regular fa-dollar-sign" style="margin-right: .5rem;"></span><?= $fetch_property['deposit']; ?></span></p>
                <p><i>Status :</i><span><?= $fetch_property['status']; ?></span></p>
                <p><i>Bedroom :</i><span><?= $fetch_property['bedroom']; ?></span></p>
                <p><i>Bathroom :</i><span><?= $fetch_property['bathroom']; ?></span></p>
                <p><i>Balcony :</i><span><?= $fetch_property['balcony']; ?></span></p>
            </div>
            <div class="box">
                <p><i>Carpet area :</i><span><?= $fetch_property['carpet']; ?>sqft</span></p>
                <p><i>Age :</i><span><?= $fetch_property['age']; ?> years</span></p>
                <p><i>Total floors :</i><span><?= $fetch_property['total_floors']; ?></span></p>
                <p><i>Ownership :</i><span><?= $fetch_property['ownership']; ?></span></p>
                <p><i>Furnished :</i><span><?= $fetch_property['furnished']; ?></span></p>
                <p><i>Loan :</i><span><?= $fetch_property['loan']; ?></span></p>
            </div>
        </div>
        <h3 class="title">Amenities</h3>
        <div class="flex">
            <div class="box">
                <p><i class="fas fa-<?php if($fetch_property['lift'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Lifts</span></p>
                <p><i class="fas fa-<?php if($fetch_property['security_guard'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Security guards</span></p>
                <p><i class="fas fa-<?php if($fetch_property['play_ground'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Play ground</span></p>
                <p><i class="fas fa-<?php if($fetch_property['garden'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Gardens</span></p>
                <p><i class="fas fa-<?php if($fetch_property['water_supply'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>water supply</span></p>
                <p><i class="fas fa-<?php if($fetch_property['power_backup'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Power backup</span></p>
            </div>

            <div class="box">
                <p><i class="fas fa-<?php if($fetch_property['parking_area'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Parking area</span></p>
                <p><i class="fas fa-<?php if($fetch_property['gym'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Gym</span></p>
                <p><i class="fas fa-<?php if($fetch_property['shopping_mall'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Shopping mall</span></p>
                <p><i class="fas fa-<?php if($fetch_property['hospital'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Hospital</span></p>
                <p><i class="fas fa-<?php if($fetch_property['school'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Schools</span></p>
                <p><i class="fas fa-<?php if($fetch_property['market_area'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Market area</span></p>
            </div>
        </div>
        <h3 class="title">Description</h3>
        <p class="description"><?= $fetch_property['description']; ?></p>

        <form action="" method="POST" class="flex-btn">
            <input type="hidden" name="property_id" value="<?= $property_id; ?>">
            <?php
                if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>saved</span></button>
            <?php
                }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
            <?php
                }
            ?>
            <input type="submit" value="send enquiry" name="send" class="btn">
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

















<!-- footer section starts -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- sweet alert cdn link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js link -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

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