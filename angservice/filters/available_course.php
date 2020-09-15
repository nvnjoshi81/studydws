
<?php
error_reporting(0);
include('../../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	$cat_id=$_GET['exam_id'];
	 $containtype=$_GET['type'];
	 header("Access-Control-Allow-Origin: *");
  if($containtype==videos){ $containtype='2';}
  
  
 $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id' AND 
  `cmspricelist`.`type` = '$containtype' and `cmspricelist`.`subscription_expiry` >= '1' and `cmspricelist`.`subject_id` > '0' and `cmspricelist`.`chapter_id`='0' AND
  `cmspricelist`.`price` > '0' and `cmspricelist`.`status` = 'show' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");

  
	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['productlist_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
	
	$tmp = $subTmp;	

	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		
		$result = mysqli_query($conn,"SELECT * FROM cmspricelist WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		  
    		$returnValue['exam_id'] = $row['exam_id'];
			$returnValue['subject_id'] = $row['subject_id'];
			$returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['discounted_price'] = $row['discounted_price'];
			$returnValue['price'] = $row['price'];
			$returnValue['image'] = $row['image'];
			$returnValue['app_image'] = $row['app_image'];
			$returnValue['modules_item_id'] = $row['modules_item_id'];
			$returnValue['modules_item_name'] = $row['modules_item_name'];
			$returnValue['no_of_dvds'] = $row['no_of_dvds'];
			$returnValue['subscription_expiry'] = $row['subscription_expiry'];
			$returnValue['no_of_lectures'] = $row['no_of_lectures'];
			$returnValue['lecture_duration'] = $row['lecture_duration'];
			$returnValue['no_of_subscribers'] = $row['no_of_subscribers'];
		
		}
		return $returnValue;
	}
	
?>

