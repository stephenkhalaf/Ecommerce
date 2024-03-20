<?php  include "./api/config/database.php"; ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
		

	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<?php
						if(isset($_SESSION['signup-success'])){
							?>

							<h2 style="color: green"><strong><?php echo $_SESSION['signup-success']; unset($_SESSION['signup-success']); ?></strong></h2>

							<?php
						}

						?>


						<?php
						if(isset($_SESSION['login-error'])){
							?>

							<h2 style="color: red"><strong><?php echo $_SESSION['login-error']; unset($_SESSION['login-error']); ?></strong></h2>

							<?php
						}

						?>
						<h2>Login to your account</h2>
						<form action="<?php echo $_SERVER['PHP_SELF']  ?>" method="POST">
							<input type="email" placeholder="Email Address"  value = "<?php echo isset($_POST['email']) ? $_POST['email']:''; ?>" name="email"/>
							<input type="password" placeholder="password" name="password">
							<span>
								<input type="checkbox" class="checkbox"> 
								Keep me signed in
							</span>
							<button type="submit" class="btn btn-default" name="login">Login</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
					<?php
						if(isset($_SESSION['signup-error'])){
							$errors = $_SESSION['signup-error'];
							echo "<ul>";
							foreach($errors as $error=>$err){
								
					?>
						<li style="color: red; font-size:20px"><strong><?php echo $err;  ?></strong></li>
					<?php
							}
							echo "</ul>";
							unset($_SESSION['signup-error']);
						}

					?>
						<h2>New User Signup!</h2>
						<form action="<?php echo $_SERVER['PHP_SELF']  ?>" method="POST">
							<input type="text" placeholder="Name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name']:''; ?>"/>
							<input type="email" placeholder="Email Address"  value="<?php echo isset($_POST['email']) ? $_POST['email']:''; ?>" name="email"/>
							<input type="password" placeholder="Password" name="password"/>
							<input type="password" placeholder="confirm Password" name="password2"/>
							<button type="submit" class="btn btn-default" name="signup">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
	
	<?php
		if(isset($_POST['signup'])){
			$error = [];
			$name = mysqli_real_escape_string($conn,$_POST['name']);
			$email = mysqli_real_escape_string($conn,$_POST['email']);
			$password = mysqli_real_escape_string($conn,$_POST['password']);
			$password2 = mysqli_real_escape_string($conn,$_POST['password2']);
			

			if(empty($name)){
				$error['name'] = 'Incorrect Name';
			}

			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error['email'] = 'Invalid Email';
			}

			if(($password != $password2) || (strlen($password) < 6) || empty($password)){
				$error['password'] = 'Password must be atleast 6 characters long and muct match';
			}

			$sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
			if(mysqli_num_rows($sql) > 0){
				$error['signup'] = 'This User Already Exists';
			}

			if(count($error) == 0){
				$rank = 'customer';
				$userid = time();
				$date = date("Y-m-d H:i:s");
				$password_hash = md5($password);
				$sql2 = mysqli_query($conn, "INSERT INTO users (user_id,name,email,password,rank,date) VALUES ($userid,'$name','$email','$password_hash','$rank','$date')");

				if($sql2){
					$_SESSION['signup-success'] = 'You have successfully signed up';
					header('Location: login.php');
				}else{
					header('Location: '.$_SERVER['PHP_SELF']);
				}

			}else{
				$_SESSION['signup-error'] = $error;
			}

			
		}


		if(isset($_POST['login'])){
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$password_hash = md5($password);
			
			$sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' && password = '$password_hash'");
			
			if(mysqli_num_rows($sql3) == 1){
				$data = mysqli_fetch_assoc($sql3);
				$_SESSION['userid'] = $data['user_id'];
				$_SESSION['login-success'] = $email;
				header('Location: index.php');
			}else{
				$_SESSION['login-error'] = 'Incorrect email/password';
				
			}
	

		}


	?>

<?php include "./partials/footer.php" ?>




	


