<?php include "./partials/header.php" ?>

	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Shopping Cart</li>
				</ol>
			</div>

			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php 
						if(isset($_SESSION['cart'])){
							$ids = array_column($_SESSION['cart'], 'id');
							$ids_str = implode(',',$ids);
							$sql = mysqli_query($conn, "SELECT * FROM products WHERE id in ($ids_str)");
							$total = [];
							if(mysqli_num_rows($sql) >= 1){
								while($row = mysqli_fetch_assoc($sql)){

									foreach($_SESSION['cart'] as $cart){
										if($row['id'] == $cart['id']){
											$row['cart_qty'] = $cart['qty'];
											break;
										}
									}
									?>

						<tr>
							<td class="cart_product">
								<a href=""><img  src="api/assets/img/products/<?php echo $row['image'] ;?>" alt="" style="height: 100px; width:100px;object-fit:cover"></a>
							</td>
							<td class="cart_description">
								<h4><a href=""><?php echo $row['description'] ;?></a></h4>
								<p>Product ID: <?php echo $row['id'] ;?></p>
							</td>
							<td class="cart_price">
								<p>$<?php echo $row['price'] ;?></p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href="add_to_cart.php?add=<?php echo $row['id'] ;?>"> + </a>
									<input onchange="edit_quantity(this.value, this.id)" class="cart_quantity_input" id=<?php echo $row['id'] ;?> type="text" name="quantity" value="<?php echo $row['cart_qty'] ;?>" autocomplete="off" size="2">
									<a class="cart_quantity_down" href="add_to_cart.php?subtract=<?php echo $row['id'] ;?>"> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">$<?php $total[] = $row['cart_qty']  * $row['price']; echo number_format($row['cart_qty']  * $row['price'] ,2);?></p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="add_to_cart.php?remove=<?php echo $row['id'] ;?>"><i class="fa fa-times"></i></a>
							</td>
						</tr>

									<?php
								}
							}else{
								header('Location: shop.php');
							}

						}else{
							header('Location: shop.php');
						}
					
						
					?>
					</tbody>
				</table>
			</div>
			<div class="pull-right" style="font-size:20px">Sub Total: <strong>$ <?php echo isset($total) ?number_format(array_sum($total),2):0 ?> </strong> </div>
			<br><br><br>
			<div class="pull-left"><button class="btn btn-primary">< <a href="shop.php" style="color:white;">Back</a> </button></div>
			<div class="pull-right"><button class="btn btn-primary" ><a href="checkout.php" style="color:white;">Continue</a> ></button></div>
		</div>
		<br>
	</section> <!--/#cart_items-->

	<?php  
	if(isset($total)){
		$_SESSION['total'] = $total;
	}

	?>
	<script>
		function edit_quantity(value,id){
			const xhr = new XMLHttpRequest()
			xhr.open('POST', `add_to_cart.php`)   
			xhr.onreadystatechange = function(){
				if(xhr.status == 200 && xhr.readyState == 4){
					let result = xhr.responseText
					console.log(result)
					location.reload()

				}
			}
			let form = new FormData()
			form.append('value',value)
			form.append('id',id)
			xhr.send(form)
		}
	</script>

	<?php include "./partials/footer.php" ?>