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

    //$qry = "SELECT * FROM `cmspricelist` WHERE `exam_id` = '$class_id' AND `subject_id`  = '$subject_id' AND chapter_id = '$chapter_id' and type = '1'";
	$result = mysqli_query($conn,$qry);
    while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['item_id'];
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

		$result = mysqli_query($conn,"SELECT * FROM cmsfiles WHERE id = '$mar_id'");
		if($rows = mysqli_fetch_array($result))
		{
			$returnValue['id'] = $rows['id'];
	        $returnValue['displayname'] = $rows['displayname'];
			$returnValue['filepath'] = "https://www.studyadda.com/".$rows['filepath_one'].$rows['filename_one'];
		}
		return $returnValue;
	}

?>
