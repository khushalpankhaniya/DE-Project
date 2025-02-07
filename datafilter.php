<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funda of Web IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>How to Filter or Find or Search data using Multiple Checkbox in php</h4>
                    </div>
                </div>
            </div>

            <!-- Brand List  -->
            <div class="col-md-3">
                <form action="" method="GET">
                    <div class="card shadow mt-3">
                        <div class="card-header">
                            <h5>Filter 
                                <button type="submit" class="btn btn-primary btn-sm float-end">Search</button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6>Brand List</h6>
                            <hr>
                            <?php
                                $con = mysqli_connect("localhost","root","","shop_db");

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
                                            <div>
                                                <input type="checkbox" name="brands[]" value="<?= $brandlist['id']; ?>" 
                                                    <?php if(in_array($brandlist['id'], $checked)){ echo "checked"; } ?>
                                                 />
                                                <?= $brandlist['name']; ?>
                                            </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo "No Brands Found";
                                }
                            ?>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Brand Items - Products -->
            <div class="col-md-9 mt-3">
                <div class="card ">
                    <div class="card-body row">
                        <?php
                            if(isset($_GET['brands']))
                            {
                                $branchecked = [];
                                $branchecked = $_GET['brands'];
                                foreach($branchecked as $rowbrand)
                                {
                                    // echo $rowbrand;
                                    $products = "SELECT * FROM products WHERE brand_id IN ($rowbrand)";
                                    $products_run = mysqli_query($con, $products);
                                    if(mysqli_num_rows($products_run) > 0)
                                    {
                                        foreach($products_run as $fetch_products) :
                                            ?>
                                                <form action="" method="post" class="box">
                                                 <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
      <!-- <input type="number" min="1" name="product_quantity" value="1" class="qty"> -->
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
                                $products = "SELECT * FROM product";
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
                                else
                                {
                                    echo "No Items Found";
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>