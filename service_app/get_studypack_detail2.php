<?php
error_reporting(0);
	include('config.php');
	
	$id = $_POST['id'];
$device_id = $_POST['device_id'];
		$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
   $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'";
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
   
    $id = $_POST['id'];
    $qry = "SELECT * FROM cmspricelist where id = '$id'";
	$result = mysqli_query($conn,$qry);
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
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		$qry = "SELECT * FROM cmspricelist where id = '$mar_id'";
		$result = mysqli_query($conn,$qry);
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['title'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['modules_item_name']);
			$returnValue['exam_id'] = $row['exam_id'];
		$returnValue['subject_id'] = $row['subject_id'];
			$returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['item_id'] = $row['item_id'];
			$returnValue['type'] = $row['type'];
			$returnValue['price'] = $row['price'];
		    $returnValue['discounted_price'] = $row['discounted_price'];
			$returnValue['subscription_expiry'] = $row['subscription_expiry'];
			$returnValue['no_of_packages'] = $row['no_of_lectures'];
			$returnValue['id'] = $row['id'];
			$returnValue['notes'] = "The number of package may vary time to time.Study packages are available in soft (PDF format) copy only. After buying you will be able to download them, and then read over any device (Mobile, tab, desktop, laptop etc.) having PDF functionality. Also you can take their print-outs.";
            $returnValue['image'] = "http://studyadda.com/assets/frontend/product_images/".$row['app_image'];
			
		
		}
		return $returnValue;
	}
	
?>
