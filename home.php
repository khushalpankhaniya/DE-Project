<?php

include 'config.php';

session_start();



if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}

if(isset($_POST['add_to_cart'])){
  
   if (isset($_SESSION['user_id'])) {
   
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }
}else {
   echo '
   <script>
   alert("please login before Add to cart");
   window.location.href = "login.php";
   </script>
   ';
   
}  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Welcome to The Medi Spot</h3>
      <p>Your one-stop shop for trusted medical products and everyday health essentials. Quality care made simple.</p>
      <a href="about.php" class="white-btn">discover more</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="https://media.istockphoto.com/id/1402604850/photo/the-word-about-us-on-wooden-cubes-business-communication-and-information.jpg?s=612x612&w=0&k=20&c=Oc2HZUPVJRXFsjTwKVgWY_ddWrKeQUG0KCyKUGef-ig=" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>At The Medi Spot, we’re dedicated to providing reliable healthcare products and wellness support you can trust. Our mission is to make quality health solutions accessible, affordable, and easy to find — because your well-being matters.</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>
 
<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>


<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>We're here to help! Whether you need product guidance, order support, or general health advice, our friendly team is just a message away. Don’t hesitate to reach out — your peace of mind is our priority.</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
