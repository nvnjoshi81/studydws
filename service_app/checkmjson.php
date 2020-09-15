<?php
error_reporting(0);
	include('config.php');
    header('Content-Type: application/json; charset=utf-8');header('Content-Type: application/json');
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

    if($get_api)
    {
        $result = mysqli_query($conn,"SELECT * FROM cmssamplepapers_details where samplepaper_id = '$id'");	
    }

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['question_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
    if($subTmp)
    {
        $tmp['status'] = "success";$tmp['data'] = $subTmp; 
        
    }
	else 
	{
	$tmp['status'] = "false";
	$tmp['data'] = "no data";
	}
	echo json_encode($tmp,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
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
            $returnValue['id'] = $qid = $row['id'];
		
		$resultn = mysqli_query($conn,"SELECT * FROM cmsanswers where question_id = '$qid'");
		if($rown = mysqli_fetch_array($resultn)) 
		{
        $ansp = $rown['answer'];
        $ansp = utf8_encode($ansp);
        $ansp = strip_tags($ansp, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $ansp = htmlentities($ansp, ENT_QUOTES, "UTF-8");
        $ansp = preg_replace("!\r?\n!", "", $ansp);
        $ansp = str_replace("&nbsp;", "", $ansp);
        $ansp = str_replace("nbsp;", "", $ansp);
        $ansp = str_replace("&amp;", "", $ansp);
        $returnValue['answer'] = $ansp;
        
        }
		}
		return $returnValue;
	}
	
?>
