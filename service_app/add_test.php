<?php
error_reporting(0);

 include ('config.php');
 //header('Content-Type: application/json');
	
	$status = $_POST['status'];
	$question_id = $_POST['question_id'];
	$answer_id = $_POST['answer_id'];
	$correct_id = $_POST['correct_id'];
	$test_id = $_POST['test_id'];
		$formula_id = $_POST['formula_id'];
			$time = $_POST['time'];
	
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
	if (!empty($_REQUEST['user_id'])&&($_REQUEST['question_id'])) 
		{
    $user_id = $_REQUEST['user_id'];
    $question_id = $_REQUEST['question_id'];
	$status = $_REQUEST['status'];
	

   $sel = "select * from cmsusertest where test_id = '$test_id' AND user_id = '$user_id'";
$osd = mysqli_query($conn,$sel);
while($ssr = mysqli_fetch_array($osd))
{  $tid = $ssr['id'];

	}
	
	
	 $seld = "select * from cmsquestiontypes where id = '$question_id'";
$osdd = mysqli_query($conn,$seld);
while($ssrd = mysqli_fetch_array($osdd))
{  $types = $ssr['id'];

	}


		
		if($tid > 0)
		//	if($tids > 0)
		{
		    
		  
		    
  $sel = "select * from cmsusertest_detail where usertest_id = '$tid' AND question_id = '$question_id'";
$osd = mysqli_query($conn,$sel);
while($ssr = mysqli_fetch_array($osd))
{  $allg = $ssr['id'];

	}
	
	if($allg > 0){
	    
	      echo $query_reqs1="UPDATE cmsusertest_detail SET correct_answer = '$correct_id', is_correct = '$status' where  question_id = '$question_id' AND usertest_id = '$tid'";
	 $obs = mysqli_query($conn,$query_reqs1);
	 
	 
	    
	    	$se = "SELECT * FROM cmsusertest_detail where usertest_id = '$tid' AND question_id = '$question_id'";
			  $ob = mysqli_query($conn, $se);
			  while($row=mysqli_fetch_array($ob)){
				   $idd = $row['id'];
				    $is_correct = $row['is_correct'];
				  }
				  
		     $array1['id']="$idd";
		     $array1['update_id']="$tid";
			 $array1['correct_status']="$is_correct";
				$array1['status']="Sucess";
	    
	}
	else {
			 
			 
				$tim = time();
		   echo   $query_req1="INSERT INTO cmsusertest_detail (usertest_id,question_id,users_answer,correct_answer,is_correct,dt_created,perclick_time_spent,question_type) VALUES ('$tid','$question_id','$answer_id','$correct_id','$status','$tim','$time','$types')";
			 $obs = mysqli_query($conn,$query_req1);
			 
		
	 
			$se = "SELECT * FROM cmsusertest_detail where usertest_id = '$tid' AND question_id = '$question_id'";
			  $ob = mysqli_query($conn, $se);
			  while($row=mysqli_fetch_array($ob)){
				   $idd = $row['id'];
				    $is_correct = $row['is_correct'];
				  }
				  
		     $array1['id']="$idd";
		       $array1['update_id']="$tid";
			 $array1['correct_status']="$is_correct";
				$array1['status']="Sucess";
				
			
			
				  
       
		}}
		else
		{
		
				$tim = time();
				
					$sep = "SELECT * FROM cmsonlinetest_formula where online_exam_formula_id = '$formula_id'";
			  $obp = mysqli_query($conn, $sep);
			  while($rowp=mysqli_fetch_array($obp)){
				   $right = $rowp['right_answer_marks'];
				    $wrong = $rowp['wrong_answer_marks'];
				  }
				  
				  
   $query_req1="INSERT INTO cmsusertest (user_id,test_id,formula_id,right_answer_marks,wrong_answer_marks) VALUES ('$user_id','$test_id','$formula_id','$right','$wrong')";
			 $obs = mysqli_query($conn,$query_req1);
			 
			  $sel = "select * from cmsusertest where test_id = '$test_id' AND user_id = '$user_id'";
$osd = mysqli_query($conn,$sel);
while($ssr = mysqli_fetch_array($osd))
{ $tid = $ssr['id'];

	}
	
	
		
			    $query_req1="INSERT INTO cmsusertest_detail (usertest_id,question_id,users_answer,correct_answer,is_correct,dt_created,question_type) VALUES ('$tid','$question_id','$answer_id','$correct_id','$status','$tim','$types')";
			 $obs = mysqli_query($conn,$query_req1);
			 
			 
	$se = "SELECT * FROM cmsusertest_detail where usertest_id = '$tid' AND question_id = '$question_id'";
			  $ob = mysqli_query($conn, $se);
			  while($row=mysqli_fetch_array($ob)){
				   $idd = $row['id'];
				    $is_correct = $row['is_correct'];
				  }
				  
		     $array1['id']="$idd";
		       $array1['update_id']="$tid";
			 $array1['correct_status']="$is_correct";
				$array1['status']="Sucess";
	
		}
			
		
	}
	else
	{
		$array1['status']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
?>