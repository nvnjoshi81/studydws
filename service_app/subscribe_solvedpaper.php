<?php
	include('config.php');
	
			$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
		$category = $_POST['class_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];
	$device_id = $_POST['device_id'];
	
		if($subject_id > 0){
	    $sub = "and subject_id = '$subject_id'";
	}
	else {
	  $sub = "";  
	}
	
		if($chapter_id > 0){
	    $chh = "and chapter_id = '$chaptert_id'";
	}
	else {
	  $chh = "";  
	}
	
	
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
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
    //echo "SELECT * FROM cmsonlinetest_relations join cmsonlinetest on cmsonlinetest_relations.onlinetest_id=cmsonlinetest.id where cmsonlinetest_relations.exam_id = '$category' and cmsonlinetest.created_from = 'sample-papers'";
	$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest_relations join cmsonlinetest on cmsonlinetest_relations.onlinetest_id=cmsonlinetest.id where cmsonlinetest_relations.exam_id = '$category' and cmsonlinetest.created_from = 'solved-papers'");
}
	
	while($row = mysqli_fetch_array($result)) {
		  $mar_id = $row['id']; 
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest  where id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		    
		
			$returnValue['name'] = $row['name'];
	
		//	$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
			$returnValue['exam_id'] = $row['exam_id'];
			$returnValue['subject_id'] = $row['subject_id'];
			$returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['formula_id'] = $row['formula_id'];
			$returnValue['time'] = $row['time'];
			$returnValue['calculater'] = $row['calculater'];
			$returnValue['qus_pdf'] = $row['qus_pdf'];
			$returnValue['ans_pdf'] = $row['ans_pdf'];
			$returnValue['total_question'] = "20";//just for calling web url
			$returnValue['solution_pdf'] = $row['solution_pdf'];
		
			$returnValue['view_count'] = $row['view_count'];
		
			$returnValue['id'] = $iid = $row['id'];
			
		
		
			
		}
		return $returnValue;
	}
	
?>
