<?php 
include "error.php";
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Products</title>
	<link href="style.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="./Bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="header">
		<h1 id="logo">Logo</h1>
		<nav>
			<ul id="menu">
				<li><a href="#">Home</a></li>
				<li><a href="#">Products</a></li>
				<li><a href="#">Contact</a></li>
			</ul>
		</nav>
	</div>
	<div id="main">
		<div id="products">
			<div id="product-101" class="product">
				<img src="images/football.png">
				<h3 class="title"><a href="#">Product 101</a></h3>
				<span>Price: $150.00</span>
				<a class="add-to-cart" href="#" data-id="product-101" data-name="Product 101" data-img="images/football.png" data-price="150" data-action="addToCart">Add To Cart</a>
			</div>
			<div id="product-102" class="product">
				<img src="images/tennis.png">
				<h3 class="title"><a href="#">Product 102</a></h3>
				<span>Price: $120.00</span>
				<a class="add-to-cart" href="#" data-id="product-102" data-name="Product 102" data-img="images/tennis.png" data-price="120" data-action="addToCart">Add To Cart</a>
			</div>
			<div id="product-103" class="product">
				<img src="images/basketball.png">
				<h3 class="title"><a href="#">Product 103</a></h3>
				<span>Price: $90.00</span>
				<a class="add-to-cart" href="#" data-id="product-103" data-name="Product 103" data-img="images/basketball.png" data-price="90" data-action="addToCart">Add To Cart</a>
			</div>
			<div id="product-104" class="product">
				<img src="images/table-tennis.png">
				<h3 class="title"><a href="#">Product 104</a></h3>
				<span>Price: $110.00</span>
				<a class="add-to-cart" href="#" data-id="product-104" data-name="Product 104" data-img="images/table-tennis.png" data-price="110" data-action="addToCart">Add To Cart</a>
			</div>
			<div id="product-105" class="product">
				<img src="images/soccer.png">
				<h3 class="title"><a href="#">Product 105</a></h3>
				<span>Price: $80.00</span>
				<a class="add-to-cart" href="#" data-id="product-105" data-name="Product 105" data-img="images/soccer.png" data-price="80" data-action="addToCart">Add To Cart</a>
			</div>
		</div>
	</div>

	<?php
	if (isset($_POST) && isset($_POST['product_id']) && isset($_POST['action']) && $_POST['action'] == 'addToCart') {
		if (isset($_SESSION[$_POST['product_id']]) || $_SESSION[$_POST['product_price']]) {
			$qty = $_SESSION[$_POST['product_id']]["qty"] = (int)$_SESSION[$_POST['product_id']]["qty"] + 1;
			$_SESSION[$_POST['product_id']]["sub_total"] = (int)$_POST['product_price'] * $qty;
		} else {
			$_SESSION[$_POST['product_id']] = [
				'product_id' => $_POST['product_id'],
				"product_name" => $_POST['product_name'],
				"product_price" => $_POST['product_price'],
				"product_image" => $_POST['product_image'],
				"qty" => 1,
				"sub_total" => (int)$_POST['product_price'] 
			];
		}
	} elseif (isset($_POST) && isset($_POST['product_id']) && isset($_POST['action']) && $_POST['action'] == 'incQty') {
		$qty = $_SESSION[$_POST['product_id']]["qty"] = (int)$_SESSION[$_POST['product_id']]["qty"] + 1;	
		$_SESSION[$_POST['product_id']]["sub_total"] = (int)$_POST['product_price'] * $qty;	
	} elseif (isset($_POST) && isset($_POST['product_id']) && isset($_POST['action']) && $_POST['action'] == 'decQty') {
		$qty = $_SESSION[$_POST['product_id']]["qty"] = (int)$_SESSION[$_POST['product_id']]["qty"] - 1;	
		if ($qty <= 0) {
			unset($_SESSION[$_POST['product_id']]);
		} else {
			$_SESSION[$_POST['product_id']]["sub_total"] = (int)$_POST['product_price'] * $qty;	
		}
	}
	?>
	<h1 class="text-center mt-4">Shopping Cart</h1>
	<table id="mytable1" class="table table-striped text-center p-5 mt-5" style="width:60vw; margin-left:auto; margin-right:auto;">
		<tr>
			<th>Product Id</th>
			<th>Product Name</th>
			<th>Product Price</th>
			<th>Product Image</th>
			<th>Quantity</th>
			<th>Sub Total</th>
		</tr>
		<?php if (isset($_SESSION) && is_array($_SESSION)) { 
			foreach ($_SESSION as $key => $values) { ?>
				<tr>
					<td><?php echo $values['product_id']; ?></td>
					<td><?php echo $values['product_name']; ?></td>
					<td><?php echo "$ ". $values['product_price']; ?></td>
					<td><img style="height:60px; width:60px;" src="<?php echo $values['product_image']; ?>" alt=""></td>
					<td><?php echo '<a href="" class="add-to-cart" style="font-size:15px;" data-id="'.$values['product_id'].'" data-price="'.$values['product_price'].'" data-action="incQty"> + &nbsp&nbsp&nbsp</a>'. $values['qty'] . '<a href="" class="add-to-cart" style="font-size:15px; text-decoration: none;" data-id="'.$values['product_id'].'" data-price="'.$values['product_price'].'" data-action="decQty">&nbsp&nbsp&nbsp-</a>'; ?></td>
					<td><?php echo "$ ". $values['sub_total']; ?></td>
				</tr>
		<?php }
		 	$sum = 0;
			foreach ($_SESSION as $key => $dataval) {
			$sum += $dataval['sub_total']; ?>
		<?php }} ?>
	</table>
	<p class="text-center pt-2" style="color:#103874e0; font-size:16px;"><?php echo "Total Cart Value is : "."$ ". $sum; ?></p>
	<div id="footer">
		<nav>
			<ul id="footer-links">
				<li ><a href="#" class="text-center mt-5">Privacy</a></li>
				<li><a href="#" class="text-center mt-5">Desclaimers</a></li>
			</ul>
		</nav>
	</div>
	<script src="jquery-3.4.1.min.js"></script>
	<script src="main.js"></script>
</body>
</html>