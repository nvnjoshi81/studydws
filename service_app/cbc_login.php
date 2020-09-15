<?php
include('configfile.php');

$tmp = array();
$subTmp = array();
		$err=0;
		$errMsg='';
if(isset($_REQUEST['loginmobile'])&&$_REQUEST['loginmobile']!=''){
$loginmobile=$_REQUEST['loginmobile'];
}else{
$loginmobile='';
}

if(isset($_REQUEST['sotp'])){
	if($_REQUEST['sotp']!=''){
	$mobotp=$_REQUEST['sotp'];	
	}else{
		$err=$err+1;
		$errMsg .='Please Enter OTP.';
		$mobotp='';	
	}

}else{
$mobotp='';
}

if(isset($_REQUEST['loginpassword'])&&$_REQUEST['loginpassword']!=''){
$loginpassword=$_REQUEST['loginpassword'];
}else{
$loginpassword='';
}


		
		if($loginmobile==''){
		$err=$err+1;
		$errMsg .='Please Enter Mobile Number.';
		
		}else{
			//check for mobile exist/
			$arr_mobexist=check_mobExist($loginmobile,$conn);

		if(count($arr_mobexist)>0&&isset($arr_mobexist['visitor_mobile'])&&$arr_mobexist['visitor_mobile']!=''){
			$visitorId=$arr_mobexist['visitor_mobile'];
			$randomotp=rand(1000,9999);
			if($mobotp!=''){
			}else{
				/*Send OTP*/
				$api_key = '25BEBA1A42769C';
$contacts = $visitorId;
$from = 'SISSPS';
$sms_text = urlencode('Hello, OTP for Cute Kids Competiotion is -'.$randomotp );

//Submit to server

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, "http://173.212.215.12/app/smsapi/index.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=4417&routeid=100815&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
$response = curl_exec($ch);
curl_close($ch);
//echo $response;
				/*End Send OTP*/
				$saveotp_query="update school_visitor set mobotp='".$randomotp."' where visitor_mobile=".$visitorId;
				
					$stuinfo_obj = mysqli_query($conn, $saveotp_query) or
		die(mysqli_error($conn));
		$err=$err+1;
		$errMsg .='Please enter OTP sent on your Mobile Number -'.$visitorId;
			}
		}else{
		$err=$err+1;
		$errMsg .='Please Register Your Mobile Number First.';
		}
		}
		
		if($err>0){ 
		$data['errMsg']=$errMsg;
		$subTmp=array();
		}else{		
		$data['errMsg']='';
		if($visitorId>0){
		$stuinfo_array=check_userlogin($loginmobile,$loginpassword,$mobotp,$conn);
		if(isset($stuinfo_array['visitor_mobile'])&&$stuinfo_array['visitor_mobile']!=''){
		$sInfo = array();
        $sInfo['visitor_mobile'] =$stuinfo_array['visitor_mobile'];
		$sInfo['name'] = $stuinfo_array['name'];
		$subTmp[]=$sInfo;	
		}else{
		$errMsg .='Please Enter Correct Mobile/OTP.';
		$data['errMsg']=$errMsg;
		$err=$err+1;
		$subTmp=array();
		}
		
		}else{
			$err=$err+1;
		$data['errMsg']='There is some problem..';
		$subTmp=array();	
		}
		}
