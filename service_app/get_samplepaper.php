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
	    $qry = "SELECT cmssamplepapers.id FROM cmssamplepapers_relations LEFT JOIN categories ON cmssamplepapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssamplepapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssamplepapers_relations.chapter_id=cmschapters.id JOIN cmssamplepapers ON cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id WHERE cmssamplepapers_relations.exam_id = '$category' ORDER BY cmssamplepapers.id DESC";
	}
	else if($subject_id > "0" and $chapter_id == "0")
	{
	    $qry = "SELECT cmssamplepapers.id FROM cmssamplepapers_relations LEFT JOIN categories ON cmssamplepapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssamplepapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssamplepapers_relations.chapter_id=cmschapters.id JOIN cmssamplepapers ON cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id WHERE cmssamplepapers_relations.exam_id = '$category' AND cmssamplepapers_relations.subject_id = '$subject_id' ORDER BY cmssamplepapers.id DESC";
	}
	else if($subject_id > "0" and $chapter_id > "0")
	{
	    $qry = "SELECT cmssamplepapers.id FROM cmssamplepapers_relations LEFT JOIN categories ON cmssamplepapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssamplepapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssamplepapers_relations.chapter_id=cmschapters.id JOIN cmssamplepapers ON cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id WHERE cmssamplepapers_relations.exam_id = '$category' AND cmssamplepapers_relations.subject_id = '$subject_id' AND cmssamplepapers_relations.chapter_id = '$chapter_id' ORDER BY cmssamplepapers.id DESC";
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
		
		$result = mysqli_query($conn,"SELECT * FROM cmssamplepapers where id = '$mar_id' and is_deleted = '1'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
	
			$returnValue['created_by'] = $row['created_by'];
			$returnValue['dt_created'] = $row['dt_created'];
			$returnValue['modified_by'] = $row['modified_by'];
			$returnValue['view_count'] = $row['view_count'];
			
			$returnValue['id'] = $num = $row['id'];
			 $las = $num%10;
			 $imm = "http://dev.hybridinfotech.com/assets/frontend/images/0";
	$returnValue['image'] = $imm.$las.".jpg";

		}
		return $returnValue;
	}
	
	mysqli_close($conn);
	
	
?>
