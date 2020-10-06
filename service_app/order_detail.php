<?php
error_reporting(0);
	include('config.php');
	
			$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
		$device_id = $_POST['device_id'];
			$id = $_POST['order_id'];
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
if($get_api){
   // echo "SELECT * FROM cmsorders where user_id = '$user_id'";
	$result = mysqli_query($conn,"SELECT * FROM cmsorder_details where order_id = '$id'");
}
	
	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);

	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
	// "SELECT * FROM cmsorder_details where id = '$mar_id' ";
		$result = mysqli_query($conn,"SELECT * FROM cmsorder_details where id = '$mar_id' ");
		if($row = mysqli_fetch_array($result)) 
		{
		    $returnValue['order_id'] =  $row['order_id'];
		$returnValue['product_id'] = $product_id = $row['product_id'];
			$returnValue['quantity'] = $row['quantity'];
			$returnValue['price'] = $row['price'];
			$returnValue['type'] = $row['type'];
			$returnValue['offline'] = $row['offline'];
			$returnValue['id'] = $row['id'];
			
			 	   $selsp = "select * from cmspricelist where id = '$product_id'";
$osdsp = mysqli_query($conn, $selsp);
$coss = mysqli_num_rows($osdsp);
if($coss){
while($ssrsp = mysqli_fetch_array($osdsp))
{ 
   
	$returnValue['product_name'] = $ssrsp['modules_item_name'];

}
}
else {
    	$returnValue['product_name'] = "";
}
			
		}
		return $returnValue;
	}

mysqli_close($conn);	
?>
