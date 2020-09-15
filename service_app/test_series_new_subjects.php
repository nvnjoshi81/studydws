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
	$result = mysqli_query($conn,"SELECT DISTINCT cmssubjects.name as subject, cmssubjects.id FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest_relations.exam_id = '$category_id' AND cmsonlinetest.created_from_id = '$created_from_id' ORDER BY cmsonlinetest.olcategory_id DESC");
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
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		//echo "SELECT DISTINCT cmssubjects.name as subject, cmssubjects.id FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest_relations.exam_id = '$category_id' AND cmsonlinetest.created_from_id = '$created_from_id' AND cmssubjects.id = '$mar_id'";
		$result = mysqli_query($conn,"SELECT DISTINCT cmssubjects.name as subject, cmssubjects.id FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmssubjects.id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		    $returnValue['subject'] =  $row['subject'];
		    $returnValue['subject_id']  = $row['id'];
			
		}
		return $returnValue;
	}
	
?>
