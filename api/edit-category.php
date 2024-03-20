

<?php

if(isset($_POST['id'])){
    include "config/database.php";
    $id = json_decode($_POST['id']);
    $sql = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id ");
    $data = mysqli_fetch_assoc($sql);
    if($data['disabled'] == 0){
        $sql2 = mysqli_query($conn, "UPDATE categories SET disabled = 1 WHERE id = $id");
        echo 0;
    }else{
        $sql3 = mysqli_query($conn, "UPDATE categories SET disabled = 0 WHERE id = $id");
        echo 1;
    }
    die;
}




?>

<?php
include "partials/header.php";
?>

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">
                <h2>Edit Categories</h2>   
            </div>
        </div>              
            <!-- /. ROW  -->
            <hr />


            <?php

                if(isset($_GET['id'])){
                    $id = json_decode($_GET['id']);
                    $sql = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id ");
                    $category = mysqli_fetch_assoc($sql);

                    if(isset($_POST['submit'])){
                        $id = json_decode($_GET['id']);
                        $new_category = $_POST['category'];
                        $parent = mysqli_real_escape_string($conn, $_POST['parent']);
                        $sql = mysqli_query($conn, "UPDATE categories SET category = '$new_category', parent = '$parent' WHERE id = $id");

                        if($sql){
                            $_SESSION['update-success'] = "$new_category is added";
                            header('Location: categories.php');
                        }else{
                            header('Location: categories.php?id='.$id);
                        }
                    }
                }



            ?>


            <form action="<?php echo $_SERVER['PHP_SELF']  ?>?id=<?php echo $id ?>" method="post">

                <input type="text" class="form-control" value = "<?php echo isset($category['category'])?$category['category']:''  ?>" name="category"/><br>
                <label for="parent">Parent(optional)</label>
                <select name="parent" id="parent" class="form-control">
                    <option value="0"></option>
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
                <input type="submit" value="Update Category" class="btn btn-primary" name="submit">
            </form>


   
    </div>
             <!-- /. PAGE INNER  -->
</div>
         <!-- /. PAGE WRAPPER  -->




<?php include "partials/footer.php"; ?>