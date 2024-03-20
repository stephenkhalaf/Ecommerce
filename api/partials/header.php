
<?php
include "./config/database.php";
ob_start();

if(isset($_SESSION['userid'])){
	$sql = mysqli_query($conn, "SELECT * FROM users WHERE user_id = ".$_SESSION['userid']. " && rank = 'admin'");
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_assoc($sql);
	}else{
        header('location: ../index.php');
    }

}else{
    header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simple Responsive Admin</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
     
           
          
    <div id="wrapper">
         <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="adjust-nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../index.php">
                        <img src="assets/img/logo.png" />

                    </a>
                    
                </div>
              
                <span class="logout-spn" >
                  <a href="../logout.php" style="color:#fff;">LOGOUT</a>  

                </span>
            </div>
        </div>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                 


                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/eshop/api/index.php') ? 'active-link ':''  ?>">
                        <a href="index.php" ><i class="fa fa-desktop "></i>Dashboard <span class="badge">Included</span></a>
                    </li>

                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/eshop/api/products.php') ? 'active-link ':''  ?>">
                        <a href="products.php" ><i class="fa fa-table "></i>Products</a>
                    </li>

                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/eshop/api/add-products.php') ? 'active-link ':''  ?>">
                        <a href="add-products.php" ><i class="fa fa-edit "></i>Add Products</a>
                    </li>

                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/eshop/api/categories.php') ? 'active-link ':''  ?>">
                        <a href="categories.php" ><i class="fa fa-table "></i>Categories</a>
                    </li>

                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/eshop/api/add-categories.php') ? 'active-link ':''  ?>">
                        <a href="add-categories.php" ><i class="fa fa-edit "></i>Add Categories</a>
                    </li>

                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/eshop/api/orders.php') ? 'active-link ':''  ?>">
                        <a href="orders.php" ><i class="fa fa-list "></i>Orders</a>
                    </li>

                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/eshop/api/users.php') ? 'active-link ':''  ?>">
                        <a href="users.php" ><i class="fa fa-user"></i>Users</a>
                    </li>

                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/eshop/api/settings.php') ? 'active-link ':''  ?>">
                        <a href="settings.php" ><i class="fa fa-cogs"></i>Settings</a>
                    </li>

                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/eshop/api/backup.php') ? 'active-link ':''  ?>">
                        <a href="backup.php" ><i class="fa fa-hdd-o"></i>Website Backup</a>
                    </li>
                   

                    <li>
                        <a href="ui.html"><i class="fa fa-table "></i>UI Elements  <span class="badge">Included</span></a>
                    </li>
                    
                    
                </ul>
                            </div>

        </nav>
        <!-- /. NAV SIDE  -->