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
  
$selspc = "select * from cmscustomer_addresses where customer_id = '$product_id'";
$osdspc = mysqli_query($conn, $selspc);
while($ssrspc = mysqli_fetch_array($osdspc))
{  $sid = $ssrspc['id']; }
  
  
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
 $type = $ssrsp['type'];

}

 $endds = date('Y-m-d', strtotime('+'.$yr.' years'));
  $endd = $timestamp = strtotime($endds); 

 $sel = "select * from cmsorders where user_id = '$user_id' ";
$osd = mysqli_query($conn, $sel);
while($ssr = mysqli_fetch_array($osd))
{  $oid = $ssr['id'];
$order_price = $ssr['order_price'];
$final_amount = $ssr['final_amount'];

	}


 $sels = "select * from cmsorder_details where order_id = '$cid' and product_id='$product_id'";
$osds = mysqli_query($conn, $sels);
while($ssrs = mysqli_fetch_array($osds))
{ $cdid = $ssrs['id'];
$dproductid = $ssrs['product_id'];
$dprices = $ssrs['price'];
	}
	
	
		if($cid > 0)
		{
		 $query_req1="UPDATE cmscart SET  cart_items = '$cart_itemss',cart_qty='$cart_qtyss',cart_price='$cart_pricess'  where  user_id = '$user_id'";
	 $ob = mysqli_query($conn, $query_req1);
	 

	 		$array1['status']="true";
			 $array1['msg']="Added to cart";
		
	 
	 
		}
		else
		{
		    
		    		     $selssc = "select * from cmscart where user_id = '$user_id' ";
$osdssc = mysqli_query($conn, $selssc);
while($ssrssc = mysqli_fetch_array($osdssc))
{  $cdid = $ssrssc['id'];
$cart_items = $ssrssc['cart_items'];
 $cart_qty = $ssrssc['cart_qty'];
 $cart_price = $ssrssc['cart_price'];
	}
	
	
		    
		     $selss = "select * from cmscart_items where user_id = '$user_id' ";
$osdss = mysqli_query($conn, $selss);
while($ssrss = mysqli_fetch_array($osdss))
{ $cdidf = $ssrs['id'];
$dproductid = $ssrss['product_id'];
$quantity = $ssrss['quantity'];
$prices = $ssrss['price'];
	}
	
	$order_no = rand(11000000,1600000000);
	$tim = time();
	
	 function generate_random_password($length = 40) {
      $alphabets = range('a','z');
      $numbers = range('0','9');
      // $additional_characters = array('_','.');
      $final_array = array_merge($alphabets,$numbers);
      $passwordnew = '';
      while($length--) {
      $key = array_rand($final_array);
      $passwordnew .= $final_array[$key];
      }return $passwordnew; }
      $sessionid =   generate_random_password(40) ;
	  $query_req1s="INSERT INTO cmsorders (order_no,session_id,order_items,order_price,payment_mode,payment_status,status,final_amount,shipping_charges,created_dt,user_id,shipping_id,app_order)
		VALUES ('$tim','$sessionid','$cart_qty','$cart_price','0','0','2','$cart_price','0','$tim','$user_id','4','1')"; 
		$obs = mysqli_query($conn, $query_req1s);
		$selp = "select * from cmsorders where user_id = '$user_id' ORDER BY id DESC LIMIT 1";
        $osdp = mysqli_query($conn, $selp);
        while($ssrp = mysqli_fetch_array($osdp))
        {  
            $ooip = $ssrp['id'];
        }		 
		$selssp = "select * from cmscart_items where cart_id = '$cdid' ";
        $osdssp = mysqli_query($conn, $selssp);
        while($ssrssp = mysqli_fetch_array($osdssp))
        { $cdid = $ssrssp['id'];
        $dproductid = $ssrssp['product_id'];
        $quantitys = $ssrssp['quantity'];
         $prices = $ssrssp['price'];
        
        	 $selspe = "select * from cmspricelist where id = '$dproductid'";
        $osdspe = mysqli_query($conn, $selspe);
        while($ssrspe = mysqli_fetch_array($osdspe))
        { 
            $ppdid = $ssrspe['id'];
         $typee = $ssrspe['type'];
        
        }
             $query_req1s="INSERT INTO cmsorder_details (order_id,price,product_id,quantity,type,user_id,end_date) VALUES ('$ooip','$prices','$dproductid','$quantitys','$typee','$user_id',$tim)"; 
			 $obs = mysqli_query($conn, $query_req1s);
			 
			 //$upd = "UPDATE cmscart_items SET status = '1' where id = '$cdid'";
			 //$opp = mysqli_query($conn, $upd);
			 
			  //$delc = "DELETE FROM `cmscart_items` where order_id = '$ooip'";
			 //$dell = mysqli_query($conn, $delc);
			 
			  //$delcc = "DELETE FROM `cmscart` where user_id = '$user_id'";
			 //$dellc = mysqli_query($conn, $delcc);
			 
}
			 
			 /*	$sed = "SELECT * FROM favorites where video_id = '$video_id' AND user_id = '$user_id'";
			  $obd = mysql_query($sed);
			  while($rowd=mysql_fetch_array($obd)){
				   $sus = $rowd['user_id'];
				    $svd = $rowd['video_id'];
				    $sid = $rowd['id'];
				  } 
				  */
				
		
			 $array1['status']="true";
			$array1['msg']="Successfullly order";
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