if(isset($subTmp)&&count($subTmp)>0){
	
	$tmp['status'] = "success";
	$tmp['response'] = $subTmp;
$tmp['message'] = 'OTP Varified!';	
	
	}else {
		
		if(!isset($mobotp)||$mobotp==''){	
		/*message when otp sent */
			$tmp['status'] = "success";
	$tmp['response'] = '';
$tmp['message'] = $data['errMsg'];	
		}else{
			
			
			$tmp['status'] = "fail";
			$tmp['response'] = "";
			$tmp['message'] = $data['errMsg']."User not LogedIn. Please try again.";
		}
		}
	echo json_encode($tmp);
	mysqli_close($conn);



	 function check_userlogin($mobNum,$pass='',$mobotp='',$conn){
		 if($mobotp!=''){
        $stuinfo_query="SELECT * FROM institute_visitor where visitor_mobile=".$mobNum." and mobotp=".$mobotp."";
		 }else  if($pass!=''){
		$stuinfo_query="SELECT * FROM institute_visitor where visitor_mobile=".$mobNum." and password=".$pass."";
		 }else{
			 $stuinfo_query="SELECT * FROM institute_visitor where visitor_mobile=".$mobNum;
		 }
		 
		if($mobNum>0){
				
				
		$stuinfo_obj = mysqli_query($conn, $stuinfo_query) or
		die(mysqli_error($conn));	
	}else{
	    return array();	
	}
	
	
	$stuinfo_numrows = mysqli_num_rows($stuinfo_obj);
	if($stuinfo_numrows > 0){
	$stuinfo_array = mysqli_fetch_array($stuinfo_obj);
	
		$rmotp_query="update institute_visitor set mobotp='' where visitor_mobile=".$mobNum;
			 mysqli_query($conn, $rmotp_query) or
		die(mysqli_error($conn));
	
	return $stuinfo_array;
}else{
	
	return array();
}
		
        return $query->result_array();
    }
	



 function getVisitor_info($visiterid,$conn){
		  $stuinfo_query = "SELECT id,visitor_catid,visitor_code,password,visitor_mobile,name,ipaddress,device FROM institute_visitor where id=".$visiterid;
	if($visiterid>0){
		$stuinfo_obj = mysqli_query($conn, $stuinfo_query) or
		die(mysqli_error($conn));	
	}else{
	    return array();	
	}
if (!$stuinfo_obj)
  {
  echo("Error description-: " . mysqli_error($conn));die;
  }
  
	$stuinfo_numrows = mysqli_num_rows($stuinfo_obj);
	if($stuinfo_numrows > 0){
	$stuinfo_array = mysqli_fetch_array($stuinfo_obj);
	
	return $stuinfo_array;
}else{
	
	return array();
}
}


 function check_mobExist($mobNum,$conn){
	  $stuinfo_query = "SELECT visitor_mobile                          FROM institute_visitor where visitor_mobile=".$mobNum;
	
	$stuinfo_obj = mysqli_query($conn, $stuinfo_query) or
			 die(mysqli_error($conn));
			 if (!$stuinfo_obj)
  {
  echo("Error description-: " . mysqli_error($conn));die;
  }
  
	$stuinfo_numrows = mysqli_num_rows($stuinfo_obj);
	if($stuinfo_numrows > 0){
	$stuinfo_array = mysqli_fetch_array($stuinfo_obj);
	
	return $stuinfo_array;
}else{
	
	return array();
}
}






/*
$userid='1';
$userid_two='5';
 echo $stuinfo_query = "SELECT * FROM students where id > '$userid' AND id < '$userid_two'";
	$stuinfo_obj = mysqli_query($conn, $stuinfo_query) or
			 die(mysqli_error($conn));
			 if (!$stuinfo_obj)
  {
  echo("Error description-: " . mysqli_error($conn));die;
  }
  
	$stuinfo_numrows = mysqli_num_rows($stuinfo_obj);
	if($stuinfo_numrows > 0){
	while($stuinfo_array = mysqli_fetch_array($stuinfo_obj))
	{
		print_r($stuinfo_array);
		
		$sInfo = array();
$sInfo['student_name'] =$stuinfo_array['student_name'];
		  $sInfo['student_email'] = $stuinfo_array['student_email'];
		  $sInfo['students_mobile'] = $stuinfo_array['students_mobile'];
		  $subTmp[]=$sInfo;
	}
	}
	
if(isset($subTmp)){
	$tmp['status'] = "success";
	$tmp['response'] = $subTmp; 
	}else {
		
			$tmp['status'] = "fail";
			$tmp['response'] = "";
			}
	echo json_encode($tmp);
	mysqli_close($conn); */
	
?>
