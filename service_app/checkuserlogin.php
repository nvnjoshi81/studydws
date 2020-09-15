<?php
    error_reporting(0);
	include('config.php');
	$user_key = $_POST['user_key'];
    $user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$tmp = array();
	$self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'";
    $oppf = mysqli_query($conn, $self);
    $rww = mysqli_num_rows($oppf);
    if($rww > 0)
    {
	$tmp['status'] = "success";$tmp['msg'] = "User id and device id matched";
	}
	else
	{
	    $tmp['status'] = "false";$tmp['msg'] = "User id and device id mismatched";
	}
	$tmp['status'] = "success";$tmp['msg'] = "User id and device id matched";
    echo json_encode($tmp);
  ?>
