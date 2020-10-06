<?php
error_reporting(0);
	include('config.php');
	
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$category_id = $_POST['category_id'];
	$created_from_id = $_POST['created_from_id'];
	//SELECT DISTINCT cmssubjects.name as subject, cmssubjects.id FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest_relations.exam_id = '$category_id' AND cmsonlinetest.created_from_id = '$created_from_id' ORDER BY cmsonlinetest.olcategory_id DESC
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
if(1){
   // echo "SELECT * FROM cmsorders where user_id = '$user_id'";
	$result = mysqli_query($conn,"SELECT cmsonlinetest.name, cmsonlinetest.id , cmsonlinetest.created_from, cmsonlinetest.created_from_id, cmsonlinetest.olcategory_id, cmsonlinetest_relations.exam_id, cmsonlinetest_relations.subject_id, cmsonlinetest_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest_relations.exam_id = '$category_id' AND cmsonlinetest.created_from_id = '$created_from_id'   ORDER BY cmsonlinetest.olcategory_id DESC");
}
	
	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);

	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		//echo "SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest.exam_id, cmsonlinetest.subject_id, cmsonlinetest.chapter_id, cmsonlinetest.formula_id 
		//, cmsonlinetest.time, cmsonlinetest.calculater, cmsonlinetest.qus_pdf, cmsonlinetest.ans_pdf, cmsonlinetest.solution_pdf, cmsonlinetest.view_count FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest.id = '$mar_id'";
		$result = mysqli_query($conn,"SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest.exam_id, cmsonlinetest.subject_id, cmsonlinetest.chapter_id, cmsonlinetest.formula_id 
		, cmsonlinetest.time, cmsonlinetest.calculater, cmsonlinetest.qus_pdf, cmsonlinetest.ans_pdf, cmsonlinetest.solution_pdf, cmsonlinetest.view_count FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest.id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		    $returnValue['name'] =  $row['name'];
		    $returnValue['id']  = $row['id'];
		    
		    $returnValue['exam_id'] = $row['exam_id'];
			$returnValue['subject_id'] = $row['subject_id'];
			$returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['formula_id'] = $row['formula_id'];
			$exam_time = $row['time']/60;
			$returnValue['time'] = $exam_time;
			$returnValue['calculater'] = $row['calculater'];
			$returnValue['qus_pdf'] = $row['qus_pdf'];
			$returnValue['ans_pdf'] = $row['ans_pdf'];
			$returnValue['total_question'] = "20";//just for calling web url
			$returnValue['solution_pdf'] = $row['solution_pdf'];
		
			$returnValue['view_count'] = $row['view_count'];
		
			//$returnValue['id'] = $iid = $row['id'];
			
		}
		return $returnValue;
	}
	
	mysqli_close($conn);
	
?>
