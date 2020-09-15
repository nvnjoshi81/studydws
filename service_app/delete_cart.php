<?php
error_reporting(0);

$tim = time();
include ('config.php');
 
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$id = $_POST['id'];

	  
	  
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	  while($ryu = mysqli_fetch_array($oppf)){
	$get_api = $ryu['user_key'];
	  }
  }
  
  
$array1=array();
	{
	if (!empty($_REQUEST['user_id']) &&!empty($get_api)) 
		{
   
   
    $sel = "select * from cmscart where user_id = '$user_id' ";
$osd = mysqli_query($conn, $sel);
while($ssr = mysqli_fetch_array($osd))
{ $cid = $ssr['id'];
$cart_items = $ssr['cart_items'];
$cart_qtys = $ssr['cart_qty'];
 $cart_prices = $ssr['cart_price'];
	}
	
	

  $sels = "select * from cmscart_items where id = '$id'";
$osds = mysqli_query($conn, $sels);
while($ssrs = mysqli_fetch_array($osds))
{ $cdid = $ssrs['id'];
$dproductid = $ssrs['product_id'];
$dqtys = $ssrs['quantity'];
 $dprices = $ssrs['price'];
	}
	
	
$cart_pric = $cart_prices-$dprices;	
		
		
		  $query_req1="UPDATE cmscart SET  cart_price='$cart_pric'  where  user_id = '$user_id'";
	 $ob = mysqli_query($conn, $query_req1);
	 
	
	 	$dell = "DELETE FROM cmscart_items where id = '$id'";
	 	$ss = mysqli_query($conn, $dell);
	 

	 		$array1['status']="true";
			 $array1['msg']="Delete from cart";

	}
	else
	{
		$array1['status']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
?>