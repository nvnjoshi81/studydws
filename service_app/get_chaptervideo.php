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
    $qry = "SELECT * FROM cmsvideolist_relations where exam_id = '$category' and subject_id='$subject_id' and chapter_id = '$chapter_id'";
	$result = mysqli_query($conn,$qry);
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
		
		$result = mysqli_query($conn,"SELECT * FROM cmsvideos where id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['title'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['title']);
			//$returnValue['title'] = $row['title'];
		$returnValue['video_url_code'] = $row['video_url_code'];
			$returnValue['video_file_name'] = $row['video_file_name'];
		//	$returnValue['video_image'] = $row['video_image'];
			$returnValue['short_video'] = $row['short_video'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
		//	$returnValue['description'] = $row['description'];
			$returnValue['status'] = $row['status'];
			$returnValue['views'] = $row['views'];
			$returnValue['courtesy'] = $row['courtesy'];
			$returnValue['video_tag'] = $row['video_tag'];
			$returnValue['video_duration'] = $row['video_duration'];
			$returnValue['custom_video_duration'] = $row['custom_video_duration'];
			$returnValue['amazonaws_link'] = $row['amazonaws_link'];
			$returnValue['amazon_cloudfront_domain'] = $row['amazon_cloudfront_domain'];
			$returnValue['created_by'] = $row['created_by'];
			$returnValue['view_count'] = $row['view_count'];
				$returnValue['is_free'] = $row['is_free'];
			$returnValue['id'] = $row['id'];
			
				
			 $num = $row['id'];
			
			 $las = $num%10;
			 $imm = "http://dev.hybridinfotech.com/assets/frontend/images/";
	$returnValue['video_image'] = $imm.$las.".png";
			
		
		}
		return $returnValue;
	}
	
?>
