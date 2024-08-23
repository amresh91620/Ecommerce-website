<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset( $_SESSION['user_id'])){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_POST['p_image'];

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_POST['p_image'];
   $p_qty = $_POST['p_qty'];


   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>
   <link rel="icon" type="image/x-icon" href="">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-----bootstrap------->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/homestyle.css">
<style>
   a{
     text-decoration: none;
   }
</style>
<style>
#banner{
   height: 600px;
}
</style>
</head>
<body>
   
<?php @include 'header.php'; ?>
<!-- 
<div class="home-bg">

   <section class="home">

      <div class="content">
         <span></span>
         <h3>Reach For A Healthier You With Organic Foods</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto natus culpa officia quasi, accusantium explicabo?</p>
         <a href="shop.php" class="btn">Shop Now</a>
      </div>
      

   </section>

</div> -->
<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
       <img src="banner_image/banner2.jpg" class="w-100" alt="..." id="banner">
      <div class="carousel-caption d-none d-md-block">
         <a href="shop.php" class="btn">Shop Now</a>
        <h3></h3>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="banner_image/banner3.jpg" class="w-100 " alt="" id="banner">
      <div class="carousel-caption d-none d-md-block">
        <h3></h3>
        <p></p>
        <a href="shop.php" class="btn">Shop Now</a>
      </div>
    </div>
    <div class="carousel-item">
      <img src="banner_image/banner1.jpg" class="w-100 " alt="..." id="banner">

      <div class="carousel-caption d-none d-md-block" >
        <p></p>
        <h5><a href="shop.php" class="btn">Shop Now</a></h5>
      </div>
    </div>
     <div class="carousel-item">
       <img src="banner_image/banner4.avif" class="w-100 " alt="..." id="banner"> 
      <div class="carousel-caption d-none d-md-block">
        <h5><a href="about.php" class="btn">Shop Now</a></h5>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<!-----------------shop catrgory--------->

<section class="home-category">

   <h1 class="title">shop by category</h1>

   <div class="box-container">

      <div class="box">
         <img src="img_categri/tshirt.png" alt="">
         <h3>T-shirt</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=T-shirt" class="btn">T-shirt</a>
      </div>

      <div class="box">
      <img src="img_categri/shoes.png" alt="">
         <h3>Shoes</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=Shoes" class="btn">Shoes</a>
      </div>

      <div class="box">
      <img src="img_categri/jinsh.png" alt="">
         <h3>Jinsh</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=Jinsh" class="btn">Jinsh</a>
      </div>

      <div class="box">
      <img src="img_categri/lady.png" alt="">
         <h3>Lady-item</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=Lady-item" class="btn">Lady-item</a>
      </div>

   </div>

</section>


<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY `products`.`id` DESC LIMIT 12");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price">Rs.<span><?= $fetch_products['price']; ?></span>/=</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
 <!--  <div class="rating">
    <input type="hidden" name="rating" class="rating-value" value="1">
    <!-- Star icons 
    <i class="fas fa-star rating-star" data-rating="1"></i>
    <i class="fas fa-star rating-star" data-rating="2"></i>
    <i class="fas fa-star rating-star" data-rating="3"></i>
    <i class="fas fa-star rating-star" data-rating="4"></i>
    <i class="fas fa-star rating-star" data-rating="5"></i>
</div>-->
      <div class="latest-btn">
        <button type="submit" class="option-buttn" name="add_to_cart"><i class="fas fa-cart-shopping " ></i></button>
        <input type="number" min="0" value="1" name="p_qty" class="qty" step="0.1">
      </div>
      
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

</section>







<?php include 'footer.php'; ?>
<!--------bootstrap javascript-------->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>


</body>
</html>

<style>
   .rating {
    position: absolute;
    margin-top: -18px;
    margin-left: 5px;
}

.rating-star {
  
    cursor: pointer;
    font-size: 18px; /* Adjust the font size of the stars */
    color: #ccc; /* Default color of the stars */
    transition: color 0.2s;
}

.rating-star:hover,
.rating-star.selected {
    color: #ffc107; /* Color of the selected/starred stars */
}
</style>
<!--
<script>
document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll('.rating-star');
    const ratingValue = document.querySelector('.rating-value');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            ratingValue.value = rating;
            // Optionally, you can add visual feedback to indicate the selected rating
            stars.forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.classList.add('selected');
                } else {
                    s.classList.remove('selected');
                }
            });
        });
    });
});
</script>
