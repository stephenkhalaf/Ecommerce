<?php include "partials/header.php" ?>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>Add Products</h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />

                  <section>

                  <div style="color: red; font-size:20px; text-align:center;">
                            <?php
                                if(isset($_SESSION['products-error'])){
                                    echo $_SESSION['products-error'];
                                    unset($_SESSION['products-error']);
                                }

                            ?>
                    </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                            <input type="text" maxlength="20" class="form-control" placeholder="product description" name="description"  required/><br>
                            <select name="category" id="" class="form-control">
                                <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM categories WHERE disabled = 1");
                                    if(mysqli_num_rows($sql) > 0){
                                        while($row=mysqli_fetch_assoc($sql)){
                                    ?>
                                        <option value="<?php echo $row['id'];  ?>"><?php echo $row['category'];  ?></option>
                                    <?php
                                        }
                                    }
                                ?>
                            </select><br>
                            <input type="number" name="price" class="form-control" placeholder="price" min="0.00"  max="100" required><br>
                            <input type="number" name="quantity" class="form-control" placeholder="quantity" min="1" max='10' required><br>
                            <input type="file" name="image"><br>
                            <input type="file" name="image2"><br>
                            <input type="file" name="image3"><br>
                            <input type="file" name="image4"><br>
                            <input type="submit" name="submit" value="Add Products" class="btn btn-primary">
                        </form>
                    </section>
                
                </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->

         <?php
            if(isset($_POST['submit'])){
                $userid = $_SESSION['userid'];
                $description = mysqli_real_escape_string($conn,$_POST['description']);
                $price = mysqli_real_escape_string($conn,$_POST['price']);
                $category = mysqli_real_escape_string($conn,$_POST['category']);
                $quantity = mysqli_real_escape_string($conn,$_POST['quantity']);
                $img_name = 'logo.png';
                if(isset($_FILES['image']['name'])){
                    $img_name = time().$_FILES['image']['name'];
            
                    if(!move_uploaded_file($_FILES['image']['tmp_name'], "./assets/img/products/$img_name")){
                        $_SESSION['upload-error'] = 'The image couldn\'t be uploaded';
                        header('Location: '.$_SERVER['PHP_SELF']);
                        $img_name = 'logo.png';
                    }
            
                }

                if(isset($_FILES['image2']['name'])){
                    $img_name2 = time().$_FILES['image2']['name'];
            
                    if(!move_uploaded_file($_FILES['image2']['tmp_name'], "./assets/img/products/$img_name2")){
                        $_SESSION['upload-error'] = 'The image couldn\'t be uploaded';
                        header('Location: '.$_SERVER['PHP_SELF']);
                        $img_name2 =null;
                    }
            
                }

                if(isset($_FILES['image3']['name'])){
                    $img_name3 = time().$_FILES['image3']['name'];
            
                    if(!move_uploaded_file($_FILES['image3']['tmp_name'], "./assets/img/products/$img_name3")){
                        $_SESSION['upload-error'] = 'The image couldn\'t be uploaded';
                        header('Location: '.$_SERVER['PHP_SELF']);
                        $img_name3 = null;
                    }
            
                }

                if(isset($_FILES['image4']['name'])){
                    $img_name4 = time().$_FILES['image4']['name'];
            
                    if(!move_uploaded_file($_FILES['image4']['tmp_name'], "./assets/img/products/$img_name4")){
                        $_SESSION['upload-error'] = 'The image couldn\'t be uploaded';
                        header('Location: '.$_SERVER['PHP_SELF']);
                        $img_name4 = null;
                    }
            
                }
                $date = date("Y-m-d H:i:s");
                $slag = str_replace(" ", "-", "$description ".time());
                $sql = mysqli_query($conn, "INSERT INTO products (user_id,description,category,price,quantity,image,image2,image3,image4,date,slag) VALUES ($userid,'$description',$category,$price,$quantity,'$img_name', '$img_name2','$img_name3','$img_name4','$date','$slag')");
                if($sql){

                    $_SESSION['products-success'] = "$description is added successfully";
                    header('Location: ./products.php');
                }else{
                    $_SESSION['products-error'] = 'An error occurred';
                    header('Location: '.$_SERVER['PHP_SELF']);
                }

               
            }


        ?>


<?php include "partials/footer.php" ?>