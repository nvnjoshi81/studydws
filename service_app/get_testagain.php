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

		
		$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest  where id = '$id'");
		if($rows = mysqli_fetch_array($result)) 
		{
			$ins = $rows['instructions'];
			$insid = $rows['instructions'];
			$array1['status']="success";
			$array1['instructions']=$ins;
				$array1['id']=$insid;
					$array1['test_title']=$rows['name'];;
				
				
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
				$array1['test_id']=$id;
		}
		
			
		
	}
	else
	{
		$array1['status']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
?>