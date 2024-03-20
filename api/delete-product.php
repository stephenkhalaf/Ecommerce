<?php
include "./config/database.php";

if(isset($_GET['id']) && isset($_GET['image']) && isset($_GET['image2']) && isset($_GET['image3']) && isset($_GET['image4'])){
    $id = $_GET['id']; 
    $image_name = $_GET['image'];
    $image_name2 = $_GET['image2'];
    $image_name3 = $_GET['image3'];
    $image_name4 = $_GET['image4'];
    $sql = mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    if($sql){
        $_SESSION['delete'] = "Successfully deleted!";
        $path = "./assets/img/products/$image_name";
        $path2 = "./assets/img/products/$image_name2";
        $path3 = "./assets/img/products/$image_name3";
        $path4 = "./assets/img/products/$image_name4";
        unlink($path);
        unlink($path2);
        unlink($path3);
        unlink($path4);
        header('Location: ./products.php');
    }else{
        $_SESSION['delete'] = "An error occurred while deleting...";
        header('Location: ./products.php');
    }
}