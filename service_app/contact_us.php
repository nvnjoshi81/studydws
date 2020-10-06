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
	if (!empty($_REQUEST['user_id']) &&!empty($get_api)&&!empty($_POST['fullname'])&&!empty($_POST['email'])&&!empty($_POST['contact'])) 
	{
    $fullname = $_POST['fullname'];
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$timenow = strtotime("now");
	$filename = "studyadda";
	$type = "contact";
	$query_req1s="INSERT INTO cmscontact (firstname,email,mobile,created_dt,filename,type) VALUES ('$fullname','$email','$contact','$timenow','$filename','$type')";
	$obs = mysqli_query($conn, $query_req1s);
	$array1['status']="true";
	$array1['msg']="Thanks for connecting, we'll get back to you soon.";
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