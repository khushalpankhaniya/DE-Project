<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

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

<section class="messages">

   <h1 class="title"> Contact </h1>

   <section class="search-form">
   <form method="post">
   <input type="text" id="search" name="search_term" placeholder="Search..." class="box">
   <button type="submit" class="btn">Search</button>
   </form>
   </section>



   <div class="box-container">
   <?php
     $limit = 3;
     if (isset($_GET['page'])) {
      $page = $_GET['page'];
     } else {
       $page = 1;
     }
     $offset = ($page - 1) * $limit;
     if(isset($_POST['search_term'])) {

      $search_term = $_POST['search_term'];
      $query = "SELECT * FROM  message WHERE name LIKE '%$search_term%'";
      $result = mysqli_query($conn, $query);
      while ($fetch_users = mysqli_fetch_assoc($result)) {
        ?>
      <div class="box">
      <p> user id : <span><?php echo $fetch_users['user_id']; ?></span> </p>
      <p> username : <span><?php echo $fetch_users['name']; ?></span> </p>
      <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
      <p> email : <span><?php echo $fetch_users['message']; ?></span> </p>
      <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete message</a>
     </div>
        <?php
      }
    }else {
      
      $select_message = mysqli_query($conn, "SELECT * FROM `message` LIMIT {$offset},{$limit}") or die('query failed');
      if(mysqli_num_rows($select_message) > 0){
         while($fetch_message = mysqli_fetch_assoc($select_message)){
      
   ?> 
   <div class="box">
      <p> user id : <span><?php echo $fetch_message['user_id']; ?></span> </p>
      <p> name : <span><?php echo $fetch_message['name']; ?></span> </p>
      <p> number : <span><?php echo $fetch_message['number']; ?></span> </p>
      <p> email : <span><?php echo $fetch_message['email']; ?></span> </p>
      <p> message : <span><?php echo $fetch_message['message']; ?></span> </p>
      <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete message</a>
   </div>
   <?php
      };
            
   }else{
      echo '<p class="empty">you have no messages!</p>';
   }
}
   ?>
   </div>

   <div class="contanier-pagination">
  <?php
  $sql1 = "SELECT * FROM `message`";
  $result1 = mysqli_query($conn,$sql1) or die(mysqli_error());
  if (mysqli_num_rows($result1) > 0) {
  
    $total_records = mysqli_num_rows($result1); 
   
    $total_page = ceil($total_records / $limit);

   
    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination">';
     
    if ($page > 1) {
      echo ' <li class="page-item"><a class="page-link" href="admin_contacts.php?page='.($page -1).'" >Prev</a></li>';
    }
    for ($i=1; $i < $total_page; $i++) { 
      if ($i == $page) {
          $active = "active";
      } else {
       $active = "";
      }
        echo '<li class="page-item "><a class="page-link '.$active.'" href="admin_contacts.php?page='.$i.'"  >'.$i.'</a></li>';
    }
    if ($total_page > $page) {
      echo '<li class="page-item"><a class="page-link" href="admin_contacts.php?page='.($page +1).'">Next</a></li>';
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