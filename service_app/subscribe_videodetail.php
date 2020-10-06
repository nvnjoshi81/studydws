<?php
	include('config.php');
	
			$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
		$id = $_POST['id'];


	$device_id = $_POST['device_id'];
	

	
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
    //echo "SELECT * FROM cmsvideolist_details join cmsvideos on cmsvideolist_details.videolist_id = cmsvideos.id where cmsvideolist_details.videolist_id = '$id'";
    //SELECT `V`.`id`, `title`, `V`.`video_source`, `V`.`video_url_code`, `V`.`video_file_name`, `V`.`video_image`, `V`.`short_video`, `V`.`is_featured`, `V`.`description`, `V`.`video_by`, `V`.`status`, `V`.`views`, `V`.`is_free`, `V`.`video_duration`, `V`.`custom_video_duration`, `V`.`amazonaws_link`, `V`.`amazon_cloudfront_domain`, `d`.`videolist_id`, `d`.`video_id` FROM `cmsvideos` `V` JOIN `cmsvideolist_details` `d` ON `d`.`video_id`=`V`.`id` WHERE `d`.`videolist_id` = '$id' ORDER BY `V`.`id` DESC

     $q = 	"SELECT V.id, title, V.video_source, V.video_url_code, V.video_file_name, V.video_image, V.short_video, V.is_featured, V.description, V.video_by, V.status, V.views, V.is_free, V.video_duration, V.custom_video_duration, V.amazonaws_link, V.amazon_cloudfront_domain, d.videolist_id, d.video_id FROM cmsvideos V JOIN cmsvideolist_details d ON d.video_id=V.id WHERE d.videolist_id = '$id' ORDER BY CAST(V.title AS UNSIGNED) ASC, V.title ASC";
    
        $result = mysqli_query($conn,$q);

}
	
	while($row = mysqli_fetch_array($result)) {
		  $mar_id = $row['video_id']; 
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);





	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM cmsvideos where id = '$mar_id' ORDER BY id ASC");
		if($row = mysqli_fetch_array($result)) 
		{
		    
		
			$returnValue['name'] = $row['title'];
			$returnValue['video_source'] = $row['video_source'];
			if($row['video_source'] == "youtube")
			{
			    $returnValue['display_image'] = "https://img.youtube.com/vi/".$row['video_url_code']."/0.jpg";
			}
			else
			{
			    $returnValue['display_image'] = "https://www.studyadda.com/assets/videoimages/thumbs/250_250_".$row['video_image'];
			}
			$returnValue['video_url_code'] = $row['video_url_code'];
			$returnValue['video_file_name'] = $row['video_file_name'];
			$returnValue['short_video'] = $row['short_video'];
			$returnValue['video_tag'] = $row['video_tag'];
			$returnValue['view_count'] = $row['view_count'];
			$returnValue['video_size'] = $row['video_size'];
			$returnValue['video_duration'] = $row['video_duration'];
			$returnValue['custom_video_duration'] = $row['custom_video_duration'];
			$returnValue['amazonaws_link'] = $row['amazonaws_link'];
			$returnValue['amazon_cloudfront_domain'] = $row['amazon_cloudfront_domain'];
								

			$returnValue['id'] = $iid = $row['id'];
			
			 $num = $row['id'];
			
			 $las = $num%10;
			 $imm = "http://dev.hybridinfotech.com/assets/frontend/images/0";
	         //$returnValue['display_image'] = $imm.$las.".jpg";
	
		$results = mysqli_query($conn,"SELECT * FROM cmsvideolist_details where videolist_id = '$mar_id'");
		$returnValue['video_count'] = 	$coo = mysqli_num_rows($results);
	
		
			
		}
		return $returnValue;
	}
	
		mysqli_close($conn);




?>
