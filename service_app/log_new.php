<?php
error_reporting(0);$status_msg="Success";
include("config.php");

    $package = $_POST['package']; 
    $ran_no = $_POST['ran_no'];
    function generate_random_password($length = 10) 
    {
    $alphabets = range('A','Z');
    $numbers = range('0','9');
    $additional_characters = array('_','.');
    $final_array = array_merge($alphabets,$numbers,$additional_characters);
    $passwordn = '';
    while($length--) 
    {
      $key = array_rand($final_array);
      $passwordn .= $final_array[$key];
    }
    return $passwordn;
    }

  if($first > $ran_no  AND $last > $ran_no)
  $pac = "com.studyaddaapp";
  
     $self = "select * from diff where $ran_no BETWEEN first and last and pac = '$package'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	 $tes_id = "123456TE123StudyYadda";
	  
  }
 
if (!empty($_POST['email']) && !empty($_POST['password'])&& !empty($tes_id) ) {
	

     $email = $_POST['email'];
     $pwd = $_POST['password'];
     $password = md5($_POST['password']);
	 $device_id = $_POST['device_id'];
	 $userkey = $_POST['user_key'];
    $up = "UPDATE cmscustomers SET user_key = 'SDWOC3MZX1.U' where user_key = ''";
	$opp = mysqli_query($conn, $up);
	
	 $sed = "SELECT * FROM cmscustomers where email = '$email' AND password = '$password'";
	$opd = mysqli_query($conn, $sed);
	$rrr = mysqli_num_rows($opd);
	if($rrr > 0){
	// updating device id for testing
	while($ree = mysqli_fetch_array($opd))
	{
	    $existing_device_id = $ree['device_id'];
	    if($existing_device_id != "")
	    {
	        $status_msg = "You'll be logged out of your other devices as you have logged in to this device.";
	    }
	}
	$up = "UPDATE cmscustomers SET device_id = '$device_id' where email = '$email' AND password = '$password'";
	$opp = mysqli_query($conn, $up);
	//end updating device id for testing
	while($ree = mysqli_fetch_array($opd))
	{
		  $deviceid = $ree['device_id'];
		  $dbuserkey = $ree['user_key'];
	}
		
	
		if($email) //if($device_id==$deviceid) for checking device id commenting for now
		{
			//echo "all Right";
      $query = "select * from cmscustomers where email='".$email."' and password='".$password."'";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0) 
      {
      $newarray = array();
      if ($roul = mysqli_fetch_array($result)) {
          $catid = $roul["subject_id"];
        $result = mysqli_query($conn,"SELECT * FROM categories WHERE id = '$catid'");
		if($row = mysqli_fetch_array($result)) 
		{			 
		$str = htmlentities($row['name'], ENT_QUOTES, "UTF-8");
    	$category_name = $str;
		}
		$data = array("response"=>array("status" => "true","username" => $roul["firstname"],"email" => $roul["email"], "user_id" => $roul["id"],"category_id" => $roul["subject_id"],"category_name" => $category_name,"user_key" => $roul["user_key"], "verified" => $roul["status"], "msg" => $status_msg));	  
           
        }
        }   
			
	}
			
			
			
	elseif($deviceid=="" || $userkey == "")
	{
	$userkey = "SD".$api_no =   generate_random_password(10) ;
	if($dbuserkey>"")
	{
	    $up = "UPDATE cmscustomers SET device_id = '$device_id' where email = '$email' AND password = '$password'";
	}
	else
	{
	$up = "UPDATE cmscustomers SET device_id = '$device_id', user_key = '$userkey' where email = '$email' AND password = '$password'";
	}
	$opp = mysqli_query($conn, $up);
	$query = "select * from cmscustomers where email='".$email."' and password='$password'";
    $result = mysqli_query($conn, $query);
    $numr = mysqli_num_rows($result);
    if ($numr > 0) 
    {
	$newarray = array();
    if ($row = mysqli_fetch_array($result)) 
    {
	$myuserd = $row['id'];
	$catid=$row["subject_id"];
	$result = mysqli_query($conn,"SELECT * FROM categories WHERE id = '$catid'");
	if($row1 = mysqli_fetch_array($result)) 
	{			 
	$str = htmlentities($row1['name'], ENT_QUOTES, "UTF-8");
	$category_name = $str;
	}
	$data = array("response"=>array("status" => "true","username" => $row["firstname"],"email" => $row["email"], "user_id" => $row["id"],"category_id" => $row["subject_id"],"category_name" => $category_name,"user_key" => $row["user_key"], "verified" => $row["status"], "msg" => "Success"));
	}
    }
	}
	elseif($device_id!=$deviceid)
	{
			 $data = array("response"=>array("status" => "false", "msg" => "Did you changed your Device? if that is the case please contact us at contact@studyadda.com Else we do not allow access on multiple devices."));
	}
	}
        else 
    {
		 $data = array("response"=>array("status" => "false", "msg" => "Invalid username and password "));
	
	}



	$newarray = $data;
	echo json_encode($newarray);
} 
else if(!empty($_POST['contact']) && !empty($_POST['password']))
{
     $contact = $_POST['contact'];
     $otp = $_POST['otp'];
     $password = md5($_POST['password']);
	 $device_id = $_POST['device_id'];
	 $userkey = $_POST['user_key'];
	 $sed = "SELECT * FROM cmscustomers where mobile = '$contact' AND password = '$password' limit 1";
	 $opd = mysqli_query($conn, $sed);
	 $rrr = mysqli_num_rows($opd);
	 if($rrr > 0)
	 {
	 while($ree = mysqli_fetch_array($opd))
	{
	    $existing_device_id = $ree['device_id'];
	    if($existing_device_id != "")
	    {
	        $status_msg = "You'll be logged out of your other devices as you have logged in to this device.";
	    }
	}
	 $up = "UPDATE cmscustomers SET device_id = '$device_id' where mobile = '$contact' AND password = '$password'";
	 $opp = mysqli_query($conn, $up);
	 while($ree = mysqli_fetch_array($opd))
     {
		  $deviceid = $ree['device_id'];
		  $dbuserkey = $ree['user_key'];
     }
     if($contact) 
	 {
	  $query = "select * from cmscustomers where mobile = '$contact' and password = '$password' limit 1";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0) 
      {
      $newarray = array();
      if ($roul = mysqli_fetch_array($result)) 
      {
        $catid = $roul["subject_id"];
        $upstatus = "UPDATE cmscustomers SET status = '1' where mobile = '$contact'";
	    $myqstatus = mysqli_query($conn, $upstatus);
        $result = mysqli_query($conn,"SELECT * FROM categories WHERE id = '$catid'");
		if($row = mysqli_fetch_array($result)) 
		{			 
		$str = htmlentities($row['name'], ENT_QUOTES, "UTF-8");
    	$category_name = $str;
		}
        $data = array("response"=>array("status" => "true","username" => $roul["firstname"],"email" => $roul["email"], "user_id" => $roul["id"],"category_id" => $roul["subject_id"],"category_name" => $category_name,"user_key" => $roul["user_key"], "verified" => "1", "msg" => "$status_msg"));
      }
      }
      else
      {
          echo json_encode(array("response"=>array('status'=>'false','msg'=>'Please enter correct OTP!')));
      }
	 }
	 }
	 else
      {
          echo json_encode(array("response"=>array('status'=>'false','msg'=>'Invalid Request')));
      }
	 $newarray = $data;
	echo json_encode($newarray);
}
else 
{
    //echo $_POST['contact'];
   echo json_encode(array("response"=>array('status'=>'false','msg'=>'Invalid Request')));
}
?>