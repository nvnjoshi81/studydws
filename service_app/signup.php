<?php
error_reporting(0);
include("config.php");

 $package = $_POST['package']; 
  $ran_no = $_POST['ran_no'];
  $category_name;


  if($first > $ran_no  AND $last > $ran_no)
  $pac = "com.studyadda";
  
    $self = "select * from diff where $ran_no BETWEEN first and last and pac = '$package'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	 $tes_id = "123456TE123StudyYadda";
	  
  }



if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($tes_id)) 
	{

    $name = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$mobile = $_POST['mobile'];
	$re_pas = $_POST['re_pas'];
	$code = rand(1000,1599);
		$category = $_POST['category'];
		$device_id = $_POST['device_id'];
		$passwordnew = md5($_POST['password']);

	 $sel = "select * from cmscustomers where email = '$email'";
	$userchk = mysqli_query($conn,$sel);
	  $numrows = mysqli_num_rows($userchk);
	
	if(!($password == $re_pas)){
	    $data = array("response"=>array("status" => "false", "msg" => "password does not match!"));
	}else{

	if ($numrows < 1)
	{
	    
	     function generate_random_password($length = 10) {
    $alphabets = range('A','Z');
    $numbers = range('0','9');
    $additional_characters = array('_','.');
    $final_array = array_merge($alphabets,$numbers,$additional_characters);
  $passwordn = '';
    while($length--) {
      $key = array_rand($final_array);
      $passwordn .= $final_array[$key];
    }
  
    return $passwordn;
  }
   $userkey = "SD".$api_no =   generate_random_password(10) ;
   $dtnow = strtotime("now");
   
	   $ind = "INSERT INTO cmscustomers (firstname,email,password,otp,mobile,subject_id,user_key,device_id,status,is_app_registered, created_dt, usertype) VALUES ('$name','$email','$passwordnew','$code','$mobile','$category','4013e71b5ca48c3f','$device_id','0','1','$dtnow','student')";
			 $ob = mysqli_query($conn,$ind);
			  $se = "SELECT * FROM cmscustomers where email='$email'";
			  $ob = mysqli_query($conn,$se);
			  $row=mysqli_fetch_array($ob);
			  $re=$row['email'];
			  $re_id=$row['id']; 
			  $name=$row['firstname'];
			  $subject_id = $row['subject_id'];
			  $status=$row['status']; 
			  $user_keys=$row['user_key'];
			  $device_ids=$row['device_id'];
	$comm1 = "select * from categories where id = '$subject_id'";
    $comme1 = mysqli_query($conn,$comm1);
    while($blorow1 = mysqli_fetch_array($comme1))
    { 
    $category_name = $blorow1['name'];
    }		 
    $status=$row['status']; 
	$data = array("response"=>array("email" => $re,"username" => $name,"user_id" => $re_id,"category_id" => "$subject_id","category_name" => "$category_name","user_key" => $user_keys,"device_id" => $device_ids,"otp" => $code, "status" => "true","verify_status" => "$status", "msg" => "Success , account verifaction otp send your email address. "));	 
	$to=$email;
      $strSubject="Studyadda | One Time Password Registration";
      $message = '<br>';
      $message .= '<p>Subject : - Your one time password is -</p>' ; 
      $message .= '<p> '.$code.'</p>' ; 
      $message .= '<p>Thank You for connecting with us.</p>' ;
      $headers = 'MIME-Version: 1.0'."\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
      $headers .= "From: info@studyadda.com";            
      $mail_sent=mail($to, $strSubject, $message, $headers);
	} 
	else
	{
	$data = array("response"=>array("status" => "false", "msg" => "Email/Mobile No. already registered. Please Login.", "email" => $email));			  
	}
	
	}//ik
	
	}//end first if
	else 
	{
    $data = array("response"=>array("status" => "false", "msg" => "Enter all parameters!"));
    }

	$newarray = $data;
	echo json_encode($newarray);

?>

