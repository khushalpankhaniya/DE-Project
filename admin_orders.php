<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'payment status has been updated!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

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

   .search-form form{
   max-width: 1200px;
   margin:0 auto;
   display: flex;
   gap:1rem;
}

.search-form form .btn{
   margin-top: 0;
}

.search-form form .box{
   width: 100%;
   padding:1.2rem 1.4rem;
   border:var(--border);
   font-size: 2rem;
   color:var(--black);
   background-color: var(--light-bg);
   border-radius: .5rem;
}
</style>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">placed orders</h1>

   <section class="search-form">
   <form method="post">
   <input type="text" id="search" name="search_term" placeholder="Search..." class="box">
   <button type="submit" class="btn">Search</button>
   </form>
   </section>



   <div class="box-container">
      <?php
        $limit = 2;
        if (isset($_GET['page'])) {
         $page = $_GET['page'];
        } else {
          $page = 1;
        }
      $offset = ($page - 1) * $limit;

      if(isset($_POST['search_term'])) {

         $search_term = $_POST['search_term'];
         $select_orders = mysqli_query($conn, "SELECT * FROM  orders WHERE name LIKE '%$search_term%'") or die('query failed');
         if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
         ?>
         <div class="box">
            <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
            <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
            <p> name : <span><?php echo $fetch_orders['name']; ?></span> </p>
            <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
            <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
            <p> address : <span><?php echo $fetch_orders['address']; ?></span> </p>
            <p> total products : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
            <p> total price : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
            <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
            <form action="" method="post">
               <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
               <select name="update_payment">
                  <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                  <option value="pending">pending</option>
                  <option value="completed">completed</option>
               </select>
               <input type="submit" value="update" name="update_order" class="option-btn">
               <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">delete</a>
            </form>
         </div>
         <?php
            }
         }else{
            echo '<p class="empty">no orders placed yet!</p>';
         }
       }else {
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders` LIMIT {$offset},{$limit}") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> name : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> address : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> total products : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> total price : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
         <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">pending</option>
               <option value="completed">completed</option>
            </select>
            <input type="submit" value="update" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">delete</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
   }
      ?>
   </div>

   <div class="contanier-pagination">
  <?php
  $sql1 = "SELECT * FROM `orders`";
  $result1 = mysqli_query($conn,$sql1) or die(mysqli_error());
  if (mysqli_num_rows($result1) > 0) {
  
    $total_records = mysqli_num_rows($result1); 
   
    $total_page = ceil($total_records / $limit);

   
    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination">';
     
    if ($page > 1) {
      echo ' <li class="page-item"><a class="page-link" href="admin_orders.php?page='.($page -1).'" >Prev</a></li>';
    }
    for ($i=1; $i < $total_page; $i++) { 
      if ($i == $page) {
          $active = "active";
      } else {
       $active = "";
      }
        echo '<li class="page-item "><a class="page-link '.$active.'" href="admin_orders.php?page='.$i.'"  >'.$i.'</a></li>';
    }
    if ($total_page > $page) {
      echo '<li class="page-item"><a class="page-link" href="admin_orders.php?page='.($page +1).'">Next</a></li>';
    }
    echo '</ul>';
    echo '</nav>';
}
   ?>
</div>
</section>










<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>