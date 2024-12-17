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
    <title>Search Page</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    
<!-- header section starts -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- filter section starts -->

<section class="filter-search">

    <form action="" method="post">
        <div id="close-filter"><i class="fas fa-times"></i></div>
        <h3>Filter your search</h3>
        <div class="flex"> 
            <div class="box">
                <p>Property address <span>*</span></p>
                <input type="text" name="address" maxlength="100"  placeholder="Enter property address" class="input">
            </div>           

            <div class="box">
                <p>Property type <span>*</span></p>
                <select name="type" class="input" required>
                    <option value="flat">Flat</option>
                    <option value="house">House</option>
                    <option value="shop">Shop</option>
                </select>
            </div>
            
            <div class="box">
                <p>Offer type <span>*</span></p>
                <select name="offer" class="input" required>
                    <option value="sale">sale</option>
                    <option value="resale">resale</option>
                    <option value="rent">rent</option>
                </select>
            </div>

            <div class="box">
                <p>Floor type <span>*</span></p>
                <select name="floor" class="input" required>
                    <option value="wooden">Wooden</option>
                    <option value="marble">Marble</option>
                    <option value="tiles">Tiles</option>
                    <option value="cemented">Cemented</option>
                    <option value="carpet">carpet</option>
                </select>
            </div>
            
            <div class="box">
                <p>Minimum budget <span>*</span></p>
                <select name="min" class="input" required>
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
                <p>Maximum budget <span>*</span></p>
                <select name="max" class="input" required>
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
                <p>Property status <span>*</span></p>
                <select name="status" class="input" required>
                    <option value="ready to move">ready to move</option>
                    <option value="under construction">under construction</option>
                </select>
            </div>

            <div class="box">
                <p>Furnished <span>*</span></p>
                <select name="furnished" class="input" required>
                    <option value="unfurnished">unfurnished</option>
                    <option value="semi-furnished">semi-furnished</option>
                    <option value="furnished">furnished</option>
                </select>
            </div>

        </div>
        <input type="submit" value="filter search" name="filter_search" class="btn-search">
    </form>
</section>

<!-- filter section ends -->

<div id="open-filter" class="fas fa-filter"></div>


<?php
if(isset($_POST['h_search'])){
    $h_address = $_POST['h_address'];
    $h_address = filter_var($h_address, FILTER_SANITIZE_STRING);
    $h_offer = $_POST['h_offer'];
    $h_offer = filter_var($h_offer, FILTER_SANITIZE_STRING);
    $h_type = $_POST['h_type'];
    $h_type = filter_var($h_type, FILTER_SANITIZE_STRING);
    $h_min = $_POST['h_min'];
    $h_min = filter_var($h_min, FILTER_SANITIZE_STRING);
    $h_max = $_POST['h_max'];
    $h_max = filter_var($h_max, FILTER_SANITIZE_STRING);

    $select_listings = $conn->prepare("SELECT * FROM `property` WHERE address LIKE '%{$h_address}%' 
    AND type LIKE '%{$h_type}%' AND offer LIKE '%{$h_offer}%' 
    AND price BETWEEN $h_min AND $h_max ORDER BY date DESC");
    $select_listings->execute();

}else if(isset($_POST['filter_search'])){

    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $offer = $_POST['offer'];
    $offer = filter_var($offer, FILTER_SANITIZE_STRING);
    $type = $_POST['type'];
    $type = filter_var($type, FILTER_SANITIZE_STRING);
    $floor = $_POST['floor'];
    $floor = filter_var($floor, FILTER_SANITIZE_STRING);
    $min = $_POST['min'];
    $min = filter_var($min, FILTER_SANITIZE_STRING);
    $max = $_POST['max'];
    $max = filter_var($max, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $furnished = $_POST['furnished'];
    $furnished = filter_var($furnished, FILTER_SANITIZE_STRING);

    $select_listings = $conn->prepare("SELECT * FROM `property` WHERE address LIKE '%{$address}%' 
    AND type LIKE '%{$type}%' AND offer LIKE '%{$offer}%' AND status Like '%{$status}%' 
    AND furnished Like '%{$furnished}%' AND floor Like '%{$floor}%' AND price BETWEEN $min 
    AND $max ORDER BY date DESC");
    $select_listings->execute();

}else{
    $select_listings = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 6");
    $select_listings->execute();
}



?>

<!-- listings section starts  -->

<section class="listings">

    <!-- <h1 class="heading">Search Results</h1> -->
    <?php 
        if(isset($_POST['h_search']) or isset($_POST['filter_search'])){
            echo '<h1 class="heading-services">search results</h1>';
        }else{
            echo '<h1 class="heading-services">latest listings</h1>';
        }
    ?>

    <div class="box-container">
    <?php
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

            $select_saved = $conn->prepare
            ("SELECT * FROM `saved` WHERE property_id = ? AND user_id = ?");
            $select_saved->execute([$property_id, $user_id]);
    ?>
    <form action="" method="POST">

        <div class="box">
            <input type="hidden" name="property_id" value="<?= $property_id; ?>" >
            <?php if($select_saved->rowCount() > 0){ ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart">

            </i><span>saved</span></button>
            <?php }else{ ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart">

            </i><span>save</span></button>
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
        echo '<p class="empty">no results found!</p>';
    }
    ?>

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

<script>
let filter = document.querySelector('.filter-search');

document.querySelector('#open-filter').onclick = () =>{
    filter.classList.add('active');
}

document.querySelector('#close-filter').onclick = () =>{
    filter.classList.remove('active');
}
</script>

</body>
</html>