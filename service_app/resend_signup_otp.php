<?php
error_reporting(0);
include("config.php");

 $package = $_POST['package']; 
  $ran_no = $_POST['ran_no'];


  if($first > $ran_no  AND $last > $ran_no)
  $pac = "com.studyaddaapp";
  
     $self = "select * from diff where $ran_no BETWEEN first and last and pac = '$package'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	$tes_id = "123456TE123StudyYadda";
	  
  }
  
  
if (!empty($_POST['email'])&& !empty($tes_id)) 
	{
	$email = $_POST['email'];
	
	$code = rand(1000,1599);
		
	 $sel = "select * from cmscustomers where email = '$email'";
	$userchk = mysqli_query($conn,$sel);
	  $numrows = mysqli_num_rows($userchk);
	
	if($numrows > 0){
	
		$update_staus=mysqli_query($conn,"update cmscustomers set otp='$code' where email='$email'");
		if(!empty($_POST['contact']))
        {
		$contacts = $_POST['contact'];
        $sms_text = urlencode('Hello, OTP for Studyadda is -'.$code );
        $api_key = '25BEBA1A42769C';
        $from = 'STDADA';
		$ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "http://173.212.215.12/app/smsapi/index.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=4417&routeid=100815&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
        $response = curl_exec($ch);
        curl_close($ch);
        }
		$to=$email;
        $strSubject="Studyadda | Signup OTP";
        $message = '<br>';
        $message .= '<p>Subject : - Your one time password for signup is -'.$code.'</p>';
        $message .= '<p>Thank you for connecting with us.</p>' ;
        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
        $headers .= "From: info@studyadda.com";            
        $mail_sent=mail($to, $strSubject, $message, $headers);
					 
	    $data = array("response"=>array("status" => "true", "msg" => "We have sent otp to your mobile/email address."));
	}
	else {
		 $data = array("response"=>array("status" => "false", "msg" => "Email not found."));}
	
	}//end first if
	else 
	{
    $data = array("response"=>array("status" => "false", "msg" => "error."));
    }

	$newarray = $data;
	echo json_encode($newarray);

?>

