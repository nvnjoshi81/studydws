<?php
	include('config.php');
	error_reporting(0);
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$class_id = $_POST['class_id'];
	

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


	$result = mysqli_query($conn,"SELECT cmssubjects.id as subject_id, cmssubjects.name as subject_name FROM cmschapter_details INNER JOIN cmssubjects ON cmssubjects.id = cmschapter_details.subject_id WHERE cmschapter_details.class_id = '$class_id' GROUP BY cmschapter_details.subject_id" );


	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['subject_id'];
		$self = "SELECT cmsvideolist_relations.chapter_id as chapter_id FROM cmsvideolist_relations JOIN categories ON cmsvideolist_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsvideolist_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsvideolist_relations.chapter_id=cmschapters.id JOIN cmsvideoslist ON cmsvideolist_relations.videolist_id=cmsvideoslist.id WHERE cmsvideolist_relations.exam_id = '$class_id' AND cmsvideolist_relations.subject_id = '$mar_id' GROUP BY cmsvideolist_relations.videolist_id ORDER BY cmsvideoslist.id DESC";
        $oppf = mysqli_query($conn, $self);
        $rww = mysqli_num_rows($oppf);
        if($rww > 0){
		$job = array();
		$job = getmarvelcategoryn($mar_id,$conn);
		$subTmp[] = $job;
        }
	}
if($subTmp){$tmp['status'] = "success";$tmp['datatwo'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['datatwo'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategoryn($mar_id,$conn) {
		$returnValue = array();

		$result = mysqli_query($conn,"SELECT * FROM cmssubjects WHERE id = '$mar_id'");
		if($rows = mysqli_fetch_array($result))
		{
			$class_id = $_POST['class_id'];
	        $returnValue['class_id'] = $class_id;
			$returnValue['subject_id'] = $rows['id'];
			$returnValue['subject_name'] = $rows['name'];
		}
		return $returnValue;
	}

?>
