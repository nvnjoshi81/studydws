<?php 
	include ('config.php');
	 	 $test_id = $_POST['test_id'];
	 	 	$user_key = $_POST['user_key'];
     	$user_id = $_POST['user_id'];
		$device_id = $_POST['device_id'];
			$id = $_POST['id'];
	
	
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
   // echo "SELECT * FROM cmsorders where user_id = '$user_id'";
	$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest_details where onlinetest_id = '$test_id'");
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

	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
	
		$result = mysqli_query($conn,"SELECT * FROM cmsquestions WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		    	//$returnValue['question'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['question']);
			$str = $row['question'];
    		$str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
         	$returnValue['question'] = $str;
            $returnValue['id'] = $iid = $row['id'];
            
            
			$returnValue['id'] = $qid = $row['id'];
				$id = $_POST['id'];
			//	echo "SELECT * FROM cmsusertest_detail where   usertest_id  = '$id' AND question_id='$iid'";
	$resultd = mysqli_query($conn,"SELECT * FROM cmsusertest_detail where   usertest_id  = '$id' AND question_id='$qid'");
		if($rowd = mysqli_fetch_array($resultd)) 
		{
		    $returnValue['status_question'] = $rowd['is_correct'];
		}	
		else { $returnValue['status_question'] = "" ;}
		
		
		
		}
		return $returnValue;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	
	$tmp = array();
		$subTmp = array();
		$postStatusString = "publish";

	$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest_details where onlinetest_id = '$test_id'");
		
		
		while($row = mysqli_fetch_array($result)) {
			 $mar_id = $row['question_id'];
			$job = array();
			$job = getcoursebycat($mar_id,$conn);
			$subTmp[] = $job;
		}
		$tmp['status'] = "success";
		if($subTmp){
		//$tmp['data2'] = "Invalid key";
		
			$tmp['data'] = $subTmp;
		}
		else {
			$tmp['data'] = "Invalid key";
		
			}
		echo json_encode($tmp);
	
		
		function getcoursebycat($mar_id,$conn) {		
			$returnValue = array();
		    //echo "SELECT * FROM cmsonlinetest_details WHERE onlinetest_id = '$mar_id'";
			$result = mysqli_query($conn, "SELECT * FROM cmsquestions WHERE id = '$mar_id'");
			while($row = mysqli_fetch_array($result)) 
			{
			//$returnValue['question'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['question']);
			$str = $row['question'];
    		$str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
         	$returnValue['question'] = $str;
            $returnValue['id'] = $iid = $row['id'];;
			$result = mysqli_query($conn,"SELECT * FROM cmsanswers WHERE question_id = '$iid'");
        	while($row = mysqli_fetch_array($result)) 
        	{
        	    $chapid = $row['id'];
        		$chap = getchapbysub($chapid,$conn);
        		$subchap[] = $chap;
        		$returnValue['answer'] = $subchap;
        	}
			}
	        	return $returnValue;
		}
		
		function getchapbysub($chapid,$conn) {
		    
		    
		$returnValue = array();
//	echo "SELECT * FROM cmsanswers where id = '$chapid' " ;
		$result = mysqli_query($conn, "SELECT * FROM cmsanswers where id = '$chapid' ");
		while($row = mysqli_fetch_array($result)) 
		{

		 //$returnValue['answer'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['answer']);
    		$str = $row['answer'];
    		$str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
         	$returnValue['answer'] = $str;
            $returnValue['answer_id']  = 	$row['id'];
            $returnValue['answer_correct']  = 	$row['is_correct'];
	
		}
		
	
		return $returnValue;	
		
		}*/
		
  mysqli_close($conn);
  ?>
 
