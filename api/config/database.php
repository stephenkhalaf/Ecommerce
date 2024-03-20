<?php
session_start();
$conn = mysqli_connect('localhost','root','','eshop');
if(!$conn){
    die('could not connect to database');
}

?>