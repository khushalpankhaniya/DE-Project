<?php

include 'config.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}


if(isset($_POST['add_to_cart'])){
   
   if (isset($_SESSION['user_id']) ) {
      
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
   }
   else {
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
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- <link href="/dist/output.css" rel="stylesheet"> -->

   <link rel="stylesheet" href="css/style.css">

 
</head>
<style>
   .contanier-pagination{
      display: flex;
      justify-content: center;
      background: #FFF;
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
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>our shop</h3>
   <p> <a href="home.php">home</a> / shop </p>
</div>


<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">
      
<div id="catagorybox">
       <h6 class="title">catagory List</h6>      
           <div class="card-body">                   
              <form action="" method="GET">
           
                  <ul class="link">
                            <?php
                                $con = mysqli_connect("localhost","root","","project");

                                $brand_query = "SELECT * FROM a_brands";
                                $brand_query_run  = mysqli_query($con, $brand_query);

                                if(mysqli_num_rows($brand_query_run) > 0)
                                {
                                    foreach($brand_query_run as $brandlist)
                                    {
                                        $checked = [];
                                        if(isset($_GET['brands']))
                                        {
                                            $checked = $_GET['brands'];
                                        }
                                        ?>       
                                     
                                        <li class="">
                                         <div class="">
                                                 <input type="checkbox" class="inputs"  name="brands[]" id="check" value="<?= $brandlist['id']; ?>" 
                                                    <?php if(in_array($brandlist['id'], $checked)){ echo "checked"; } ?>
                                                 />
                                                 <label for="check" class="inputslabel"> <?= $brandlist['name']; ?></label>                                                               
                                         </div>
                                        </li>
                                       <?php
                                    }
                                }
                                else
                                {echo "No Brands Found";}
                            ?>
                            </ul>
                            <div class="card-header"><button type="submit" class="btn btn-primary btn-sm float-end">Search</button></div>
                        </form>
                    </div>  
               </div>
   <?php
                            if(isset($_GET['brands']))
                            {
                                $branchecked = [];
                                $branchecked = $_GET['brands'];
                                $limit = 4;
                                if (isset($_GET['page'])) {
                                 $page = $_GET['page'];
                                } else {
                                  $page = 1;
                                }
                              $offset = ($page - 1) * $limit;
                                foreach($branchecked as $rowbrand)
                                {
                                    // echo $rowbrand;
                                    $products = "SELECT * FROM products WHERE brand_id IN ($rowbrand)  LIMIT {$offset},{$limit} ";
                                    $products_run = mysqli_query($con, $products);
                                    if(mysqli_num_rows($products_run) > 0)
                                    {
                                        foreach($products_run as $fetch_products) :
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
                                        endforeach;
                                    }
                                }
                            }
                            else
                            {
                              $limit = 5;
                              if (isset($_GET['page'])) {
                               $page = $_GET['page'];
                              } else {
                                $page = 1;
                              }
                            $offset = ($page - 1) * $limit;
                      
                              $select_products = mysqli_query($conn, "SELECT * FROM `products`  LIMIT {$offset},{$limit}") or die('query failed');
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
      echo ' <li class="page-item"><a class="page-link" href="shop.php?page='.($page -1).'" >Prev</a></li>';
    }
    for ($i=1; $i < $total_page; $i++) { 
      if ($i == $page) {
          $active = "active";
      } else {
       $active = "";
      }
        echo '<li class="page-item "><a class="page-link '.$active.'" href="shop.php?page='.$i.'"  >'.$i.'</a></li>';
    }
    if ($total_page > $page) {
      echo '<li class="page-item"><a class="page-link" href="shop.php?page='.($page +1).'">Next</a></li>';
    }
    echo '</ul>';
    echo '</nav>';
}
   ?>
</div>               
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
