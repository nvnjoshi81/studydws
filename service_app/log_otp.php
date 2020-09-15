<?php
error_reporting(0);
header("Content-type:application/json");
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
 
if (!empty($_POST['email']) && !empty($_POST['otp'])) {
	

    $email = $_POST['email'];
    $otp = $_POST['otp'];
	 $device_id = $_POST['device_id'];
	 $userkey = $_POST['user_key'];
    
	
	 $sed = "SELECT * FROM cmscustomers where email = '$email' AND otp = '$otp'";
	$opd = mysqli_query($conn, $sed);
	$rrr = mysqli_num_rows($opd);
	if($rrr > 0){
	// updating device id for testing
	$up = "UPDATE cmscustomers SET device_id = '$device_id' where email = '$email' AND otp = '$otp'";
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
      $query = "select * from cmscustomers where email='".$email."' AND otp = '$otp'";
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
		$data = array("response"=>array("status" => "true","username" => $roul["firstname"],"email" => $roul["email"], "user_id" => $roul["id"],"category_id" => $roul["subject_id"],"category_name" => $category_name,"user_key" => $roul["user_key"], "verified" => $roul["status"], "msg" => "Success"));	  
           
        }
        }   
			
	}
	elseif($deviceid=="" || $userkey == "")
	{
	$userkey = "SD".$api_no =   generate_random_password(10) ;
	if($dbuserkey>"")
	{
	    $up = "UPDATE cmscustomers SET device_id = '$device_id' where email = '$email' AND otp = '$otp'";
	}
	else
	{
	$up = "UPDATE cmscustomers SET device_id = '$device_id', user_key = '$userkey' where email = '$email' AND otp = '$otp'";
	}
	$opp = mysqli_query($conn, $up);
	$query = "select * from cmscustomers where email='".$email."' AND otp = '$otp'";
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
		 $data = array("response"=>array("status" => "false", "msg" => "Invalid OTP!"));
	
	}



	$newarray = $data;
	echo json_encode($newarray);
} 
else if(!empty($_POST['contact']) && !empty($_POST['otp']))
{
     $contact = $_POST['contact'];
     $otp = $_POST['otp'];
	 $device_id = $_POST['device_id'];
	 $userkey = $_POST['user_key'];
	 $sed = "SELECT * FROM cmscustomers where mobile = '$contact' AND otp = '$otp' limit 1";
	 $opd = mysqli_query($conn, $sed);
	 $rrr = mysqli_num_rows($opd);
	 if($rrr > 0)
	 {
	 $up = "UPDATE cmscustomers SET device_id = '$device_id' where mobile = '$contact' AND otp = '$otp'";
	 $opp = mysqli_query($conn, $up);
	 while($ree = mysqli_fetch_array($opd))
     {
		  $deviceid = $ree['device_id'];
		  $dbuserkey = $ree['user_key'];
     }
     if($contact) 
	 {
	  $query = "select * from cmscustomers where mobile = '$contact' AND otp = '$otp' limit 1";
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
        $data = array("response"=>array("status" => "true","username" => $roul["firstname"],"email" => $roul["email"], "user_id" => $roul["id"],"category_id" => $roul["subject_id"],"category_name" => $category_name,"user_key" => $roul["user_key"], "verified" => "1", "msg" => "Success"));
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
          echo json_encode(array("response"=>array('status'=>'false','msg'=>'Invalid OTP!')));
      }
	 $newarray = $data;
	echo json_encode($newarray);
}
else 
{

    echo json_encode(array("response"=>array('status'=>'false','msg'=>'Invalid Request')));
}
?>