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

    if($get_api)
    {
    
    if($subject_id == "0" and $chapter_id == "0")
	{
	    $qry = "SELECT cmsncertsolutions.name, cmsncertsolutions.id, cmsncertsolutions_relations.exam_id, cmsncertsolutions_relations.subject_id,
	            cmsncertsolutions_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM 
	            cmsncertsolutions_relations LEFT JOIN categories ON cmsncertsolutions_relations.exam_id=categories.id LEFT JOIN cmssubjects ON 
	            cmsncertsolutions_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsncertsolutions_relations.chapter_id=cmschapters.id JOIN 
	            cmsncertsolutions ON cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id WHERE cmsncertsolutions_relations.exam_id = '$category' 
	                ORDER BY cmsncertsolutions.id DESC";
	}
	else if($subject_id > "0" and $chapter_id == "0")
	{
	   $qry = "SELECT cmsncertsolutions.name, cmsncertsolutions.id,cmsncertsolutions_relations.exam_id, cmsncertsolutions_relations.subject_id, cmsncertsolutions_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsncertsolutions_relations LEFT JOIN categories ON cmsncertsolutions_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsncertsolutions_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsncertsolutions_relations.chapter_id=cmschapters.id JOIN cmsncertsolutions ON cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id WHERE cmsncertsolutions_relations.exam_id = '$category' AND cmsncertsolutions_relations.subject_id = '$subject_id' ORDER BY cmsncertsolutions.id DESC";
	}
	else if($subject_id > "0" and $chapter_id > "0")
	{
	    $qry = "SELECT cmsncertsolutions.name, cmsncertsolutions.id, cmsncertsolutions_relations.exam_id, cmsncertsolutions_relations.subject_id, cmsncertsolutions_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsncertsolutions_relations LEFT JOIN categories ON cmsncertsolutions_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsncertsolutions_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsncertsolutions_relations.chapter_id=cmschapters.id JOIN cmsncertsolutions ON cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id WHERE cmsncertsolutions_relations.exam_id = '$category' AND cmsncertsolutions_relations.subject_id = '$subject_id' AND cmsncertsolutions_relations.chapter_id = '$chapter_id' ORDER BY cmsncertsolutions.id DESC";
	}
	$result = mysqli_query($conn,$qry);
    
        
    }

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		
		$job = getmarvelcategory($mar_id,$conn);
		if(count($job) > 0)
		{
		$subTmp[] = $job;
		}
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);

	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
	    	$q = "SELECT * FROM cmsncertsolutions where id = '$mar_id' and is_deleted = '1'";
		
		$result = mysqli_query($conn,$q);
		if($row = mysqli_fetch_array($result)) 
		{
                $returnValue['name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);

	
			$returnValue['legacy_id'] = $row['legacy_id'];
		
			$returnValue['created_by'] = $row['created_by'];
			$returnValue['dt_created'] = $row['dt_created'];
			$returnValue['modified_by'] = $row['modified_by'];
			$returnValue['dt_modified'] = $row['dt_modified'];
			$returnValue['is_deleted'] = $row['is_deleted'];
			$returnValue['view_count'] = $row['view_count'];
		
			$returnValue['id'] = $row['id'];
		        if(chack_id($row['id'] ,$conn) == '0')
		        {
		            $returnValue = array();
		        }
		}
		return $returnValue;
	}
	
	function chack_id($id,$conn) {		
		$returnValue = array();
		
	    	$q = "SELECT * FROM cmsncertsolutions_details  where ncertsolutions_id = '$id' and question_id != '0'";
	
		$result = mysqli_query($conn,$q);
           
        return  $rowcount=mysqli_num_rows($result);
	 
	}
?>
