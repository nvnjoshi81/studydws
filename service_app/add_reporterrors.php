<?php
    error_reporting(0);
    $tim = time();
    include ('config.php');
    $user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
    $oppf = mysqli_query($conn, $self);
    $rww = mysqli_num_rows($oppf);
    if($rww > 0){
	  while($ryu = mysqli_fetch_array($oppf))
	  {
	    $get_api = $ryu['user_key'];
	  }
    }
    $array1=array();
	{
	if (!empty($_REQUEST['user_id']) &&!empty($get_api) &&!empty($_POST['question_id']) &&!empty($_POST['error']) &&!empty($_POST['comment'])) 
	{
    $question_id = $_POST['question_id'];
	$user_id = $_POST['user_id'];
	$error = $_POST['error'];
	$comment = $_POST['comment'];
	$query_req1s="INSERT INTO cms_reporterrors (question_id,user_id,error,comment) VALUES ('$question_id','$user_id','$error','$comment')";
	$obs = mysqli_query($conn, $query_req1s);
	$array1['status']="true";
	$array1['msg']="Thank you for your suggestion, we'll look into it.";
	}
	else
	{
	$array1['status']="false";
	$array1['msg']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
	mysqli_close($conn);
?>