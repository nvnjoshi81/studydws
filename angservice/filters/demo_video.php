
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
  
  if($subject_id > 0){ $subject_ids = "AND `R`.`subject_id` = '$subject_id'" ; }else { $subject_ids = ""; } 
  
  if($chapter_id > 0){ $chapter_ids = "AND `R`.`chapter_id` = '$chapter_id'" ; }else { $chapter_idd = ""; } 
  
  
 $result = mysqli_query($conn, "SELECT `V`.`id`, `title`, `V`.`video_source`, `V`.`video_url_code`, `V`.`video_file_name`, `V`.`video_image`, `V`.`short_video`, `V`.`is_featured`, 
  `V`.`description`, `V`.`video_by`, `V`.`status`, `V`.`views`, `V`.`is_free`, `V`.`video_duration`, `V`.`custom_video_duration`, `V`.`amazonaws_link`,
  `V`.`amazon_cloudfront_domain`, `L`.`name` as `playlist`, `C`.`name` as `exam`, `S`.`name` as `subject`, `CH`.`name` as `chapter` FROM 
  `cmsvideos` `V` JOIN `cmsvideolist_details` `VD` ON `V`.`id`=`VD`.`video_id` JOIN `cmsvideolist_relations` `R` ON `R`.`videolist_id`=`VD`.`videolist_id` 
  JOIN `categories` `C` ON `C`.`id`=`R`.`exam_id` LEFT JOIN `cmssubjects` `S` ON `R`.`subject_id`=`S`.`id` LEFT JOIN `cmschapters` `CH` ON `R`.`chapter_id`=`CH`.`id` 
  JOIN `cmsvideoslist` `L` ON `L`.`id`=`VD`.`videolist_id` WHERE `V`.`video_source` = 'youtube' AND `V`.`is_featured` = 1 AND `V`.`video_tag` != 'Career Point' 
  AND `V`.`video_url_code` != '' AND `R`.`exam_id` = '$cat_id' $subject_ids $chapter_ids GROUP BY `V`.`id` ORDER BY RAND() LIMIT 12");

  
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
		
		
		$result = mysqli_query($conn,"SELECT * FROM cmsvideos WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		  
    		$returnValue['title_name'] = $row['title'];
			$returnValue['video_source'] = $row['video_source'];
			$returnValue['video_url_code'] = $row['video_url_code'];
			$returnValue['video_file_nam'] = $row['video_file_nam'];
			$returnValue['video_image'] = $row['video_image'];
			$returnValue['short_video'] = $row['short_video'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['video_by'] = $row['video_by'];
			$returnValue['video_tag'] = $row['video_tag'];
			$returnValue['is_free'] = $row['is_free'];
			$returnValue['video_duration'] = $row['video_duration'];
			$returnValue['custom_video_duration'] = $row['custom_video_duration'];
			$returnValue['amazonaws_link'] = $row['amazonaws_link'];
			$returnValue['amazon_cloudfront_domain'] = $row['amazon_cloudfront_domain'];
		
		}
		return $returnValue;
	}
	
?>

