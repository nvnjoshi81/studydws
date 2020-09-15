<?php
include('../service_app/config.php');
error_reporting(0);

    $tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	header("Access-Control-Allow-Origin: *");

	$result = mysqli_query($conn,"SELECT `cmsvideoslist`.`name`, `cmsvideoslist`.`display_image`, `cmsvideoslist`.`id`, `cmsvideolist_relations`.`id` as `v_relations_id`,
  `cmsvideolist_relations`.`exam_id`, `cmsvideolist_relations`.`subject_id`, `cmsvideolist_relations`.`chapter_id`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`,
  `cmschapters`.`name` as `chapter` FROM `cmsvideolist_relations` JOIN `categories` ON `cmsvideolist_relations`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON
  `cmsvideolist_relations`.`subject_id`=`cmssubjects`.`id` LEFT JOIN `cmschapters` ON `cmsvideolist_relations`.`chapter_id`=`cmschapters`.`id` JOIN `cmsvideoslist` ON 
  `cmsvideolist_relations`.`videolist_id`=`cmsvideoslist`.`id` GROUP BY `cmsvideolist_relations`.`videolist_id` ORDER BY `cmsvideoslist`.`id` DESC LIMIT 6" );

	
	while($row = mysqli_fetch_array($result)) {
		  $mar_id = $row['id']; 
		$job = array();
		$job = getmarvelcategoryn($mar_id,$conn);
		$subTmp[] = $job;
	}
$tmp =  $subTmp; 
		
		
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategoryn($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM `cmsvideoslist` WHERE `id`='$mar_id'");
		if($rows = mysqli_fetch_array($result)) 
		{
			$returnValue['id'] = $vid =$rows['id'];
			$returnValue['video_name'] = $rows['name'];
			$returnValue['subject_id'] = $rows['subject_id'];
			$returnValue['subject'] = $rows['subject'];
			$returnValue['chapter'] = $rows['chapter'];
				$returnValue['exam'] = $rows['exam'];
			$returnValue['exam_id'] = $rows['exam_id'];
		
	$results = mysqli_query($conn,"SELECT * FROM `cmsvideolist_details` WHERE `videolist_id` = '$vid'");
	 $coou = mysqli_num_rows($results);
	$returnValue['video_counts'] = $coou;			
		}
		return $returnValue;
	}
	
?>
