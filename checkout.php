<?php  include "./partials/header.php";?>
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li ><a href="#">Home</a></li>
				  <li class="active">Check out</li>
				</ol>
			</div><!--/breadcrums-->


			<style>
				.form-control{
					margin:5px 0;
				}
			</style>

			<?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
			<div class="register-req">
				<p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
			</div><!--/register-req-->
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];  ?>">
				<div class="shopper-informations">
					<div class="row">
						<div class="col-sm-8 clearfix">
							<!-- <form action="" > -->
							<div class="bill-to">
								<p>Bill To</p>
								<div class="form-one">
									
										<input class="form-control" type="text" placeholder="Address 1 *" name="address1" required>
										<input class="form-control" type="text" placeholder="Address 2" name="address2">
										<input class="form-control" type="text" placeholder="Zip / Postal Code *" name="zip" required>
										<br>
										<select class="form-control" name="country" oninput="select_state(event)" required>
											<option>-- Country --</option>
											<?php

												$sql = mysqli_query($conn, "SELECT * FROM countries");

												while($row = mysqli_fetch_assoc($sql)){
													?>
													<option value="<?php echo $row['id']  ?>"><?php echo $row['country']  ?></option>

													<?php
												}

											?>
										</select><br><br>
										<select class="form-control" name="state" id="states" required>
										</select><br><br>
										<input class="form-control" type="text" placeholder="Phone *" name="phone" required>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="order-message">
								<p>Shipping Order</p>
								<textarea name="message"  placeholder="Notes about your order, Special Notes for Delivery" rows="16"></textarea>
								<label><input type="checkbox"> Shipping to bill address</label>
							</div>	
						</div>					
					</div>
				</div>
				<br>
				<div class="pull-right"><button class="btn btn-primary" type="submit" name="submit">Pay ></button></div>
			</form>
			<?php else: ?>
				<strong style="text-align:center;font-size:20px;margin:10px;display:block">No Items In Cart</strong>
			<?php endif; ?>
			<div class="pull-left"><button class="btn btn-primary" type="button">< <a href="cart.php" style="color:white;">Back To Cart</a> </button></div>
		</div>
	</section> <!--/#cart_items-->
<br>
	

<script>
	function select_state(e){
		const states = document.querySelector('#states')
		states.innerHTML = "<option>-- State / Province / Region --</option>"
		const xhr = new XMLHttpRequest()
		xhr.open('POST', 'ajax_country.php')
		xhr.onreadystatechange = function(){
			if(xhr.status==200 && xhr.readyState==4){
				let result = JSON.parse(xhr.responseText)
				let div = document.createElement('div')
				for(let item of result){
					let option = document.createElement('option')
					option.append(item[1])
					option.value = item[0]
					div.append(option)

				}
				states.innerHTML += div.innerHTML
			}
		}
		let form = new FormData()
		form.append('id', e.target.value)
		xhr.send(form)
	}
</script>

<?php
if(isset($_POST['submit'])){
	$user_id = $_SESSION['userid'];
	$total = $_SESSION['total'][0];
	$country = $_POST['country'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$tax = 0;
	$shipping = $_POST['message'];
	$delivery_address = $_POST['address1'] . " | " . $_POST['address2'];
	$phone = $_POST['phone'];
	$date = date('Y-m-d H:i:s');
	
	$sql2 = mysqli_query($conn, "SELECT country FROM countries WHERE id = $country");
	$country = mysqli_fetch_assoc($sql2)['country'];

	$sql3 = mysqli_query($conn, "SELECT state FROM states WHERE id = $state");
	$state = mysqli_fetch_assoc($sql3)['state'];



	
	$sql4 = mysqli_query($conn, "INSERT INTO orders (user_id,delivery_address,total,country,state,zip,tax,shipping,phone,date)
										 VALUES ($user_id, '$delivery_address',$total,'$country','$state','$zip',$tax,'$shipping','$phone', '$date')");
	

	if($sql4){
		if(isset($_SESSION['cart'])){
			$ids = array_column($_SESSION['cart'], 'id');
			$ids_str = implode(',',$ids);
			$sql5 = mysqli_query($conn, "SELECT * FROM products WHERE id in ($ids_str)");

			if(mysqli_num_rows($sql5) > 0){
				
				while($row = mysqli_fetch_assoc($sql5)){
					$order_id = $row['user_id'];
					$qty = $row['quantity'];
					$description = $row['description'];
					$amount = $row['price'];
					$total = $amount * $qty;
					$product_id = $row['id'];
					
					$sql6 = mysqli_query($conn, "INSERT INTO order_details (order_id, qty, description, amount, total, product_id) VALUES ($order_id,$qty,'$description',$amount,$total,$product_id)");
				}
			}
			
			}

		unset($_SESSION['cart']);
		unset($_SESSION['total']);
		header('Location: ./index.php');
	}else{
		header('Location: '.$_SERVER['PHP_SELF']);
	}
}

?>
<?php include "./partials/footer.php"  ?>
