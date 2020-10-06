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
	$id = $_POST['id'];
	
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
			
			
		  $sel = "select * from cmsusertest_detail where usertest_id = '$id' AND question_id = '$question_id'";
$osd = mysqli_query($conn,$sel);
while($ssr = mysqli_fetch_array($osd))
{  $allg = $ssr['id'];}




	  $selq = "select * from cmsanswers where question_id = '$question_id' and is_correct='1'";
$osdq = mysqli_query($conn,$selq);
while($ssrq = mysqli_fetch_array($osdq))
{  $correct = $ssrq['id'];}

	  $selqt = "select * from cmsquestions join cmsquestiontypes on cmsquestions.type = cmsquestiontypes.id   where cmsquestions.id = '$question_id'";
$osdqt = mysqli_query($conn,$selqt);
while($ssrqt = mysqli_fetch_array($osdqt))
{  $types = $ssrqt['name'];}


if($allg > 0){

    $query_reqs1="UPDATE cmsusertest_detail SET users_answer = '$answer_id', is_correct = '$status' where  question_id = '$question_id' AND usertest_id = '$id'";
	 $obs = mysqli_query($conn,$query_reqs1);
	 
	 
	    
	    	$se = "SELECT * FROM cmsusertest_detail where usertest_id = '$id' AND question_id = '$question_id'";
			  $ob = mysqli_query($conn, $se);
			  while($row=mysqli_fetch_array($ob)){
				   $idd = $row['id'];
				    $is_correct = $row['is_correct'];
				  }
				  
		     $array1['id']="$id";
		     $array1['update_id']="$idd";
			 $array1['correct_status']="$is_correct";
				$array1['status']="Sucess";
	    
	}
	
	else {
		
		$tim = time();
		      $query_req1="INSERT INTO cmsusertest_detail (usertest_id,question_id,users_answer,correct_answer,is_correct,dt_created,perclick_time_spent,question_type) VALUES ('$id','$question_id','$answer_id','$correct','$status','$tim','$time','$types')";
			 $obs = mysqli_query($conn,$query_req1);
			 
		
	 
			$se = "SELECT * FROM cmsusertest_detail where usertest_id = '$id' AND question_id = '$question_id'";
			  $ob = mysqli_query($conn, $se);
			  while($row=mysqli_fetch_array($ob)){
				   $idd = $row['id'];
				    $is_correct = $row['is_correct'];
				  }
				  
		     $array1['id']="$idd";
		       $array1['update_id']="$idd";
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
	
	mysqli_close($conn);
	
?>