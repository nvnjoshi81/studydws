<?php
error_reporting(0);
	include('config.php');
header('Content-Type: application/json');
header('Content-Type: application/json; Charset=UTF-8');



	$device_id = $_POST['device_id'];
		$id = $_POST['id'];
	
	
		$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	  while($ryu = mysqli_fetch_array($oppf)){
	$get_api = $ryu['user_key'];
	  }
  }
  
  
  
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";

if($get_api){
    

 
	$result = mysqli_query($conn,"SELECT * FROM cmssolvedpapers_details where solvedpapers_id = '$id'");
	
	
}

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['question_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM cmsquestions where id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
         $str = $row['question'];
		 $str = utf8_encode($str);
         $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
         $str = htmlentities($str, ENT_QUOTES, "UTF-8");
         $str = preg_replace("!\r?\n!", "", $str);
         $str = str_replace("&nbsp;", "", $str);
         $str = str_replace("nbsp;", "", $str);
         $str = str_replace("&amp;", "", $str);
     	 $returnValue['question'] = $str;
     	 
         $returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);


			$returnValue['id'] = $qid = $row['id'];
			
			
		//	echo "SELECT * FROM cmsanswers where question_id = '$qid'";
				$resultn = mysqli_query($conn,"SELECT * FROM cmsanswers where question_id = '$qid' and is_correct = '1'");
		if($rown = mysqli_fetch_array($resultn)) 
		{

$ansp = $rown['description'];



$returnValue['answer'] = preg_replace('/[^A-Za-z0-9]/', ' ', $rown['answer']);
	$returnValue['and_desc'] = htmlentities($ansp, ENT_QUOTES, "UTF-8");

		$returnValue['answer_id'] = $rown['id'];
}
		}
		return $returnValue;
	}
	
?>
