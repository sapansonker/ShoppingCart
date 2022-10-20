<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		Products
	</title>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
	<script>
		$(document).ready(function(){

			$('.add-to-cart').on('click',function(){
				var product_id = $(this).attr('data-id');
				var product_title = $(this).attr('data-title');
				var product_price = $(this).attr('data-price');
				var product_image = $(this).attr('data-image');
	
				$.ajax('/shahbaz/html/cart.php',{
					type : 'POST',
					data : {
						action:'add_to_cart',
						product_id:product_id,
						product_title:product_title,
						product_price:product_price,
						product_image:product_image
					},	    
					//dataType : 'json',
					success : function(response,status,xhr){
						createCartTable(response);
					}	
				});
			});
			$('#div1').on('click','.quantity_decrement',function(){
				var product_id = $(this).attr('data-productId');
				$.ajax('/shahbaz/html/cart.php',{
					type : 'POST',
					data : {
						action:'quantity_decrement',
						product_id:product_id
					},	    
					//dataType : 'json',
					success : function(response,status,xhr){
						createCartTable(response);
					}	
				});
			});
			// Table Created After server Response
			function createCartTable(response){
				var table = '<table border="3"><tr><td><b>Id</b></td><td><b>Image</b></td><td><b>Name<b></td><td><b>Price<b></td><td><b>Quantity<b></td><td><b>Total Price<b></td><td><b>Remove<b></td></tr>';
				var grandTotal=0.00;
				$.each(JSON.parse(response),function(key,value){
					table+='<tr>';
					table+='<td>'+value.id+'</td>';
					table+='<td><img src="images/'+value.image+'" height=40px width=40px>'+'</td>';
					table+='<td>'+value.name+'</td>';
					table+='<td>$'+value.price+'</td>';
					table+='<td>'+value.quantity+'</td>';
					table+='<td>$'+value.quantity*parseInt(value.price)+'</td>';
					table+='<td style="text-align:center;"><button class="quantity_decrement" data-productId="'+value.id+'"><b>X<b></button></td>';
					grandTotal+=value.quantity*parseInt(value.price);
					table+='</tr>';
				});
				table+='<tr><td colspan="5"><b>Grand Total : <b></td><td colspan="2"><b>$'+grandTotal+'</b></td></tr>';
				table += '</table>';
				$('#div1').html(table); 
				
			}
		});
	</script>
	<link href="style.css" type="text/css" rel="stylesheet">
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
	<!-- Array Created Manually -->
	<?php 
	$products = array(
		array("id"=>"101","price"=>"150.00","title"=>"Product 101","pic"=>"football.png"),
		array("id"=>"102","price"=>"120.00","title"=>"Product 102","pic"=>"tennis.png"),
		array("id"=>"103","price"=>"90.00","title"=>"Product 103","pic"=>"basketball.png"),
		array("id"=>"104","price"=>"10.00","title"=>"Product 104","pic"=>"table-tennis.png"),
		array("id"=>"105","price"=>"80.00","title"=>"Product 105","pic"=>"soccer.png")						
	);
	echo "<pre>";print_r($products);
	?>
	<div id="main">
		<div id="products">
			<?php 
			foreach ($products as $key => $product_value) {
				?>
				<div id="<?php echo $product_value['id']; ?>" class="product">
					<img src="images/<?php echo $product_value['pic']; ?>">
					<h3 class="title"><?php echo $product_value['title']; ?></h3>
					<span>Price: $<?php echo $product_value['price']; ?></span>
					<a class="add-to-cart" href="javascript:void(0);" data-id="<?php echo $product_value['id']; ?>" data-title="<?php echo $product_value['title']; ?>" data-price="<?php echo $product_value['price']; ?>" data-image="<?php echo $product_value['pic']; ?>">Add To Cart</a>
				</div>
				<?php 
			}
			?>
		</div>
	</div>
	<!-- Table Created after Refreshing the Page -->
	<div id='div1' allign="center">
	<?php 
	
	if(isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])){ 
		$grandTotal = 0.00;
	?>
	<table id="div1"  allign = "center">
		<thead>
			<tr>
				<td><b>Id</b></td>
				<td><b>Image</b></td>
				<td><b>Name<b></td>
				<td><b>Price<b></td>
				<td><b>Quantity<b></td>
				<td><b>Total Price<b></td>
				<td><b>Remove<b></td>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach (($_SESSION['cart']) as $key => $value) { 
		?>
		<tr>
			<td><?php echo $value['id']; ?></td>
			<td><img src="images/<?php echo $value['image']; ?>"height=40px width=40px></td>
			<td><?php echo $value['name']; ?></td>
			<td><?php echo $value['price']; ?></td>
			<td><?php echo $value['quantity']; ?></td>
			<td>$<?php echo $value['quantity']*(int)$value['price']; ?></td>
			<td style="text-align:center;"><button class="quantity_decrement" data-productId="<?php echo $value['id']; ?>"><b>X<b></button></td>
		</tr>
		<?php
		$grandTotal+=$value['quantity']*(int)$value['price'];
		
		}
		?>
		<tr><td colspan="5"><b>Grand Total : </b></td><td colspan="2"><b>$<?php echo $grandTotal;?></b></td></tr>
		<?php
		}
		?>
		</tbody>
	</table>
	</div>
	<!-- <table id="" class="cartTable" style="width:60vw; margin-left:auto; margin-right:auto;">
		<thead>
			<th>Id</th>
			<th>Image</th>
			<th>Name</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total Price</th>
		</thead>
		<tbody>
			<tr>
				<td></td>
			</tr>
		</tbody>
	</table> -->
	<div id="footer">
		<nav>
			<ul id="footer-links">
				<li><a href="#">Privacy</a></li>
				<li><a href="#">Declaimers</a></li>
			</ul>
		</nav>
	</div>
</body>
</html>
