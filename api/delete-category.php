<?php
include "./config/database.php";

if(isset($_GET['id'])){
    $id =$_GET['id']; 
    $sql = mysqli_query($conn, "DELETE FROM categories WHERE id ='$id'");
    if($sql){
        $_SESSION['delete-success'] = "Successfully deleted!";
        header('Location: ./categories.php');
    }else{
        $_SESSION['delete-error'] = "An error occurred while deleting...";
        header('Location: ./categories.php');
    }
}