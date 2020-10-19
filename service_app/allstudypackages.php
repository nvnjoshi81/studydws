<?php
error_reporting(0);$qry;
	include('config.php');
	$user_key = $_REQUEST['user_key'];
	$user_id = $_REQUEST['user_id'];
	if($_REQUEST['class_id'] != "")
	$class_id = $_REQUEST['class_id'];
	
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
    if ($class_id != "")
    {
        $qry = "SELECT C.id, C.exam_id, C.subject_id, C.chapter_id, C.item_id, C.type, C.price, C.discounted_price, C.description, C.offline_status, C.image, C.app_image, C.modules_item_id, C.modules_item_name, C.no_of_dvds, C.subscription_expiry, C.no_of_lectures, C.lecture_duration, C.no_of_subscribers, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmspricelist C LEFT JOIN categories ON C.exam_id=categories.id LEFT JOIN cmssubjects ON C.subject_id=cmssubjects.id LEFT JOIN cmschapters ON C.chapter_id=cmschapters.id WHERE type = '1' AND chapter_id = '' AND subject_id = '' AND item_id =0 AND exam_id = '$class_id' AND price > '100' GROUP BY C.id";
    }
    else
    {
        $qry = "SELECT C.id, C.exam_id, C.subject_id, C.chapter_id, C.item_id, C.type, C.price, C.discounted_price, C.description, C.offline_status, C.image, C.app_image, C.modules_item_id, C.modules_item_name, C.no_of_dvds, C.subscription_expiry, C.no_of_lectures, C.lecture_duration, C.no_of_subscribers, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmspricelist C LEFT JOIN categories ON C.exam_id=categories.id LEFT JOIN cmssubjects ON C.subject_id=cmssubjects.id LEFT JOIN cmschapters ON C.chapter_id=cmschapters.id WHERE type = '1' AND chapter_id = '' AND subject_id = '' AND item_id =0 AND exam_id > '0' AND price > '100' GROUP BY C.id";
    }
if($get_api){
	$result = mysqli_query($conn,$qry);
}

	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['id'];
		//$qry = "SELECT count(*) as item_count FROM `cmsorder_details` INNER JOIN cmsorders ON cmsorder_details.order_id = cmsorders.id WHERE cmsorder_details.product_id = '$mar_id' AND cmsorders.user_id = '$user_id'";
		/*$result_order = mysqli_query($conn,$qry);
		$num_order = mysqli_num_array($result_order);
		$job = array();
		if($num_order >= 1)
		{
		    
		}
		else
		{*/
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
		//}
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);

	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM cmspricelist WHERE id = '$mar_id'");
		while($rows = mysqli_fetch_array($result)) 
			{
			$returnValue['item_id'] = $rows['item_id'];
			$returnValue['type'] = $rows['type'];
			$returnValue['modules_item_name'] = $rows['modules_item_name'];
			$returnValue['price'] = $rows['price'];
			$returnValue['thumb_image'] = "https://studyadda.com/assets/images/".$rows['thumb_image'];
			$returnValue['app_image'] = "https://studyadda.com/assets/images/appimage/".$rows['app_image'];
			$dscprice = $rows['discounted_price'];
			if($dscprice < 1)
			{
			    $returnValue['discounted_price'] = $rows['price'];
			}
			else
			{
			    $returnValue['discounted_price'] = $rows['discounted_price'];
			}
			
			$img = "http://dev.hybridinfotech.com/assets/frontend/product_images/studypackage_blank.png";
			if($rows['app_image'] > "")
			{
			   $returnValue['image'] = "http://studyadda.com/assets/frontend/product_images/".$rows['app_image'];
			}
			else
			{
			    $returnValue['image'] = $img;
			}
			$returnValue['id'] = $id = $rows['id'];
			$user_id = $_REQUEST['user_id'];
			$result_pack = mysqli_query($conn,"SELECT cmsorders.id FROM `cmsorders` INNER JOIN cmsorder_details ON cmsorder_details.order_id = cmsorders.id WHERE cmsorders.user_id = '$user_id' AND cmsorder_details.product_id = '$id' AND cmsorders.status = '1'");
		    if(($rows = mysqli_fetch_array($result_pack)) > 0) 
			{
			    $returnValue['package_bought'] = 1;
			}
			else
			{
			    $returnValue['package_bought'] = 0;
			}
			}
			return $returnValue;
	}
	mysqli_close($conn);
?>
