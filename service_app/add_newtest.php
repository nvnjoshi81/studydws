<?php
error_reporting(0);

 include ('config.php');
 //header('Content-Type: application/json');
	
	
	$test_id = $_POST['test_id'];
	
	
	$device_id = $_POST['device_id'];
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	  while($ryu = mysqli_fetch_array($oppf)){
	$get_api = $ryu['user_key'];
	  }
  }
  
  
$array1=array();
	{
	if (!empty($_REQUEST['user_id'])&&($_REQUEST['test_id'])) 
		{
    $user_id = $_REQUEST['user_id'];
  
 $test_id = $_REQUEST['test_id'];
	


  $seld = "select * from cmsonlinetest where id = '$test_id'";
$osdd = mysqli_query($conn,$seld);
while($ssrd = mysqli_fetch_array($osdd))
{  $types = $ssrd['id'];
 $formula_id = $ssrd['formula_id'];
 $time = $ssrd['time'];
  
}

  $seld = "select * from cmsonlinetest_details where onlinetest_id = '$test_id'";
$osdd = mysqli_query($conn,$seld);
 $rco = mysqli_num_rows($osdd);

	
				
					$sep = "SELECT * FROM cmsonlinetest_formula where online_exam_formula_id = '$formula_id'";
			  $obp = mysqli_query($conn, $sep);
			  while($rowp=mysqli_fetch_array($obp)){
				   $right = $rowp['right_answer_marks'];
				    $wrong = $rowp['wrong_answer_marks'];
				  }
				  $totmark = $right*$rco;
				  
   $query_req1="INSERT INTO cmsusertest (user_id,test_id,formula_id,right_answer_marks,wrong_answer_marks,total_time,total_marks,total_qus) VALUES ('$user_id','$test_id','$formula_id','$right','$wrong','$time','$totmark','$rco')";
			 $obs = mysqli_query($conn,$query_req1);
			 
			  $sel = "select * from cmsusertest where test_id = '$test_id' AND user_id = '$user_id'";
$osd = mysqli_query($conn,$sel);
while($ssr = mysqli_fetch_array($osd))
{ $tid = $ssr['id'];

	}
	                $array1['id']="$tid";
			        $array1['test_id']="$test_id";
			        //$array1['correct_status']="$is_correct";
				    $array1['status']="Sucess";
	
	}
	else
	{
		$array1['status']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
?>