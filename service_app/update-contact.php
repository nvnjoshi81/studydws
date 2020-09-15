<?php
error_reporting(0);
include("config.php");

//code to send otp
$randomotp=rand(1000,9999);
if(!empty($_REQUEST['old-contact']) && !empty($_REQUEST['new-contact']) && !empty($_REQUEST['email']))
{
    $old_contact = $_REQUEST['old-contact'];$new_contact = $_REQUEST['new-contact'];$email = $_REQUEST['email'];
    $query = "select * from cmscustomers where mobile = '$old_contact' AND email = '$email' limit 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) 
    {
    $upstatus = "UPDATE cmscustomers SET mobile = '$new_contact' where mobile = '$old_contact'";
	$myqstatus = mysqli_query($conn, $upstatus);
	if($myqstatus)
	{
    $sms_text = urlencode('Hello, OTP for Studyadda is -'.$randomotp );
    $api_key = '25BEBA1A42769C';
    $from = 'STDADA';
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "http://173.212.215.12/app/smsapi/index.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=4417&routeid=100815&type=text&contacts=".$new_contact."&senderid=".$from."&msg=".$sms_text);
    $response = curl_exec($ch);
    curl_close($ch);
    $saveotp_query="update cmscustomers set otp='".$randomotp."' where mobile=".$new_contact;
    $stuinfo_obj = mysqli_query($conn, $saveotp_query) or
    die(mysqli_error($conn));
    echo json_encode(array("response"=>array('status'=>'true','msg'=>'OTP Sent Successfully!')));
	}
	else
	{
	    echo json_encode(array("response"=>array('status'=>'false','msg'=>'Unable to update contact. Please try again after sometime.')));
	}
    }
    else
    {
        echo json_encode(array("response"=>array('status'=>'false','msg'=>'Unable to update contact. Please try again after sometime.')));
    }

}
else
{
    echo json_encode(array("response"=>array('status'=>'false','msg'=>'Invalid Request')));
}
?>