<?php
error_reporting(0);
	include('config.php');
	
			$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
		$device_id = $_POST['device_id'];
			$id = $_POST['id'];
	
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
if($get_api){
   // echo "SELECT * FROM cmsorders where user_id = '$user_id'";
	$result = mysqli_query($conn,"SELECT * FROM cmsusertest_detail where usertest_id = '$id'");
}
	
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
		
	
		$result = mysqli_query($conn,"SELECT * FROM cmsusertest_detail where id = '$mar_id' ");
		if($row = mysqli_fetch_array($result)) 
		{
		    $returnValue['question_id'] = $row['question_id'];
		$returnValue['users_answer'] = $row['users_answer'];
			$returnValue['correct_answer'] = $row['is_correct'];

			$returnValue['id'] = $qid = $row['id'];
				$id = $_POST['id'];
			//	echo "SELECT * FROM cmsusertest_detail where   usertest_id  = '$id' AND question_id='$qid'";
	$resultd = mysqli_query($conn,"SELECT * FROM cmsusertest_detail where   usertest_id  = '$id' AND question_id='$qid'");
		if($rowd = mysqli_fetch_array($resultd)) 
		{
		    $returnValue['status_question'] = $rowd['is_correct'];
		}
		else {$returnValue['status_question'] = "" ;}
		}
		return $returnValue;
	}
	
?>
