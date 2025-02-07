<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){
   $bid= $_POST['brand_id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already added';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `products`(brand_id,name, price, image) VALUES('$bid','$name', '$price', '$image')") or die(mysqli_error());

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'product added successfully!';
         }
      }else{
         $message[] = 'product could not be added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->

   <!-- jqury -->
  <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<style>
   .contanier-pagination{
      display: flex;
      justify-content: center;
   
   }

   .pagination{
   display: flex;
   padding-left: 0;
   list-style: none;
   margin : 2rem 0;
   
   }
   .page-link {
   position: relative;
   display: block;
   padding: 0.75rem 0.375rem;
   color: var(--light-bg);
   text-decoration: none;
   padding:1.3rem;
  
   /* border:var(--border);  */
   background-color: var(--purple);
   /* border-radius: 0.2rem;margin: 0 0.2rem; */
   font-weight: bold;
   font-size: 1.2rem;
   transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
   }
   .active{
   background-color: var(--light-bd);
   color: var(--black);
   }

</style>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">shop products</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add product</h3> 
      <input type="number" min="0" name="brand_id" class="box" placeholder="enter product brand" required>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">


   <div class="box-container">

      <?php
        $limit = 6;
        if (isset($_GET['page'])) {
         $page = $_GET['page'];
        } else {
          $page = 1;
        }
        
        $offset = ($page - 1) * $limit;
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT {$offset},{$limit}") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" width="100%" height="100%" >
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="name">Catagory_id:-<?php echo $fetch_products['brand_id']; ?></div>
         <div class="price">Rs.<?php echo $fetch_products['price']; ?>/-</div>
         <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
</div>

<div class="contanier-pagination">
<?php
  $sql1 = "SELECT * FROM `products`";
  $result1 = mysqli_query($conn,$sql1) or die(mysqli_error());

  if (mysqli_num_rows($result1) > 0) {
  
    $total_records = mysqli_num_rows($result1); 
   
    $total_page = ceil($total_records / $limit);

   
    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination">';
     
    if ($page > 1) {
      echo ' <li class="page-item"><a class="page-link" href="admin_products.php?page='.($page -1).'" >Prev</a></li>';
    }
    for ($i=1; $i < $total_page; $i++) { 
      if ($i == $page) {
          $active = "active";
      } else {
       $active = "";
      }
        echo '<li class="page-item "><a class="page-link '.$active.'" href="admin_products.php?page='.$i.'"  >'.$i.'</a></li>';
    }
    if ($total_page > $page) {
      echo '<li class="page-item"><a class="page-link" href="admin_products.php?page='.($page +1).'">Next</a></li>';
    }
    echo '</ul>';
    echo '</nav>';
}
   ?>
</div>
</section>


<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>



<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" ></script>
  <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script>
  $(document).ready( function () {
		$('.table').DataTable();
  });
  </script>
</body>
</html>