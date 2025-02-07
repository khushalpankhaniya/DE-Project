<div id="catagorybox">
                <form action="" method="GET">
                    <div class="card shadow mt-3">                 
                        <h6 class="title">catagory List</h6>
                        <div class="card-body">
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
                                            <div class="check-box">
                                                <input type="checkbox"  name="brands[]" id="check" value="<?= $brandlist['id']; ?>" 
                                                    <?php if(in_array($brandlist['id'], $checked)){ echo "checked"; } ?>
                                                 />
                                               <label for="check"> <?= $brandlist['name']; ?>    </label>                           
                                            </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo "No Brands Found";
                                }
                            ?>
                        <div class="card-header">
                                <h5>Filter </h5>
                                    <button type="submit" class="btn btn-primary btn-sm float-end">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>