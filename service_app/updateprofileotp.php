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
	
 if (!empty($_POST['old_email']) && !empty($_POST['new_email']))
	{

	 $old_email=$_POST['old_email'];
	 $new_email=$_POST['new_email'];
	 $q="select email from cmscustomers where email='".$new_email."'";
   	 $r=mysqli_query($conn, $q);
	 $n= mysqli_num_rows($r);
    if($n > 0)
    { 

	$array1['status'] = 'Email already exists'; 
	}
	else
	{
   
   $otp = rand(1001,9000);
	$upp = "update cmscustomers set otp = '$otp' where email='".$old_email."'";
	$oss = mysqli_query($conn, $upp);

	  $to=$old_email;
      $strSubject="Studyadda | Email Change OTP";
      $message = '<br>';
      $message .= '<p>Subject : - Your one time password for changing email to '.$new_email.' is -'.$otp.'</p>' ; 
      $message .= '<p>Email : - info@studyadda.com</p>' ;
      $message .= '<p>Thankyou for connection with us.</p>' ;
     $headers = 'MIME-Version: 1.0'."\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
     $headers .= "From: info@studyadda.com";            
     $mail_sent=mail($to, $strSubject, $message, $headers);
     $array1['status'] = "We have sent otp to your email address." ;
     }//else
	
  }//if(isset(email))
  else
  {
         $array1['status'] = ' Invalid GET\'';
  
  }

       
	   echo json_encode($array1);
	


