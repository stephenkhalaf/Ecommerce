<?php include "partials/header.php" ?>

<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>Products</h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />

                  <div style="color: green; font-size:20px; text-align:center;">
                            <?php
                                if(isset($_SESSION['delete'])){
                                    echo $_SESSION['delete'];
                                    unset($_SESSION['delete']);
                                }

                                if(isset($_SESSION['update'])){
                                    echo $_SESSION['update'];
                                    unset($_SESSION['update']);
                                }


                            ?>
                    </div>
                  <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Image</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($conn, "SELECT * FROM products");
                                if(mysqli_num_rows($sql) > 0){
                                    $id = 1;
                                    while($row = mysqli_fetch_assoc($sql)){
                                        ?>

                                    <tr style="text-align: center;">
                                        <td><?php echo $id++; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td><?php
                                            $sql2 = mysqli_query($conn, "SELECT category FROM categories WHERE id =". $row['category']);
                                            $cat = mysqli_fetch_assoc($sql2);
                                            echo $cat['category'];
                                        ?>
                                        </td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><img src="./assets/img/products/<?php echo $row['image'];  ?>" alt="" style="width:100px;height:100px;object-fit:cover"></td>
                                        <td><?php echo date('jS M Y', strtotime($row['date'])); ?></td>
                                        <td>
                                            <a href="edit-product.php?id=<?php echo $row['id']; ?>"><button class="btn btn-success">Edit</button></a>
                                            <a href="delete-product.php?id=<?php 
                                                echo $row['id']; ?>&&image=<?php echo $row['image']; ?>&&image2=<?php echo $row['image2']; ?>&&image3=<?php echo $row['image3']; ?>&&image4=<?php echo $row['image4']; ?>">
                                                <button class="btn btn-warning">Delete</button>
                                            </a> 
                                        </td>
                                    </tr>

                                        <?php
                                    }
                                }

                                ?>
                                
                            </tbody>
                    </table>
                
                </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->


<?php include "partials/footer.php" ?>