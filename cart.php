<?php 
session_start(); 

$product_id = isset($_POST['product_id']) ? $_POST['product_id']:0;
$product_title = isset($_POST['product_title']) ? $_POST['product_title']:null;
$product_price = isset($_POST['product_price']) ? $_POST['product_price']:0.00;
$product_image = isset($_POST['product_image']) ? $_POST['product_image']:"";
$action = isset($_POST['action']) ? $_POST['action']:null;
$cart = isset($_SESSION['cart']) ? $_SESSION['cart']:array();

switch ($action) {
	case 'add_to_cart':
	addToCart($product_id,$product_title,$product_price,$product_image,$cart);
	break;
	case 'quantity_decrement':
	quantity_decrement($product_id);	
	break;
}
function addToCart($pId,$pName,$pPrice,$pImage,$cart){
	if(isset($_SESSION['cart'][$pId])){
		$_SESSION['cart'][$pId]['quantity'] = $_SESSION['cart'][$pId]['quantity']+1; 
	}
	else{
		$_SESSION['cart'][$pId] = array('id'=>$pId,'name'=>$pName,'price'=>$pPrice,'quantity'=>1,'image'=>$pImage);
	}		
}
function quantity_decrement($pId){
	if(isset($_SESSION['cart'][$pId])){
		if($_SESSION['cart'][$pId]['quantity']==1){
			unset($_SESSION['cart'][$pId]);
		}
		else{
			$_SESSION['cart'][$pId]['quantity'] = $_SESSION['cart'][$pId]['quantity']-1; 
		}
	}	
}	
echo json_encode($_SESSION['cart']);
die();

?>