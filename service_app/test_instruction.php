<?php
	include('config.php');
	error_reporting(0);
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$id = $_POST['test_id'];
;
	
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

 
	$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest where  id = '$id' LIMIT 1" );

	
	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
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
		
		$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest  where id = '$mar_id'");
		if($rows = mysqli_fetch_array($result)) 
		{
		
			$returnValue['instructions'] = $rows['instructions'];
			
		//	$returnValue['instructions'] = preg_replace('/[^A-Za-z0-9]/', ' ', $rows['instructions']);
			$returnValue['id'] = $rows['id'];
		
		}
		return $returnValue;
	}
	
?>
