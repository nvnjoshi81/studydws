<?php
error_reporting(0);
	include('config.php');
	
   $id = $_POST['id'];
	$user_key = $_POST['user_key'];
			$device_id = $_POST['device_id'];
	$user_id = $_POST['user_id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key'  and device_id = '$device_id'";
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

//if($get_api){

//echo "SELECT * FROM cmsvideos where id = '$id'";
	$result = mysqli_query($conn,"SELECT * FROM cmsvideos where id = '$id'");
//}

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
			$str = $row['description'];
			$str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", " ", $str);
            $str = htmlspecialchars_decode($str);
			$returnValue['description'] = $str;
			$returnValue['video_duration'] = $row['video_duration'];
			$result1 = mysqli_query($conn,"SELECT * FROM user_video_story where video_id = '$mar_id'");
		    if($rows = mysqli_fetch_array($result1)) 
		    {
		    	$returnValue['video_stroy_duration'] = $rows['duration'];
		    }
			$returnValue['status'] = $row['status'];
			$returnValue['views'] = $row['views'];
			$returnValue['courtesy'] = $row['courtesy'];
			$returnValue['video_tag'] = $row['video_tag'];
			$returnValue['video_duration'] = $row['custom_video_duration'];
			$returnValue['custom_video_duration'] = $row['custom_video_duration'];
			if($row['androidapp_link'] != "")
			{
			$returnValue['amazonaws_link'] = "https://studyadda.com/upload_files/".$row['androidapp_link'];    
			}
			else
			{
			$amznlnk = $row['amazonaws_link'];
			$amznlnk = str_replace("https://s3-us-west-2.amazonaws.com/","https://www.studyadda.com/upload_files/",$amznlnk);
			$amznlnk = str_replace("https://s3.amazonaws.com/","https://www.studyadda.com/upload_files/",$amznlnk);
			$amznlnk = str_replace("\r\n","",$amznlnk);
			$returnValue['amazonaws_link'] = $amznlnk;
			}
			/*$amznlnk = $row['amazonaws_link'];
			$amznlnk = str_replace("https://s3-us-west-2.amazonaws.com/","https://www.studyadda.com/upload_files/",$amznlnk);
			$amznlnk = str_replace("https://s3.amazonaws.com/","https://www.studyadda.com/upload_files/",$amznlnk);
			//$amznlnk = str_replace("%2C",",",$amznlnk);
			//$amznlnk = str_replace("%26","&",$amznlnk);
			$amznlnk = str_replace("\r\n","",$amznlnk);
			$returnValue['amazonaws_link'] = $amznlnk;*/
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
