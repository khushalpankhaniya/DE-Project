<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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

<section class="users">

   <h1 class="title"> user accounts </h1>

   <section class="search-form">
   <form method="post">
   <input type="text" id="search" name="search_term" placeholder="Search..." class="box">
   <button type="submit" class="btn">Search</button>
   </form>
   </section>



   <div class="box-container">
      <?php
       $limit = 6;
       if (isset($_GET['page'])) {
        $page = $_GET['page'];
       } else {
         $page = 1;
       }
       
       $offset = ($page - 1) * $limit;
       if(isset($_POST['search_term'])) {

         $search_term = $_POST['search_term'];
         $query = "SELECT * FROM users WHERE name LIKE '%$search_term%'";
         $result = mysqli_query($conn, $query);
         while ($fetch_users = mysqli_fetch_assoc($result)) {
           ?>
         <div class="box">
         <p> user id : <span><?php echo $fetch_users['id']; ?></span> </p>
         <p> username : <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
         <p> user type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete user</a>
        </div>
           <?php
         }
       }else {
         
         $select_users = mysqli_query($conn, "SELECT * FROM `users` LIMIT {$offset},{$limit}") or die('query failed');
         while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="box">
         <p> user id : <span><?php echo $fetch_users['id']; ?></span> </p>
         <p> username : <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
         <p> user type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete user</a>
      </div>
      <?php
         }
      }
      ?>
   </div>

   <div class="contanier-pagination">
  <?php
  $sql1 = "SELECT * FROM `users`";
  $result1 = mysqli_query($conn,$sql1) or die(mysqli_error());
  if (mysqli_num_rows($result1) > 0) {
  
    $total_records = mysqli_num_rows($result1); 
   
    $total_page = ceil($total_records / $limit);

   
    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination">';
     
    if ($page > 1) {
      echo ' <li class="page-item"><a class="page-link" href="admin_users.php?page='.($page -1).'" >Prev</a></li>';
    }
    for ($i=1; $i < $total_page; $i++) { 
      if ($i == $page) {
          $active = "active";
      } else {
       $active = "";
      }
        echo '<li class="page-item "><a class="page-link '.$active.'" href="admin_users.php?page='.$i.'"  >'.$i.'</a></li>';
    }
    if ($total_page > $page) {
      echo '<li class="page-item"><a class="page-link" href="admin_users.php?page='.($page +1).'">Next</a></li>';
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