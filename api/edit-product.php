<?php include "partials/header.php"; ?>
<div id="page-wrapper" >
<div id="page-inner">
<div class="row">
    <div class="col-md-12">
        <h2> Update Product</h2>
        <div class="bg-danger text-center font-size-20" >
        <?php
            if(isset($_SESSION['update-error'])){
                echo $_SESSION['update-error'];
                unset($_SESSION['update-error']);
            }

        ?>

        </div>
        <?php
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
            if(mysqli_num_rows($sql) == 1){
                $product = mysqli_fetch_assoc($sql);
            
            }
        }

        ?>
    <br>
    </div>
</div>
<section>
    <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$product['id'];?>" method="POST" enctype="multipart/form-data">
        <input maxlength="20" type="text" value="<?php echo $product['description'] ; ?>" class="form-control"  name="description"/><br>
        <select name="category" id="" class="form-control">
                <?php
                    $sql = mysqli_query($conn, "SELECT * FROM categories");
                    if(mysqli_num_rows($sql)>0){
                        while($row=mysqli_fetch_assoc($sql)){  ?>
                        <option value="<?php echo $row['id'] ?>"><?php echo $row['category'] ?></option>
                <?php }}else{  ?>
                    <option value="0">No Category</option>
                <?php  }?>
            </select><br>
        <input type="number" value="<?php echo $product['price'] ; ?>" class="form-control"  name="price" max="100"/><br>
        <input type="number" value="<?php echo $product['quantity'] ; ?>" class="form-control"  name="quantity" min="1" max="10"/><br>
        <label for="">Old Image</label><br>
        <img src="./assets/img/products/<?php echo $product['image']; ?>" alt="" width="100" height="100"><br><br>
        <label for="">New Image</label><br>
        <input type="file" name="new_image"><br>

        <label for="">New Image2</label><br>
        <input type="file" name="new_image2"><br>

        <label for="">New Image3</label><br>
        <input type="file" name="new_image3"><br>

        <label for="">New Image4</label><br>
        <input type="file" name="new_image4"><br>

        <input type="submit" name="submit" value="Update Product" class="btn btn-primary">
    </form>
</section>

</div>
</div>


<?php
 
if(isset($_POST['submit'])){
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $old_image = $product['image'];
    $old_image2 = $product['image2'];
    $old_image3 = $product['image3'];
    $old_image4 = $product['image4'];
    $img_name = $old_image;
    $img_name2 = $old_image2;
    $img_name3 = $old_image3;
    $img_name4 = $old_image4;
    if(isset($_FILES['new_image']['name'])){
        $new_image = $_FILES['new_image']['name'];
        $new_image = time().$new_image;
        if(!move_uploaded_file($_FILES['new_image']['tmp_name'],"./assets/img/products/$new_image" )){
            $img_name = $old_image;
            $_SESSION['update-error'] = 'No image is uploaded';
            header('Location:'.$_SERVER['PHP_SELF']."?id=".$product['id']);
        }else{
            $image_path = "./assets/img/products/$old_image";
            unlink($image_path);
            $img_name = $new_image;
        }
   }

   if(isset($_FILES['new_image2']['name'])){
    $new_image2 = $_FILES['new_image2']['name'];
    $new_image2 = time().$new_image2;
    if(!move_uploaded_file($_FILES['new_image2']['tmp_name'],"./assets/img/products/$new_image2" )){
        $img_name2 = $old_image2;
        $_SESSION['update-error'] = 'No image is uploaded';
        header('Location:'.$_SERVER['PHP_SELF']."?id=".$product['id']);
    }else{
        $image_path = "./assets/img/products/$old_image2";
        unlink($image_path);
        $img_name2 = $new_image2;
    }
}

if(isset($_FILES['new_image3']['name'])){
    $new_image3 = $_FILES['new_image3']['name'];
    $new_image3 = time().$new_image3;
    if(!move_uploaded_file($_FILES['new_image3']['tmp_name'],"./assets/img/products/$new_image3" )){
        $img_name3 = $old_image3;
        $_SESSION['update-error'] = 'No image is uploaded';
        header('Location:'.$_SERVER['PHP_SELF']."?id=".$product['id']);
    }else{
        $image_path = "./assets/img/products/$old_image3";
        unlink($image_path);
        $img_name3 = $new_image3;
    }
}

if(isset($_FILES['new_image4']['name'])){
    $new_image4 = $_FILES['new_image4']['name'];
    $new_image4 = time().$new_image4;
    if(!move_uploaded_file($_FILES['new_image4']['tmp_name'],"./assets/img/products/$new_image4" )){
        $img_name4 = $old_image4;
        $_SESSION['update-error'] = 'No image is uploaded';
        header('Location:'.$_SERVER['PHP_SELF']."?id=".$product['id']);
    }else{
        $image_path = "./assets/img/products/$old_image4";
        unlink($image_path);
        $img_name4 = $new_image4;
    }
}

   $sql = mysqli_query($conn, "UPDATE products SET description = '$description', category=$category,price = $price,quantity=$quantity,image='$img_name',image2='$img_name2',image3='$img_name3',image4='$img_name4' WHERE id =". $_GET['id']);
   if($sql){
    $_SESSION['update'] = "$description updated successfully";
    header('Location: ./products.php');
   }else{
    $_SESSION['update-error'] = 'An error occurred';
    header('Location: '.$_SERVER['PHP_SELF']."?id=".$product['id']);
   }
}

?>

<?php include "partials/footer.php"; ?>
