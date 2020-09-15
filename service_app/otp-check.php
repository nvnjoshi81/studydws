<?php
error_reporting(0);
header("Content-type:application/json");
include("config.php");

//code to send otp
$randomotp=rand(1000,9999);
if(!empty($_REQUEST['contact']))
{
    $contacts = $_POST['contact'];
    $query = "select * from cmscustomers where mobile = '$contacts' limit 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) 
    {
    $sms_text = urlencode('Hello, OTP for Studyadda is -'.$randomotp );
    $api_key = '25BEBA1A42769C';
    $from = 'STDADA';
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "http://173.212.215.12/app/smsapi/index.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=4417&routeid=100815&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
    $response = curl_exec($ch);
    curl_close($ch);
    $saveotp_query="update cmscustomers set otp='".$randomotp."' where mobile=".$contacts;
    $stuinfo_obj = mysqli_query($conn, $saveotp_query) or
    die(mysqli_error($conn));
    echo json_encode(array("response"=>array('status'=>'true','msg'=>'OTP Sent Successfully!')));
    }
    else
    {
        echo json_encode(array("response"=>array('status'=>'false','msg'=>'Mobile Number Not Registered, Please register first!')));
    }

}
else if(!empty($_REQUEST['email']))
{
    $email = $_POST['email'];
    $query = "select * from cmscustomers where email = '$email' limit 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) 
    {
    
    $code = rand(1000,1599);
    $to=$email;
    $strSubject="Studyadda | One Time Password Verification";
    $message = '<br>';
    $message .= '<p>Subject : - your one time password is -</p>' ; 
    $message .= '<p> '.$code.'</p>' ; 
    $message .= '<p>thankyou for connecting with us.</p>' ;
    $headers = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
    $headers .= "From: info@studyadda.com";            
    $mail_sent=mail($to, $strSubject, $message, $headers);
    $saveotp_query="update cmscustomers set otp='".$code."' where email='".$email."'";
    $stuinfo_obj = mysqli_query($conn, $saveotp_query) or
    die(mysqli_error($conn));
    echo json_encode(array("response"=>array('status'=>'true','msg'=>'OTP Sent Successfully!')));
    }
    else
    {
        echo json_encode(array("response"=>array('status'=>'false','msg'=>'Email Not Registered, Please register first!')));
    }
}
else
{
    echo json_encode(array("response"=>array('status'=>'false','msg'=>'Invalid Request')));
}
?>