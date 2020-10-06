<?php
error_reporting(0);
	include('config.php');
	
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
	if($subject_id){
	    $sub = "and subject_id = '$subject_id'";
	}
	else {
	  $sub = "";  
	}
	
		if($chapter_id > "0"){
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
    
    if($subject_id == "0" and $chapter_id == "0")
	{
	    $qry = "SELECT cmssolvedpapers.id FROM cmssolvedpapers_relations LEFT JOIN categories ON cmssolvedpapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssolvedpapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssolvedpapers_relations.chapter_id=cmschapters.id JOIN cmssolvedpapers ON cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id WHERE cmssolvedpapers_relations.exam_id = '$category' GROUP BY cmssolvedpapers_relations.solvedpapers_id ORDER BY cmssolvedpapers.years DESC";
	}
	else if($subject_id > "0" and $chapter_id == "0")
	{
	    $qry = "SELECT cmssolvedpapers.id FROM cmssolvedpapers_relations LEFT JOIN categories ON cmssolvedpapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssolvedpapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssolvedpapers_relations.chapter_id=cmschapters.id JOIN cmssolvedpapers ON cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id WHERE cmssolvedpapers_relations.exam_id = '$category' AND cmssolvedpapers_relations.subject_id = '$subject_id' GROUP BY cmssolvedpapers_relations.solvedpapers_id ORDER BY cmssolvedpapers.years DESC";
	}
	else if($subject_id > "0" and $chapter_id > "0")
	{          
	    $qry = "SELECT cmssolvedpapers.id FROM cmssolvedpapers_relations LEFT JOIN categories ON cmssolvedpapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssolvedpapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssolvedpapers_relations.chapter_id=cmschapters.id JOIN cmssolvedpapers ON cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id WHERE cmssolvedpapers_relations.exam_id = '$category' AND cmssolvedpapers_relations.subject_id = '$subject_id' AND cmssolvedpapers_relations.chapter_id = '$chapter_id' GROUP BY cmssolvedpapers_relations.solvedpapers_id ORDER BY cmssolvedpapers.years DESC";
	}
    $result = mysqli_query($conn,$qry);
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
		
		
		$result = mysqli_query($conn,"SELECT * FROM cmssolvedpapers where id = '$mar_id' and is_deleted = '1'");
		if($row = mysqli_fetch_array($result)) 
		{
$returnValue['name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);

	
			$returnValue['years'] = $row['years'];
		
			$returnValue['created_by'] = $row['created_by'];
			$returnValue['dt_created'] = $row['dt_created'];
			$returnValue['modified_by'] = $row['modified_by'];
			$returnValue['dt_modified'] = $row['dt_modified'];
			$returnValue['is_deleted'] = $row['is_deleted'];
			$returnValue['view_count'] = $row['view_count'];
		
			$returnValue['id'] = $row['id'];
		}
		return $returnValue;
	}
	mysqli_close($conn);
?>
