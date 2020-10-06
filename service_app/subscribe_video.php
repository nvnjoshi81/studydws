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
	$res_2 ="";
if($get_api){
     "SELECT * FROM cmsvideolist_relations where exam_id = '$category' $sub $chh";
     //SELECT cmsvideoslist.name, cmsvideoslist.display_image, cmsvideoslist.id, cmsvideolist_relations.id as v_relations_id, cmsvideolist_relations.exam_id, cmsvideolist_relations.subject_id, cmsvideolist_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsvideolist_relations JOIN categories ON cmsvideolist_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsvideolist_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsvideolist_relations.chapter_id=cmschapters.id JOIN cmsvideoslist ON cmsvideolist_relations.videolist_id=cmsvideoslist.id WHERE cmsvideolist_relations.exam_id = '$category' AND cmsvideolist_relations.subject_id = '$subject_id' AND cmsvideolist_relations.chapter_id = '$chapter_id' GROUP BY cmsvideolist_relations.videolist_id ORDER BY cmsvideoslist.id DESC
	$result = mysqli_query($conn,"SELECT cmsvideoslist.name, cmsvideoslist.display_image, cmsvideoslist.id, cmsvideolist_relations.id as v_relations_id, cmsvideolist_relations.exam_id, cmsvideolist_relations.subject_id, cmsvideolist_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsvideolist_relations JOIN categories ON cmsvideolist_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsvideolist_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsvideolist_relations.chapter_id=cmschapters.id JOIN cmsvideoslist ON cmsvideolist_relations.videolist_id=cmsvideoslist.id WHERE cmsvideolist_relations.exam_id = '$category' AND cmsvideolist_relations.subject_id = '$subject_id' AND cmsvideolist_relations.chapter_id = '$chapter_id' GROUP BY cmsvideolist_relations.videolist_id ORDER BY cmsvideoslist.id DESC");
	 $res_2 = mysqli_num_rows($result);
}
	if($res_2 > 0)
      {
	
        	while($row = mysqli_fetch_array($result))
            	{
            		  $mar_id = $row['id']; 
            		$job = array();
            		$job = getmarvelcategory($mar_id,$conn);
            		$subTmp[] = $job;
                }
    	}
	
	
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);
	
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
mysqli_close($conn);	
?>
