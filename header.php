<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

// session_start();
?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="https://www.facebook.com/campaign/landing.php?campaign_id=14884913640&extra_1=s%7Cc%7C550525804791%7Cb%7Cfacebook%20%27%7C&placement=&creative=550525804791&keyword=facebook%20%27&partner_id=googlesem&extra_2=campaignid%3D14884913640%26adgroupid%3D128696220912%26matchtype%3Db%26network%3Dg%26source%3Dnotmobile%26search_or_content%3Ds%26device%3Dc%26devicemodel%3D%26adposition%3D%26target%3D%26targetid%3Dkwd-327195741349%26loc_physical_ms%3D1007753%26loc_interest_ms%3D%26feeditemid%3D%26param1%3D%26param2%3D&gclid=Cj0KCQiA99ybBhD9ARIsALvZavWRudGBvd1UlRTCQYkAsMvWCAJPfBwvh1PnTLe0yiJVUPAerU-GJ0IaAqrtEALw_wcB" class="fab fa-facebook-f"></a>
            <a href="https://twitter.com/login" class="fab fa-twitter"></a>
            <a href="https://www.instagram.com/" class="fab fa-instagram"></a>
            <a href="https://www.linkedin.com/feed/" class="fab fa-linkedin"></a>
         </div>
         <p> new <a href="login.php">login</a> | <a href="register.php">register</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">The MediSpot</a>

         <nav class="navbar">
            <a href="home.php">home</a>
            <a href="shop.php">shop</a>
            <a href="about.php">about</a>
            <a href="contact.php">contact</a>
            <a href="orders.php">orders</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
         <?php 
           if (isset($_SESSION['user_id'])) {
            ?>
            <div id="user-btn" class="fas fa-user"></div>
          
          <?php   
            $user_id = $_SESSION['user_id'];
            $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            $cart_rows_number = mysqli_num_rows($select_cart_number); ?>
        
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="user-box">
            <i class="fa-solid fa-xmark removebtn"></i>
            <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <form method="post"><input type="submit" value="logout" class="delete-btn" name="delete-btn"></form>
         </div>
          <?php }else {  ?>
             <div id="user-btn" class="fas fa-user"></div>

            <div class="user-box">
            <i class="fa-solid fa-xmark removebtn"></i>
            <a href="login.php" class="delete-btn">login</a>
            </div>
            <?php
          } ?>
         
      </div>
   </div>
</header>

<?php 
 if (isset($_POST['delete-btn'])) {
   session_destroy();
   header("location:home.php");
 }
?>

           
    