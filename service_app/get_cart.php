<?php
error_reporting(0);
	include('config.php');
	
	$user_id = $_POST['user_id'];
    $user_key = $_POST['user_key'];
    $user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$product_id = $_POST['product_id'];
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
      "SELECT * FROM cmscart where user_id = '$user_id'";
    	$resulta = mysqli_query($conn,"SELECT * FROM cmscart where user_id = '$user_id'");
	while($rowa = mysqli_fetch_array($resulta)) {
		  $cid = $rowa['id'];
	
	}
	
	"SELECT * FROM cmscart_items where cart_id = '$cid'";
   	if($product_id){
		 $result = mysqli_query($conn,"SELECT * FROM cmscart_items where cart_id = '$cid' and product_id='$product_id'");   
		}else{
	$result = mysqli_query($conn,"SELECT * FROM cmscart_items where cart_id = '$cid' ");
		}
	
}

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn,$product_id);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn,$product_id) {		
		$returnValue = array();
		//echo "SELECT * FROM cmscart_items where id = '$mar_id'";
		if($product_id){
		 $result = mysqli_query($conn,"SELECT * FROM cmscart_items where id = '$mar_id' and product_id='$product_id'");   
		}else{
		$result = mysqli_query($conn,"SELECT * FROM cmscart_items where id = '$mar_id'");
		}
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['product_id'] = $pid = $row['product_id'];
		$returnValue['id'] = $row['id'];
		$returnValue['quantity'] = $row['quantity'];
		$returnValue['price'] = $row['price'];
		$returnValue['type'] = $row['type'];
		$returnValue['modules_item_id'] = $row['modules_item_id'];
		
	    $results = mysqli_query($conn,"SELECT * FROM cmspricelist where id = '$pid'");
		if($rows = mysqli_fetch_array($results)) 
		{
	
			$returnValue['item_name'] = $rows['modules_item_name'];
			if($rows['app_image']>"")
			{
			$returnValue['image'] = "http://studyadda.com/assets/frontend/product_images/".$rows['app_image'];
			}
			else
			{
			    $img = "http://dev.hybridinfotech.com/assets/frontend/product_images/studypackage_blank.png";
			    $returnValue['image'] = $img;
			}
			
		}
	
	
		
		}
		return $returnValue;
	}
	
?>
