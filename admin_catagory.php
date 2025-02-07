<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catagory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

     <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<?php
include 'config.php';

if(isset($_POST['add_product'])){
   $id= $_POST['id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);

   $select_catagory_name = mysqli_query($conn, "SELECT name FROM `a_brands` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_catagory_name) > 0){
      $message[] = 'product name already added';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `a_brands`(id,name) VALUES('$id','$name')") or die('query failed');
      echo "
      <div class='message'>
      <span>Catagory add sucesfully</span>
      <i class='fas fa-times' onclick='this.parentElement.remove();'></i>
   </div>
      ";
   }
}
?>
<?php include 'admin_header.php'; ?>


<section class="add-products">

   <h1 class="title">Add Catagory</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add Catagory</h3> 
      <input type="number" min="0" name="id" class="box" placeholder="enter product brand" required>
      <input type="text" name="name" class="box" placeholder="enter catagory" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>
</body>
<script src="js/admin_script.js"></script>
</html>