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
	if (!empty($get_api)) 
	{
    $app_version = "6.38";
	$array1['app_version']=$app_version;
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