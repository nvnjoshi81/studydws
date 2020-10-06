<?php 
include ('config.php');
error_reporting(0);
$id=$_GET['id'];
$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$id = $_POST['test_id'];
	

$array1=array();
	{
	
		
		if (!empty($_POST['test_id'])) 

		{$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$id = $_POST['test_id'];



	  
	 // "SELECT * FROM cmsusertest where test_id = '$id' and user_id = '$user_id'";
		$result = mysqli_query($conn,"SELECT * FROM cmsusertest where test_id = '$id' and user_id = '$user_id'");
		if($rows = mysqli_fetch_array($result)) 
		{
		
		
		$time = $rows['time_remaining'];
			$taken = $rows['total_marks'];
			$om = $rows['obtain_marks'];
			$fi = $rows['formula_id'];
		
			$rm = $rows['right_answer_marks'];
			$wa = $rows['wrong_answer_marks'];
			$rq = $rows['reviewed_qus'];
			$aq = $rows['attampted_ques'];
			$nq = $rows['not_attampted_qus'];
			$tq = $rows['total_qus'];
			$tt= $rows['total_time'];
			$ca = $rows['correct_ans'];
			$ia = $rows['incorrect_ans'];
				$dt = $rows['dt_created'];
				
				$returnValue['time_remaining'] = $rows['time_remaining'];
			$returnValue['time_taken'] = $rows['time_taken'];
			$returnValue['total_marks'] = $rows['total_marks'];
			$returnValue['obtain_marks'] = $rows['obtain_marks'];
			$returnValue['formula_id'] = $rows['formula_id'];
			$returnValue['right_answer_marks'] = $rows['right_answer_marks'];
			$returnValue['wrong_answer_marks'] = $rows['wrong_answer_marks'];
			$returnValue['reviewed_qus'] = $rows['reviewed_qus'];
			$returnValue['attampted_ques'] = $rows['attampted_ques'];
			$returnValue['not_attampted_qus'] = $rows['not_attampted_qus'];
			$returnValue['total_qus'] = $rows['total_qus'];
			$returnValue['total_time'] = $rows['total_time'];
			$returnValue['correct_ans'] = $rows['correct_ans'];
			$returnValue['incorrect_ans'] = $rows['incorrect_ans'];
			$returnValue['dt_created'] = $rows['dt_created'];
			$tid = $rows['test_id'];
			$mid = $rows['id'];
	
	            $array1['status']="success";
		     	$array1['time_remaining']=$time;
				$array1['time_taken']=$taken;
				$array1['total_marks']=$taken;
				$array1['obtain_marks']=$taken;
				$array1['formula_id']=$taken;
				$array1['right_answer_marks']=$taken;
				$array1['wrong_answer_marks']=$taken;
				$array1['reviewed_qus']=$taken;
				$array1['attampted_ques']=$taken;
				$array1['not_attampted_qus']=$taken;
				$array1['total_qus']=$taken;
				$array1['total_time']=$taken;
				$array1['correct_ans']=$taken;
				$array1['incorrect_ans']=$taken;
				$array1['dt_created']=$taken;
				$array1['test_id']=$tid;
				$array1['id']=$mid;
					$array1['instructions']="";
		
		}
		else
		{
			
			$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest  where id = '$id'");
		if($rows = mysqli_fetch_array($result)) 
		{
			$ins = $rows['instructions'];
			$insid = $rows['instructions'];
			$array1['status']="success";
			$array1['instructions']=$ins;
				$array1['id']=$insid;
				
				
		     	$array1['time_remaining']="";
				$array1['time_taken']="";
				$array1['total_marks']="";
				$array1['obtain_marks']="";
				$array1['formula_id']="";
				$array1['right_answer_marks']="";
				$array1['wrong_answer_marks']="";
				$array1['reviewed_qus']="";
				$array1['attampted_ques']="";
				$array1['not_attampted_qus']="";
				$array1['total_qus']="";
				$array1['total_time']="";
				$array1['correct_ans']="";
				$array1['incorrect_ans']="";
				$array1['dt_created']="";
				$array1['test_id']="";
		}
		}
			
		
	}
	else
	{
		$array1['status']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
	mysqli_close($conn);
	
?>