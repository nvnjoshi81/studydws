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
  
  
  	$array1 = array();
	$array2 = array();
	$GET_status = "publish";
	
 if (!empty($_POST['email']) && !empty($tes_id))
	{

	 $email=$_POST['email'];
     $q="select * from cmscustomers where email='".$email."'";
   	 $r=mysqli_query($conn, $q);
	 $n= mysqli_num_rows($r);
    if($n == 0)
    { 

	$array1['status'] = 'Email id is not registered'; 
	}
	else
	{
   
        $otp = rand(1001,9000);
    	$upp = "update cmscustomers set otp = '$otp' where email='".$email."'";
    	$oss = mysqli_query($conn, $upp);
		$to=$email;
        $strSubject="Studyadda | Forget Password OTP";
        $message = '<br>';
        $message .= '<p>Your one time password for forget password is -'.$otp.'</p>' ; 
        $message .= '<p>Email : - info@studyadda.com</p>' ;
        $message .= '<p>Thankyou for connecting with us.</p>' ;
        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
        $headers .= "From: Studyadda OTP<info@studyadda.com>";            
        $mail_sent=mail($to, $strSubject, $message, $headers);
        while($row = mysqli_fetch_array($r)) {
        $mobile = $row['mobile'];
        $sms_text = urlencode('Hello, Your OTP for Studyadda is -'.$otp );
        $api_key = '25BEBA1A42769C';
        $from = 'STDADA';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "http://173.212.215.12/app/smsapi/index.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=4417&routeid=100815&type=text&contacts=".$mobile."&senderid=".$from."&msg=".$sms_text);
        $response = curl_exec($ch);
        curl_close($ch);
        }
      $array1['status'] = "We have sent otp to your email address and mobile number." ;
     }//else
	
  }//if(isset(email))
  else
  {
         $array1['status'] = ' Invalid GET\'';
  
  }

       
	   echo json_encode($array1);
	


