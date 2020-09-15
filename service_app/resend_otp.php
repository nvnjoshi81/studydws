<?php
error_reporting(0);
include("config.php");

 $package = $_POST['package']; 
  $ran_no = $_POST['ran_no'];


  if($first > $ran_no  AND $last > $ran_no)
  $pac = "com.studyadda";
  
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
		
	//	echo "update cmscustomers set otp='$code' where email='$email'";
		$update_staus=mysqli_query($conn,"update cmscustomers set otp='$code' where email='$email'");
		
		       $to=$email;
                    
                      $strSubject="study-adda | verifaction";
                    $message = '<br>';
                       $message .= '<p>Subject : - your one time password is -</p>' ; 
                  
                    $message .= '<p> '.$code.'</p>' ; 
                    // $message .= '<p>Email : - webbinart@gmail.com</p>' ;
                      $message .= '<p>thankyou for connection with us.</p>' ;

                        $headers = 'MIME-Version: 1.0'."\r\n";
                     $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                     $headers .= "From: info@studyadda.com";            
                     $mail_sent=mail($to, $strSubject, $message, $headers);
					 
	    $data = array("response"=>array("status" => "true", "msg" => "Otp send in your email address."));
	}
	else {
		 $data = array("response"=>array("status" => "false", "msg" => "email not found."));}
	
	}//end first if
	else 
	{
    $data = array("response"=>array("status" => "false", "msg" => "error."));
    }

	$newarray = $data;
	echo json_encode($newarray);

?>

