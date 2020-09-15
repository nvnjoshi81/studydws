<?php
error_reporting(0);
	include('config.php');
	
			$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
		$device_id = $_POST['device_id'];
	//select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	  while($ryu = mysqli_fetch_array($oppf)){
	$get_api = $ryu['user_key'];
	  }
  }
  
  
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";

   // echo "SELECT * FROM cmsorders where user_id = '$user_id'";
	$result = mysqli_query($conn,"SELECT * FROM cmsorders where user_id = '$user_id'");

	
	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
	
		$result = mysqli_query($conn,"SELECT * FROM cmsorders where id = '$mar_id' ");
		if($row = mysqli_fetch_array($result)) 
		{
		    $returnValue['order_no'] = $row['order_no'];
		$returnValue['user_id'] = $row['user_id'];
			$returnValue['order_items'] = $row['order_items'];
			$returnValue['order_qty'] = $row['order_qty'];
			$returnValue['order_price'] = $row['order_price'];
			$returnValue['payment_mode'] = $row['payment_mode'];
		
			$returnValue['payment_status'] = $row['payment_status'];
			$returnValue['status'] = $row['status'];
			$returnValue['docket_no'] = $row['docket_no'];
			$returnValue['shipping_charges'] = $row['shipping_charges'];
			$returnValue['cod_charges'] = $row['cod_charges'];
			$returnValue['final_amount'] = $row['final_amount'];
			$returnValue['guest'] = $row['guest'];
			$returnValue['agree_terms'] = $row['agree_terms'];
			$returnValue['shipping_id'] = $row['shipping_id'];
			$returnValue['txn_number'] = $row['txn_number'];
			$returnValue['created_dt'] = $yr = $row['created_dt'];
			$returnValue['id'] = $row['id'];
			
			 $num = $row['id'];
			 
			 	$dt = new DateTime("@$yr");  // convert UNIX timestamp to PHP DateTime
           $returnValue['created_datet'] = $dt->format('Y-m-d H:i:s');
		
			//	$returnValue['created_datet'] = $dt;
			
		}
		return $returnValue;
	}
	
?>
