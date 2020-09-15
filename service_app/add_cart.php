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

 $sel = "select * from cmscart where user_id = '$user_id' ";
$osd = mysqli_query($conn, $sel);
while($ssr = mysqli_fetch_array($osd))
{ $cid = $ssr['id'];
$cart_items = $ssr['cart_items'];
$cart_qtys = $ssr['cart_qty'];
$cart_prices = $ssr['cart_price'];

	}

$cart_itemss = $cart_items+1;
$cart_qtyss = $cart_qtys+1;
$cart_pricess = $cart_prices+$cart_price;


  $selsc = "select * from cmscart_items where cart_id = '$cid' and product_id = '$product_id'";
$osdsc = mysqli_query($conn, $selsc);
$rtt = mysqli_num_rows($osdsc);
while($ssrss = mysqli_fetch_array($osdsc))
{  $pricec += $ssrss['price'];
}



 $sels = "select * from cmscart_items where cart_id = '$cid' and product_id='$product_id'";
$osds = mysqli_query($conn, $sels);
while($ssrs = mysqli_fetch_array($osds))
{ $cdid = $ssrs['id'];
$dproductid = $ssrs['product_id'];
$dqtys = $ssrs['quantity'];
$dprices = $ssrs['price'];
	}
	
	$dqu = $dqtys+1;
    $dpr =	$dprices+$cart_price;
	
	
		
		if($cid > 0 && $rtt=='0')
		{
		 $query_req1="UPDATE cmscart SET  cart_items = '$rtt',cart_qty='$rtt',cart_price='$pricec'  where  user_id = '$user_id'";
	 $ob = mysqli_query($conn, $query_req1);
	 
	 if($cdid > 0){
	 //	  $query_reqs="UPDATE cmscart_items SET quantity='$dqu',price='$dpr'  where  id ='$cdid'";
	 $obs = mysqli_query($conn, $query_reqs);
	 

			 
			 
	 }
	 else {
	     
	    if($dqtys){	$query_req1s="INSERT INTO cmscart_items (quantity,price,product_id,cart_id,end_date,dt_created) VALUES ('1','$cart_price','$product_id','$cid','$endd','$tim')";
			 $obs = mysqli_query($conn, $query_req1s);
	    }
			 
	 }
	 		$array1['status']="true";
			 $array1['msg']="Added to cart";
		
	 
	 
		}
		else
		{
		    
		    
		    	$query_req1s="INSERT INTO cmscart (cart_items,cart_price,user_id,cart_qty) VALUES ('1','$cart_price','$user_id','1')";
			 $obs = mysqli_query($conn, $query_req1s);
			 
			  $selp = "select * from cmscart where user_id = '$user_id'";
$osdp = mysqli_query($conn, $selp);
while($ssrp = mysqli_fetch_array($osdp))
{ $cidp = $ssrp['id'];
	}
	
	
			 
			 
			$query_req1s="INSERT INTO cmscart_items (quantity,price,product_id,cart_id,end_date,dt_created) VALUES ('1','$cart_price','$product_id','$cidp','$endd','$tim')";
			 $obs = mysqli_query($conn, $query_req1s);
			 
			 /*	$sed = "SELECT * FROM favorites where video_id = '$video_id' AND user_id = '$user_id'";
			  $obd = mysql_query($sed);
			  while($rowd=mysql_fetch_array($obd)){
				   $sus = $rowd['user_id'];
				    $svd = $rowd['video_id'];
				    $sid = $rowd['id'];
				  } 
				  */
				
		
			 $array1['status']="true";
			$array1['msg']="Added to cart";
			//$array1["query"]= $query_req1;
		}
			
		
	}
	else
	{
		$array1['status']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
?>