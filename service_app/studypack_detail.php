<?php
error_reporting(0);
	include('config.php');
	
$id = $_REQUEST['id'];
	$user_key = $_REQUEST['user_key'];
			$device_id = $_REQUEST['device_id'];
	$user_id = $_REQUEST['user_id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key'  and device_id = '$device_id'";
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

//if($get_api){

//echo "SELECT displayname,filepath_one,filename_one FROM cmsfiles WHERE id = '$id'";
	$result = mysqli_query($conn,"SELECT id FROM cmsfiles WHERE id = '$id'");
//}

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT displayname,filepath_one,filename_one FROM cmsfiles WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['title'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['displayname']);
		$returnValue['filepath'] = $row['filepath_one'].$row['filename_one'];
		}
		return $returnValue;
	}
	
?>
