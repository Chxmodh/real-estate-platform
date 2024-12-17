<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

include 'components/save_send.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    
<!-- header section starts -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- home section starts  -->

<div class="home">
    <section class="center">
        <form action="search.php" method="post">
            <h3>Explore Homes That Suit You</h3>
            <div class="box">
                <p>property address <span>*</span></p>
                <input type="text" name="h_address"  maxlength="100" 
                required placeholder="Enter property address" class="input">
            </div>

            <div class="flex">            

                <div class="box">
                    <p>property type <span>*</span></p>
                    <select name="h_type" class="input" required>
                        <option value="flat">Flat</option>
                        <option value="house">House</option>
                        <option value="shop">Shop</option>
                    </select>
                </div>
                
                
                <div class="box">
                    <p>offer type <span>*</span></p>
                    <select name="h_offer" class="input" required>
                        <option value="sale">Sale</option>
                        <option value="resale">Resale</option>
                        <option value="rent">Rent</option>
                    </select>
                </div>
                

                <div class="box">
                    <p>minimum budget <span>*</span></p>
                    <select name="h_min" class="input" required>
                        <option value="50000">5k</option>
                        <option value="100000">10k</option>
                        <option value="150000">15k</option>
                        <option value="200000">20k</option>
                        <option value="300000">30k</option>
                        <option value="400000">40k</option>
                        <option value="400000">40k</option>
                        <option value="500000">50k</option>
                        <option value="600000">60k</option>
                    </select>
                </div>

                <div class="box">
                    <p>maximum budget <span>*</span></p>
                    <select name="h_max" class="input" required>
                        <option value="50000">5k</option>
                        <option value="100000">10k</option>
                        <option value="150000">15k</option>
                        <option value="200000">20k</option>
                        <option value="300000">30k</option>
                        <option value="400000">40k</option>
                        <option value="400000">40k</option>
                        <option value="500000">50k</option>
                        <option value="600000">60k</option>
                    </select>
                </div>
            </div>
            <input type="submit" value="search property" name="h_search" class="btn-search">
        </form>
    </section>
</div>

<!-- home section ends  -->

<!-- services section starts  -->

<section class="services">

   <h1 class="heading-services">our services</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/icon-1-new.png" alt="">
         <h3>property management</h3>
         <p>Property management solutions, including tenant screening, maintenance, and rent collection.</p>
      </div>

      <div class="box">
         <img src="images/icon-2-new.png" alt="">
         <h3>consultancy</h3>
         <p>Expert advice to help you make informed decisions when buying, selling, or investing in real estate.</p>
      </div>

      <div class="box">
         <img src="images/icon-3-new.png" alt="">
         <h3>luxury properties</h3>
         <p>Discover exclusive listings of premium homes, villas, and high-end real estate for elite living.</p>
      </div>

      <div class="box">
         <img src="images/icon-4-new.png" alt="">
         <h3>real estate valuation</h3>
         <p>Accurate property appraisals and market analysis to help you understand the true value of your asset.</p>
      </div>

      <div class="box">
         <img src="images/icon-5-new.png" alt="">
         <h3>relocation assistance</h3>
         <p>Smooth and hassle-free relocation services, including finding a home, moving, and settling in.</p>
      </div>

      <div class="box">
         <img src="images/icon-6-new.png" alt="">
         <h3>24/7 service</h3>
         <p>Round-the-clock assistance for all your real estate needs, ensuring support anytime, anywhere.</p>
      </div>

   </div>

</section>

<!-- services section ends  -->

<!-- listings section starts  -->

<section class="listings">

    <h1 class="heading-services">latest listings</h1>

    <div class="box-container">
        <?php
            $select_listings = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 2");
            $select_listings->execute();

            if($select_listings->rowCount() > 0){
                while($fetch_listing = $select_listings->fetch(PDO::FETCH_ASSOC)){

                $property_id = $fetch_listing['id'];
                $select_users = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_users->execute([$fetch_listing['user_id']]);
                $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);

                if(!empty($fetch_listing['image_02'])){
                    $count_image_02 = 1;
                }else{
                    $count_image_02 = 0;
                }
                if(!empty($fetch_listing['image_03'])){
                    $count_image_03 = 1;
                }else{
                    $count_image_03 = 0;
                }
                if(!empty($fetch_listing['image_04'])){
                    $count_image_04 = 1;
                }else{
                    $count_image_04 = 0;
                }
                if(!empty($fetch_listing['image_05'])){
                    $count_image_05 = 1;
                }else{
                    $count_image_05 = 0;
                }

                $total_images = (1 + $count_image_02 + $count_image_03 + $count_image_04 + $count_image_05);

                $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? AND user_id = ?");
                $select_saved->execute([$property_id, $user_id]);
        ?>
        <form action="" method="POST">

            <div class="box">
                <input type="hidden" name="property_id" value="<?= $property_id; ?>" >
                <?php if($select_saved->rowCount() > 0){ ?>
                <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>saved</span></button>
                <?php }else{ ?>
                <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
                <?php } ?>

                <div class="thumb">
                    <p><i class="fas fa-image"></i><span><?= $total_images; ?></span></p> 
                    <img src="uploaded_files/<?= $fetch_listing['image_01']; ?>" alt="">
                </div>

                <div class="admin">
                    <h3><?= substr($fetch_users['name'], 0, 1); ?></h3>
                    <div>
                        <p><?= $fetch_users['name']; ?></p>
                        <span><?= $fetch_listing['date']; ?></span>
                    </div>
                </div>
            </div>

            <div class="box">
                <p class="price"><i class="fa-regular fa-dollar-sign"></i><span><?=$fetch_listing['price']; ?></span></p>
                <h3 class="name"><?= $fetch_listing['property_name']; ?></h3>
                <p class="address"><i class="fas fa-map-marker-alt"></i><span><?=$fetch_listing['address']; ?></span></p>
                <div class="flex">
                    <p><i class="fas fa-house"></i><span><?= $fetch_listing['type']; ?></span></p>
                    <p><i class="fas fa-tag"></i><span><?= $fetch_listing['offer']; ?></span></p>
                    <p><i class="fas fa-bed"></i><span><?= $fetch_listing['floor']; ?></span></p>
                    <p><i class="fas fa-trowel"></i><span><?= $fetch_listing['status']; ?></span></p>
                    <p><i class="fas fa-couch"></i><span><?= $fetch_listing['furnished']; ?></span></p>
                    <p><i class="fas fa-maximize"></i><span><?= $fetch_listing['carpet']; ?>sqft</span></p>
                </div>

                <div class="flex-btn">
                    <a href="view_property.php?get_id=<?= $property_id; ?>" class="btn">view property</a>
                    <input type="submit" value="send enquiry" name="send" class="btn">
                </div>

            </div>
            
        </form>
        <?php
            }
        }else{
            echo '<p class="empty">no propertylisted yet!</p>';
        }
        ?>

    </div>
    
    <div style="margin-top: 2rem; text-align:center; margin-bottom: 2rem;">
      <a href="listings.php" class="inline-btn">view all</a>
   </div>

</section>

<!-- listings section ends  -->


<!-- footer section starts -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->



<!-- sweet alert cdn link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js link -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>