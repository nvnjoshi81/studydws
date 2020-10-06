<?php
	include('config.php');
	error_reporting(0);
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$id = $_POST['test_id'];

	
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

 
	$result = mysqli_query($conn,"SELECT * FROM cmsusertest where test_id = '$id' and user_id = '$user_id' ORDER BY cmsusertest.dt_created DESC LIMIT 1" );

	
	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id']; 
		$job = array();
		$job = getmarvelcategoryn($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['datatwo'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['datatwo'] = "no data";}
	echo json_encode($tmp);

	function getmarvelcategoryn($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM cmsusertest where id = '$mar_id'");
		if($rows = mysqli_fetch_array($result)) 
		{
		$returnValue['time_remaining'] = $rows['time_remaining'];
			//$returnValue['time_taken'] = $rows['time_taken'];
			$qry = "SELECT  SEC_TO_TIME( SUM( TIME_TO_SEC( perclick_time_spent ) ) ) AS timeSum  FROM cmsusertest_detail WHERE usertest_id = '$test_id'";
			$result1 = mysqli_query($conn,$qry);
    		if($rows1 = mysqli_fetch_array($result1)) 
    		{
    		    $returnValue['time_taken'] = $rows1['timeSum'];
    		    //$returnValue['total_time'] = $rows1['timeSum'];
    		}
			$returnValue['total_marks'] = $rows['total_marks'];
			$returnValue['obtain_marks'] = $rows['obtain_marks'];
			$returnValue['formula_id'] = $rows['formula_id'];
		    $returnValue['right_answer_marks'] = $rows['right_answer_marks']*$rows['correct_ans'];
			$returnValue['wrong_answer_marks'] = $rows['wrong_answer_marks']*$rows['incorrect_ans'];
			$returnValue['reviewed_qus'] = $rows['reviewed_qus'];
			$returnValue['attampted_ques'] = $rows['attampted_ques'];
			$returnValue['not_attampted_qus'] = $rows['not_attampted_qus'];
			$returnValue['total_qus'] = $rows['total_qus'];
			$returnValue['total_time'] = $rows['total_time'];
			$returnValue['correct_ans'] = $rows['correct_ans'];
			$returnValue['incorrect_ans'] = $rows['incorrect_ans'];
			$dtcr = $rows['dt_created'];
			$dtcrf = date('d-m-Y', $dtcr);
			//$dtcrf = substr($dtcrf,0,11);
			$returnValue['dt_created'] = $dtcrf;
			$returnValue['test_id'] = $rows['test_id'];
			$returnValue['id'] = $rows['id'];
			
		}
		return $returnValue;
	}
	mysqli_close($conn);
?>
