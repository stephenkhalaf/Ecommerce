<?php include "partials/header.php" ?>

<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <div style="color: red; font-size:20px; text-align:center;">
                            <?php
                                if(isset($_SESSION['category-failure'])){
                                    echo $_SESSION['category-failure'];
                                    unset($_SESSION['category-failure']);
                                }

                            ?>
                        </div>
                     <h2>Add Categories</h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />

                  <section>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                            <input type="text" class="form-control" placeholder="category name" name="category" value="<?php echo isset($_POST['category'])? $_POST['category']:''; ?>"/><br>
                            <label for="parent">Parent(optional)</label>
                            <select name="parent" id="parent" class="form-control">
                                <option value="0">Select a parent category</option>
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
    
                            <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                        </form>
                    </section>
                
                </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->


         <?php
            if(isset($_POST['submit'])){
                $category = mysqli_real_escape_string($conn, $_POST['category']);
                $parent = mysqli_real_escape_string($conn, $_POST['parent']);
                if(!empty($category)){
                    $sql = mysqli_query($conn, "INSERT INTO categories (category,parent) VALUES ('$category',$parent)");
                    if($sql){
                        $_SESSION['category-success'] = "$category add successfully";
                        header('Location: categories.php');
                    }else{
                        $_SESSION['category-failure'] = "An error ocurred";
                    }

                }else{
                    $_SESSION['category-failure'] = "Please enter a category";
                    header('Location: '.$_SERVER['PHP_SELF']);
                }
            }


        ?>


<?php include "partials/footer.php" ?>