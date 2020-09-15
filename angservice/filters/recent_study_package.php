
<?php
error_reporting(0);
include('../../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	$exam_id=$_GET['exam_id'];
	$subject_id=$_GET['subject_id'];
	$chapter_id=$_GET['chapter_id'];
	 $containtype=$_GET['type'];
	 header("Access-Control-Allow-Origin: *");
  if($containtype==study-packages){ $types='1';}
  
  if($subject_id > 0){$subject_ids = "AND `cmsvideolist_relations`.`subject_id` = '$subject_id'" ;} else {$subject_ids="";} 
  
   if($chapter_id > 0){$chapter_ids = "AND `chapter_id` = '$chapter_id'" ;} else {$chapter_ids="";} 
  
  
 
// echo "SELECT * from cmspricelist where exam_id = '$exam_id' and subject_id='$subject_id' and type='$types' and status='show' order by id desc ";
 $result = mysqli_query($conn, "SELECT * from cmspricelist where exam_id = '$exam_id' and subject_id='$subject_id' and type='$types' and status='show' $chapter_ids order by id desc");

  
	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id']; 
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
		  
    	
    		
    			$str = htmlentities($row['modules_item_name'], ENT_QUOTES, "UTF-8");
    		
    		if(strlen($str)>30){ $names= substr($str,0,30)."...";}
    		else { $names = $str; }
    		$returnValue['item_short_name'] = $names;
    		$returnValue['item_title_name'] = $str;
			$returnValue['exam_id'] = $row['exam_id'];
				$returnValue['price'] = $row['price'];
					$returnValue['discounted_price'] = $row['discounted_price'];
			$returnValue['subject_id'] = $row['subject_id'];
			$returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['image'] = $row['image'];
			$returnValue['app_image'] = $row['app_image'];
			$returnValue['no_of_dvds'] = $row['no_of_dvds'];
			$returnValue['subscription_expiry'] = $row['subscription_expiry'];
			$returnValue['no_of_lectures'] = $row['no_of_lectures'];
			$returnValue['lecture_duratio'] = $row['lecture_duratio'];
			$returnValue['no_of_subscribers'] = $row['no_of_subscribers'];
			$returnValue['item_id'] = $row['item_id'];
			$returnValue['modules_item_id'] = $row['modules_item_id'];
			$returnValue['id'] = $iddd = $row['id'];
		
			$resultsc = mysqli_query($conn,"SELECT * FROM cmsvideolist_details WHERE videolist_id = '$iddd'");
			$coo = mysqli_num_rows($resultsc);
		$returnValue['video_count'] = $coo;
		    
		
		}
		return $returnValue;
	}
	
?>

