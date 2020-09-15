<?php
error_reporting(0);

$tim = time();
include ('config.php');
 
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$product_id = $_POST['product_id'];
	$cart_item = $_POST['cart_item'];
	$cart_qty = $_POST['cart_qty'];
	$cart_price = $_POST['cart_price'];
	  
	  
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
    $user_id = $_REQUEST['user_id'];
    $video_id = $_REQUEST['video_id'];
	$status = $_REQUEST['status'];
	
	
	 $selsp = "select * from cmspricelist where id = '$product_id'";
$osdsp = mysqli_query($conn, $selsp);
while($ssrsp = mysqli_fetch_array($osdsp))
{ 
 $ppdid = $ssrsp['id'];
 $yr = $subscription_expiry = $ssrsp['subscription_expiry'];

}

  $endds = date('Y-m-d', strtotime('+'.$yr.' years'));
  $endd = $timestamp = strtotime($endds); 



//cartmain table
 $sel = "select * from cmscart where user_id = '$user_id' ";
$osd = mysqli_query($conn, $sel);
$cartcount = mysqli_num_rows($osd);
while($ssr = mysqli_fetch_array($osd))
{  $cid = $ssr['id'];
$cart_items = $ssr['cart_items'];
$cart_qtys = $ssr['cart_qty'];
$cart_prices = $ssr['cart_price'];
}

 $sels = "select * from cmscart_items where cart_id = '$cid' and product_id='$product_id'";
$osds = mysqli_query($conn, $sels);
$detcount = mysqli_num_rows($osds);
while($ssrs = mysqli_fetch_array($osds))
{ $cdid = $ssrs['id'];
$dproductid = $ssrs['product_id'];
$dqtys = $ssrs['quantity'];
$dprices = $ssrs['price'];
}


	if($detcount=='0')
	{
	    if($cartcount=='0'){	$query_req1s="INSERT INTO cmscart (cart_items,cart_price,user_id,cart_qty) VALUES ('1','$cart_price','$user_id','1')";
			 $obs = mysqli_query($conn, $query_req1s);}
			 
$selp = "select * from cmscart where user_id = '$user_id'";
$osdp = mysqli_query($conn, $selp);
while($ssrp = mysqli_fetch_array($osdp))
{ $cidp = $ssrp['id'];}

    $query_req1s="INSERT INTO cmscart_items (quantity,price,product_id,cart_id,end_date,dt_created) VALUES ('1','$cart_price','$product_id','$cidp','$endd','$tim')";
	$obs = mysqli_query($conn, $query_req1s);
	
	
	
	if($cartcount > 0){
	    
	    
	    $selsp = "select * from cmscart_items where cart_id = '$cid'";
$osdsp = mysqli_query($conn, $selsp);
$detcountp = mysqli_num_rows($osdsp);
while($ssrsp = mysqli_fetch_array($osdsp))
{ 
$dqtys = $ssrsp['quantity'];
$dpricess += $ssrsp['price'];
}  $totalprice = $dpricess ;


	   $query_reqp="UPDATE cmscart SET  cart_items = '$detcountp',cart_qty='$detcountp',cart_price='$totalprice'  where  user_id = '$user_id' and id = '$cid'";
	 $obp = mysqli_query($conn, $query_reqp);
	 
	 
	}
		$array1['status']="true";
			 $array1['msg']="Added to cart";
	}
	else {
	    
 /*$selsp = "select * from cmscart_items where cart_id = '$cid'";
$osdsp = mysqli_query($conn, $selsp);
$detcountp = mysqli_num_rows($osdsp);
while($ssrsp = mysqli_fetch_array($osdsp))
{ 
$dqtys = $ssrsp['quantity'];
$dpricess += $ssrsp['price'];
}  $totalprice = $dpricess ;


	   $query_reqp="UPDATE cmscart SET  cart_items = '$detcountp',cart_qty='$detcountp',cart_price='$totalprice'  where  user_id = '$user_id' and id = '$cid'";
	 $obp = mysqli_query($conn, $query_reqp);*/
	 	$array1['status']="true";
			 $array1['msg']="Added to cart";
	}
			
		
	}
	else
	{
		$array1['status']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
?>