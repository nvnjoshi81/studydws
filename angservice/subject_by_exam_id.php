
<?php
error_reporting(0);
include('../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	 header("Access-Control-Allow-Origin: *");
  $cat_id = $_GET['exam_id'];
  $subject_id = $_GET['subject_id'];
  $type = $_GET['type'];
  
  if($subject_id > 0){$subject_ids = "AND subject_id = '$subject_id' GROUP BY `chapter_id`"; } else {$subject_ids = "GROUP BY `subject_id`"; }
  
  if($type=='videos'){
      //echo "SELECT * FROM `cmsvideolist_relations` WHERE `exam_id`='$cat_id' $subject_ids";
	$result = mysqli_query($conn,"SELECT * FROM `cmsvideolist_relations` WHERE `exam_id`='$cat_id' $subject_ids");
  }
  
    else if($type=='study-packages'){
         if($subject_id > 0){$subject_ids = "AND subject_id = '$subject_id' GROUP BY `chapter_id`"; } else {$subject_ids = "GROUP BY `subject_id`"; }
    $result = mysqli_query($conn,"SELECT * FROM `cmspricelist` WHERE `exam_id`='$cat_id' and `subject_id` > '0' and type='1' $subject_ids");
  }
  
   else if($type=='sample-papers'){
         if($subject_id > 0){$subject_ids = "AND subject_id = '$subject_id' GROUP BY `chapter_id`"; } else {$subject_ids = "GROUP BY `subject_id`"; }
        // echo "SELECT * FROM `cmssamplepapers_relations` WHERE `exam_id`='$cat_id' $subject_ids ";
    $result = mysqli_query($conn,"SELECT * FROM `cmssamplepapers_relations` WHERE `exam_id`='$cat_id' and created_by > '0' $subject_ids ");
  }
  
	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['subject_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
	
	$tmp = $subTmp;	

	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		
		$result = mysqli_query($conn,"SELECT * FROM cmssubjects WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		  
    		$returnValue['id'] = $row['id'];
    		$returnValue['name'] =$nam = $row['name'];
          	$string = str_replace(' ', '-', $nam);
			$returnValue['urlprefix'] = strtolower($string);
	
		}
		return $returnValue;
	}
	
?>

