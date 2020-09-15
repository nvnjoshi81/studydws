<?php
error_reporting(0);
include("config.php");

 $package = $_POST['package']; 
  $ran_no = $_POST['ran_no'];
  $category_name;


  if($first > $ran_no  AND $last > $ran_no)
  $pac = "com.studyadda";
  
  /*$self = "select * from diff where $ran_no BETWEEN first and last and pac = '$package'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	*/ $tes_id = "123456TE123StudyYadda"; 
  //}



    if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($tes_id)) 
	{

    $name = $_POST['username'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$code = rand(1000,1599);
	$category = $_POST['category'];
	$device_id = $_POST['device_id'];
    $sel = "select * from cmscustomers where email = '$email' or mobile = '$mobile'";
	$userchk = mysqli_query($conn,$sel);
	$numrows = mysqli_num_rows($userchk);
	if(!($password == $re_pas)){
	    $data = array("response"=>array("status" => "false", "msg" => "Password does not match!"));
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
   
	   $ind = "INSERT INTO cmscustomers (firstname,email,otp,mobile,subject_id,user_key,device_id,status,is_app_registered, created_dt, usertype) VALUES ('$name','$email','$code','$mobile','$category','$userkey','$device_id','0','1','$dtnow','student')";
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
    $strSubject="Studyadda | OTP Verification";
    $message = '<br>';
    $message .= '<p>Your one time password is -</p>' ; 
    $message .= '<p> '.$code.'</p>' ; 
    $message .= '<p>Thankyou for connecting with us.</p>' ;
    $headers = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
    $headers .= "From: Studyadda OTP<info@studyadda.com>";            
    $mail_sent=mail($to, $strSubject, $message, $headers);
    //otp sending code
    $sms_text = urlencode('Hello, OTP for Studyadda is -'.$code );
    $api_key = '25BEBA1A42769C';
    $from = 'STDADA';
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "http://173.212.215.12/app/smsapi/index.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=4417&routeid=100815&type=text&contacts=".$mobile."&senderid=".$from."&msg=".$sms_text);
    $response = curl_exec($ch);
    curl_close($ch);
    $saveotp_query="update cmscustomers set otp='".$code."' where mobile=".$mobile;
    $stuinfo_obj = mysqli_query($conn, $saveotp_query) or
    die(mysqli_error($conn));
    //otp sending code ends
	} 
	else
	{
	$data = array("response"=>array("status" => "false", "msg" => "Email or Mobile Number already registered!", "email" => $email));			  
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

