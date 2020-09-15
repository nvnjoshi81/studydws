<?php
error_reporting(0);
	include('config.php');
header('Content-Type: application/json');
header('Content-Type: application/json; Charset=UTF-8');



	$device_id = $_POST['device_id'];
		$id = $_POST['id'];
	
	
		$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
  $self = "select * from cmscustomers where user_key = '123' and id = '115493' and device_id = 'e0356e9256148c93'";
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
    

  
	$result = mysqli_query($conn,"SELECT * FROM cmssamplepapers_details where samplepaper_id = '46' limit 1");
	
	
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
		
		$result = mysqli_query($conn,"SELECT * FROM cmsanswers where id = '739734'");
		if($row = mysqli_fetch_array($result)) 
		{

		
		$str = $row['answer'];
        $str = utf8_encode($str);
        $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $str = htmlentities($str, ENT_QUOTES, "UTF-8");
        $str = preg_replace("!\r?\n!", "", $str);
        $str = str_replace("&nbsp;", "", $str);
        $returnValue['question'] = $str;
        $returnValue['question_id'] = $row['id'];
		}
		return $returnValue;
	}
	
?>
