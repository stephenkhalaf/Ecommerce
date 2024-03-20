<?php
include "api/config/database.php";
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $sql = mysqli_query($conn,"SELECT id,state FROM states WHERE parent = $id");
    $states = mysqli_fetch_all($sql);
    echo json_encode($states);
}

?>