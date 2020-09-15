
<?php
error_reporting(0);
include('../../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	$cat_id=$_GET['exam_id'];
	$subject_id=$_GET['subject_id'];
	$chapter_id=$_GET['chapter_id'];
	 $containtype=$_GET['type'];
	 header("Access-Control-Allow-Origin: *");
  if($containtype==videos){ $containtype='2';}
  
  if($subject_id > 0){$subject_ids = "AND `cmsvideolist_relations`.`subject_id` = '$subject_id'" ;} else {$subject_ids="";} 
  
   if($chapter_id > 0){$chapter_ids = "AND `cmsvideolist_relations`.`chapter_id` = '$chapter_id'" ;} else {$chapter_ids="";} 
  
  
 
 
 $result = mysqli_query($conn, "SELECT `cmsvideoslist`.`name`, `cmsvideoslist`.`display_image`, `cmsvideoslist`.`id`, `cmsvideolist_relations`.`id` as `v_relations_id`,
 `cmsvideolist_relations`.`exam_id`, `cmsvideolist_relations`.`subject_id`, `cmsvideolist_relations`.`chapter_id`, `categories`.`name` as `exam`,
 `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmsvideolist_relations` JOIN `categories` ON `cmsvideolist_relations`.`exam_id`=`categories`.`id`
 LEFT JOIN `cmssubjects` ON `cmsvideolist_relations`.`subject_id`=`cmssubjects`.`id` LEFT JOIN `cmschapters` ON `cmsvideolist_relations`.`chapter_id`=`cmschapters`.`id` JOIN 
 `cmsvideoslist` ON `cmsvideolist_relations`.`videolist_id`=`cmsvideoslist`.`id` WHERE `cmsvideolist_relations`.`exam_id` = '$cat_id' $subject_ids $chapter_ids GROUP BY `cmsvideolist_relations`.`videolist_id`
 ORDER BY `cmsvideoslist`.`id` DESC");

  
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
		
		
		$result = mysqli_query($conn,"SELECT * FROM cmsvideoslist WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		  
    	
    		
    		//	$str = htmlentities($row['name'], ENT_QUOTES, "UTF-8");
    		
    		$str= $row['name'];
    		if(strlen($str)>30){ $names= substr($str,0,30)."...";}
    		else { $names = $str; }
    		
    		
    		$returnValue['short_name'] = $names;
    		$returnValue['title_name'] = $str;
    		
    		
    		
			$returnValue['exam_id'] = $row['exam_id'];
			$returnValue['subject_id'] = $row['subject_id'];
			$returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['display_image'] = $row['display_image'];
			$returnValue['video_by'] = $row['video_by'];
			$returnValue['id'] = $iddd = $row['id'];
		
			$resultsc = mysqli_query($conn,"SELECT * FROM cmsvideolist_details WHERE videolist_id = '$iddd'");
			$coo = mysqli_num_rows($resultsc);
		$returnValue['video_count'] = $coo;
		    
		
		}
		return $returnValue;
	}
	
?>

