<?php
error_reporting(0);
	include('config.php');
	
    $user_id = $_POST['user_id'];
   // $video_id = $_GET['video_id'];

  	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";

	$result = mysqli_query($conn,"SELECT * FROM user_video_story where user_id = '$user_id' order by vi_id desc limit 1");

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['vi_id'];
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
		
		$result = mysqli_query($conn,"SELECT * FROM user_video_story where vi_id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
	
			$returnValue['user_id'] = $row['user_id'];
			$returnValue['video_id'] = $row['video_id'];
			$video = $row['video_id'];
			$returnValue['duration'] = $row['duration'];
			$returnValue['batch_date'] = $row['batch_date'];
		//	echo "SELECT * FROM cmsvideos where id = '$video'";
			$result1 = mysqli_query($conn,"SELECT * FROM cmsvideos where id = '$video'");
		if($rows = mysqli_fetch_array($result1)) 
		{
		$returnValue['title'] = preg_replace('/[^A-Za-z0-9]/', ' ', $rows['title']);
		$returnValue['video_file_name'] = $rows['video_file_name'];
		}
		if($rows['androidapp_link'] != "")
			{
			$returnValue['amazonaws_link'] = "https://studyadda.com/upload_files/".$rows['androidapp_link'];    
			}
			else
			{
			$amznlnk = $rows['amazonaws_link'];
			$amznlnk = str_replace("https://s3-us-west-2.amazonaws.com/","https://www.studyadda.com/upload_files/",$amznlnk);
			$amznlnk = str_replace("https://s3.amazonaws.com/","https://www.studyadda.com/upload_files/",$amznlnk);
			$amznlnk = str_replace("\r\n","",$amznlnk);
			$returnValue['amazonaws_link'] = $amznlnk;
			}
		}
		return $returnValue;
	}
	
?>
