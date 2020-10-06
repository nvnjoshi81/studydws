<?php
error_reporting(0);
	include('config.php');
	
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
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
    if($subject_id == "0" and $chapter_id == "0")
	{
	    $qry = "SELECT cmsquestionbank.id as questionbank_id, cmsquestionbank.name, cmsquestionbank_relations.exam_id, cmsquestionbank_relations.subject_id, cmsquestionbank_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsquestionbank_relations LEFT JOIN categories ON cmsquestionbank_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsquestionbank_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsquestionbank_relations.chapter_id=cmschapters.id JOIN cmsquestionbank ON cmsquestionbank.id=cmsquestionbank_relations.questionbank_id WHERE cmsquestionbank_relations.exam_id = '$category' ORDER BY `cmsquestionbank`.`id` DESC LIMIT 20";
	}
	else if($subject_id > "0" and $chapter_id == "0")
	{
	    $qry = "SELECT * FROM cmsquestionbank_relations where exam_id = '$category' and subject_id='$subject_id' limit 20";
	}
	else if($subject_id > "0" and $chapter_id > "0")
	{
	     $qry = "SELECT * FROM cmsquestionbank_relations where exam_id = '$category' and subject_id='$subject_id' and chapter_id = '$chapter_id' limit 20";
	}
	$result = mysqli_query($conn,$qry);
}

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['questionbank_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);

	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT cmsquestionbank.id, cmsquestionbank.created_by, cmsquestionbank.dt_created, cmsquestionbank.modified_by, cmsquestionbank.view_count, cmsquestionbank.name, cmsquestionbank_relations.exam_id, cmsquestionbank_relations.subject_id, cmsquestionbank_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsquestionbank_relations LEFT JOIN categories ON cmsquestionbank_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsquestionbank_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsquestionbank_relations.chapter_id=cmschapters.id JOIN cmsquestionbank ON cmsquestionbank.id=cmsquestionbank_relations.questionbank_id WHERE cmsquestionbank.id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
	
			$returnValue['created_by'] = $row['created_by'];
			$returnValue['dt_created'] = $row['dt_created'];
			$returnValue['modified_by'] = $row['modified_by'];
			$returnValue['view_count'] = $row['view_count'];
			
			$returnValue['id'] = $num =$row['id'];
			
			 $las = $num%10;
			 $imm = "http://dev.hybridinfotech.com/assets/frontend/images/0";
	$returnValue['image'] = $imm.$las.".jpg";
	
	
	
		}
		return $returnValue;
	}
		mysqli_close($conn);
?>
