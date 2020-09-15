<?php 
//error_reporting(0);
 include ('config.php');
  	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];


 $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	  while($ryu = mysqli_fetch_array($oppf)){
 $get_api = $ryu['user_key'];
	  }
  }
  
  
  
  
$array1=array();
	{
		if (!empty($_POST['new_password'])&&($_POST['user_id'])&&($_POST['old_password'])&&($get_api)) 
		{
    $user_id = $_POST['user_id'];
	$new_password = md5($_POST['new_password']);
	$old_password = md5($_POST['old_password']);
	
     $sel = "select * from cmscustomers where id = '$user_id' and password = '$old_password'";
	$userchk = mysqli_query($conn, $sel);
	while($rot = mysqli_fetch_array($userchk))
	{
		 $uid = $rot['id'];
		  $old_pass = $rot['password'];
		}
	if ($user_id==$uid || $old_password==$old_pass)
	{
		 $upd = "UPDATE cmscustomers SET password='$new_password' where id='$user_id'";
		$osd = mysqli_query($conn, $upd);
		$array1['status']="true";
		$array1['msg']="Password changed successfully";
	}

	
		else
		{
			$array1['status']="false";
			$array1["msg"]= "Password not matched please enter correct old password";
		}
				
	
		}
		
	else
	{
		$array1['status']="false";
		
	}
	echo json_encode($array1);
	}
	
?>