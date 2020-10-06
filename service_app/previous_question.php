<?php
error_reporting(0);
include ('config.php');
$users_answer;
	
	$question_id = $_POST['question_id'];
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
	if (!empty($_REQUEST['user_id'])&&($_REQUEST['question_id'])&&($_REQUEST['id'])) 
		{
		  $sel = "select * from cmsusertest_detail where usertest_id = '$id' AND question_id = '$question_id'";
          $osd = mysqli_query($conn,$sel);
          if(mysqli_num_rows($osd)>0)
          {
          if($ssr = mysqli_fetch_array($osd))
          {  
              $users_answer = $ssr['users_answer'];
          }
          }
          else
          {
              $users_answer = "";
          }
        $array1['previous_answer']=$users_answer;
	    $array1['question_id']="$question_id";
	    $array1['status']="Success";
	    
	}
	else 
	{
		$array1['status']="Enter all fields";
	}

	echo json_encode($array1);
	
	mysqli_close($conn);
	
?>