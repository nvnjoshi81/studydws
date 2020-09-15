<?php
	include('config.php');
	error_reporting(0);
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$class_id = $_POST['class_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];
	
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

  echo "SELECT * FROM cmsorders join cmsorder_details on cmsorders.id =  cmsorder_details.order_id join cmspricelist on cmspricelist.id=cmsorder_details.product_id  where  cmsorders.user_id = '$user_id' and cmspricelist.type='1'";
	$result = mysqli_query($conn,"SELECT * FROM cmsorders join cmsorder_details on cmsorders.id =  cmsorder_details.order_id join cmspricelist on cmspricelist.id=cmsorder_details.product_id  where  cmsorders.user_id = '$user_id' and cmspricelist.type='1'" );

	
	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['product_id']; 
		$job = array();
		$job = getmarvelcategoryn($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['datatwo'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['datatwo'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategoryn($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM cmspricelist where id = '$mar_id' and type = '1'");
		if($rows = mysqli_fetch_array($result)) 
		{
			$returnValue['item_id'] = $rows['item_id'];
			$returnValue['type'] = $rows['type'];
			$returnValue['price'] = $rows['price'];
			$returnValue['discounted_price'] = $rows['discounted_price'];
			$returnValue['offline_status'] = $rows['offline_status'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $rows['description']);
			$returnValue['modules_item_id'] = $rows['modules_item_id'];
			$returnValue['modules_item_name'] = $rows['modules_item_name'];
			$returnValue['no_of_dvds'] = $rows['no_of_dvds'];
			$returnValue['no_of_lectures'] = $rows['no_of_lectures'];
			$returnValue['subscription_expiry'] = $rows['subscription_expiry'];
			$returnValue['lecture_duration'] = $rows['lecture_duration'];
			$returnValue['class_id'] = $rows['exam_id'];
			$returnValue['subject_id'] = $rows['subject_id'];
			$returnValue['chapter_id'] = $rows['chapter_id'];
			$returnValue['id'] = $rows['id'];
			 $num = $rows['id'];
			
			 $las = $num%10;
			 $imm = "http://dev.hybridinfotech.com/assets/frontend/images/";
	$returnValue['video_image'] = $imm.$las.".png";
		}
		return $returnValue;
	}
	
?>
