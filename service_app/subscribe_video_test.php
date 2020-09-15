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
     echo "SELECT * FROM cmsvideolist_relations where exam_id = '$category' $sub $chh";
	$result = mysqli_query($conn,"SELECT * FROM cmsvideolist_relations where exam_id = '$category' $sub $chh");
}
	
	while($row = mysqli_fetch_array($result)) {
		  $mar_id = $row['videolist_id']; 
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
		
		$result = mysqli_query($conn,"SELECT * FROM cmsvideoslist where id = '$mar_id' ORDER BY id ASC");
		if($row = mysqli_fetch_array($result)) 
		{
		    
		
			$returnValue['name'] = $row['name'];
	
		//	$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
			$returnValue['exam_id'] = $row['exam_id'];
			$returnValue['subject_id'] = $row['subject_id'];
			$returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['video_by'] = $row['video_by'];
			$returnValue['video_tag'] = $row['video_tag'];
			$returnValue['view_count'] = $row['view_count'];
		
			$returnValue['id'] = $iid = $row['id'];
			
			 $num = $row['id'];
			
			 $las = $num%10;
			 $imm = "http://dev.hybridinfotech.com/assets/frontend/images/0";
	$returnValue['display_image'] = $imm.$las.".jpg";
	
		$results = mysqli_query($conn,"SELECT * FROM cmsvideolist_details where videolist_id = '$mar_id'");
		$returnValue['video_count'] = 	$coo = mysqli_num_rows($results);
	
		
			
		}
		return $returnValue;
	}
	
?>
