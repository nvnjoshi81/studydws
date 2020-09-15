<?php
	include('config.php');
	error_reporting(0);
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];

	$test_id = $_POST['test_id'];
	
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

  //echo "SELECT * FROM cmsusertest join cmsusertest_detail on cmsusertest.test_id = cmsusertest_detail.usertest_id where cmsusertest.user_id = '$user_id' and cmsusertest.test_id='$test_id' order by cmsusertest.id desc limit 1";
	$result = mysqli_query($conn,"SELECT * FROM cmsusertest join cmsusertest_detail on cmsusertest.test_id = cmsusertest_detail.usertest_id where cmsusertest.user_id = '$user_id' and cmsusertest.test_id='$test_id' order by cmsusertest.id desc " );
	

	
	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['question_id']; 
		$job = array();
		$job = getmarvelcategoryn($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['datatwo'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['datatwo'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategoryn($mar_id,$conn) {		
		$returnValue = array();
		
	//echo "SELECT * FROM cmsquestions where id = '$mar_id'";
		$result = mysqli_query($conn,"SELECT * FROM cmsquestions where id = '$mar_id'");
		if($rows = mysqli_fetch_array($result)) 
		{
			$str = $rows['question'];
		
		 $str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
            $returnValue['question'] = $str;
            
            
			$returnValue['id'] =$iid= $rows['id'];
		$tty = $rows['type'];
			
			$resultss = mysqli_query($conn,"SELECT * FROM cmsquestiontypes where id = '$tty'");
		if($rowsss = mysqli_fetch_array($resultss)) 
		{
			 $returnValue['type'] = $rowsss['name'];
			
		}
			
		//	echo "SELECT * FROM cmsusertest_detail join cmsanswers on cmsusertest_detail.users_answer=cmsanswers.id where cmsusertest_detail.question_id = '$iid'";
			
		$resultf = mysqli_query($conn,"SELECT * FROM cmsusertest_detail join cmsanswers on cmsusertest_detail.users_answer=cmsanswers.id where cmsusertest_detail.question_id = '$iid'");
		if($rowsf = mysqli_fetch_array($resultf)) 
		{
			$returnValue['your_answer_id'] = $rowsf['users_answer'];
			$returnValue['timetaken'] = $rowsf['perclick_time_spent'];
		$ansp = $rowsf['answer'];
			

        $ansp = utf8_encode($ansp);
        $ansp = strip_tags($ansp, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $ansp = htmlentities($ansp, ENT_QUOTES, "UTF-8");
        $ansp = preg_replace("!\r?\n!", "", $ansp);
        $ansp = str_replace("&nbsp;", "", $ansp);
        $ansp = str_replace("nbsp;", "", $ansp);
        $ansp = str_replace("&amp;", "", $ansp);
        $returnValue['your_answer'] = $ansp;
        
        
		}
		
			
		$results = mysqli_query($conn,"SELECT * FROM cmsanswers where question_id = '$iid' and is_correct = '1'");
		if($rowss = mysqli_fetch_array($results)) 
		{
			$anspc = $rowss['answer'];
			
			 $anspc = utf8_encode($anspc);
        $anspc = strip_tags($anspc, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $anspc = htmlentities($anspc, ENT_QUOTES, "UTF-8");
        $anspc = preg_replace("!\r?\n!", "", $anspc);
        $anspc = str_replace("&nbsp;", "", $anspc);
        $anspc = str_replace("nbsp;", "", $anspc);
        $anspc = str_replace("&amp;", "", $anspc);
        $returnValue['your_answer'] = $anspc;
        
        
		}
		
			
		}
		return $returnValue;
	}
	
?>
