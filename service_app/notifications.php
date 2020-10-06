<?php
	include('config.php');

	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";

	$result = mysqli_query($conn,"SELECT * FROM notifications");
	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['noti_id'];
		
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
/*$tmp['status'] = "success";
$tmp['data'] = $subTmp; */
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = $subTmp;}
	
	echo json_encode($tmp);
	
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		//echo "SELECT * FROM notifications WHERE noti_id = '$mar_id'";
		$result = mysqli_query($conn,"SELECT * FROM notifications WHERE noti_id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['title'] = $row['title'];
		$returnValue['description'] = $row['description'];
		$returnValue['pages'] = $row['pages'];
		$returnValue['exm_id'] = $row['exm_id'];
		$returnValue['type'] = $row['type'];
		$returnValue['id'] = $row['id_1'];
		$returnValue['note_date'] = $row['noti_date'];
	
		}
		return $returnValue;
	}
	mysqli_close($conn);
?>
