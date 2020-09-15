<?php
error_reporting(0);
	include('config.php');
	
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
	
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
	$result = mysqli_query($conn,"SELECT cmschapters.id as chapter_id, cmschapters.name as cname, cmssubjects.id as sid, cmssubjects.name as sname FROM cmschapter_details cd JOIN cmschapters ON cd.chapter_id = cmschapters.id JOIN cmssubjects ON cd.subject_id = cmssubjects.id WHERE cd.class_id = '$category' AND cd.subject_id='$subject_id' ORDER BY cd.sortorder ASC, cd.id ASC");
}

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['chapter_id'];
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
		
		$result = mysqli_query($conn,"SELECT * FROM cmschapters where id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		    //$returnValue['name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
		    $str = $row['name'];
		    $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['name'] = $str;
			$returnValue['slug'] = $row['slug'];
			$returnValue['order'] = $row['order'];
			$returnValue['created'] = $row['created'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
		    $returnValue['keywords'] = $row['keywords'];
		    $returnValue['tagline'] = $row['tagline'];
			$returnValue['id'] = $row['id'];
		}
		return $returnValue;
	}
	
?>
