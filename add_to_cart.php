<?php 
include "api/config/database.php"; 

if(isset($_POST['value'])){
    $value = $_POST['value'];
    $id = $_POST['id'];
    
    if(!is_numeric($value) || $value <=0){
        $value = 1;
    }
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $cart){
            if($id == $cart['id']){
                $_SESSION['cart'][$id]['qty'] = $value;
                die($value);
            }
        }
    }

    die();

}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    if(mysqli_num_rows($sql) > 0){
        $data = mysqli_fetch_assoc($sql);
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['qty']++;
            header('Location: cart.php');
           
        }else{
            $_SESSION['cart'][$id] = [
                'id'=>$data['id'],
                'qty'=>$data['quantity']
            ];

            header('Location: cart.php');
        }
    }
 
}else if(isset($_GET['add'])){
    $id = $_GET['add'];
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $cart){
            if($id == $cart['id']){
                $_SESSION['cart'][$id]['qty']++;
                header('Location: cart.php');
            }
        }
    }

}else if(isset($_GET['subtract'])){
    $id = $_GET['subtract'];
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $cart){
            if($id == $cart['id']){
                if($_SESSION['cart'][$id]['qty'] > 1){
                    $_SESSION['cart'][$id]['qty']--;
                }

                header('Location: cart.php');

            }
        }
    }
    
}else if(isset($_GET['remove'])){
    $id = $_GET['remove'];
    
    if(isset($_SESSION['cart']) ){
        if(count($_SESSION['cart']) == 1){
            unset($_SESSION['cart']);
        }
        foreach($_SESSION['cart'] as $cart){
            if($id == $cart['id']){
                unset($_SESSION['cart'][$id]);
            }
        }

        header('Location: cart.php');

    }

}else{
    header('Location: shop.php');
   
}

?>