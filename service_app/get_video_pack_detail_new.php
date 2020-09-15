<?php
error_reporting(0);
	include('config.php');
	
	$id = $_REQUEST['id'];
    $device_id = $_REQUEST['device_id'];
	$user_key = $_REQUEST['user_key'];
	$user_id = $_REQUEST['user_id'];
	$exam_id = $_REQUEST['exam_id'];
	
      $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'";
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
    //echo "SELECT * FROM cmspricelist where id = '$id'";
	//$result = mysqli_query($conn,"SELECT * FROM cmspricelist where id = '$id'");
	$result = mysqli_query($conn,"SELECT C.id, C.exam_id, C.subject_id, C.chapter_id, C.item_id, C.type, C.price, C.discounted_price, C.description, C.offline_status, C.image, C.app_image, C.modules_item_id, C.modules_item_name, C.no_of_dvds, C.subscription_expiry, C.no_of_lectures, C.lecture_duration, C.no_of_subscribers, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmspricelist C LEFT JOIN categories ON C.exam_id=categories.id LEFT JOIN cmssubjects ON C.subject_id=cmssubjects.id LEFT JOIN cmschapters ON C.chapter_id=cmschapters.id WHERE type = '1' AND exam_id = '".$exam_id."' AND chapter_id = '0' AND subject_id = '0' AND item_id =0 GROUP BY C.id");
    
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
		
		$result = mysqli_query($conn,"SELECT * FROM cmspricelist where id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['title'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['modules_item_name']);
			$returnValue['exam_id'] = $row['exam_id'];
		$returnValue['subject_id'] = $row['subject_id'];
			$returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['app_image'] = "https://studyadda.com/assets/images/appimage/".$row['app_image'];
			$returnValue['item_id'] = $row['item_id'];
			$returnValue['type'] = $row['type'];
			$returnValue['price'] = $row['price'];
		    $returnValue['discounted_price'] = $row['discounted_price'];
			$returnValue['no_of_dvds'] = $row['no_of_dvds'];
			$returnValue['subscription_expiry'] = $row['subscription_expiry'];
			$returnValue['no_of_lectures'] = $row['no_of_lectures'];
			$returnValue['no_of_subscribers'] = $row['no_of_subscribers'];
			$returnValue['id'] = $row['id'];
			$notes = "The number of DVD's and Lectures in the package may differ from the numbers shown. To all the subscribers of video courses of Lalit sardana Sir & Shweta Sardana Madam study packages, Sample Papers, Solved Papers of relevant target exam will be provided by studyadda as a complementary.";
			$notes = preg_replace("\n!", "", $notes);
			$returnValue['notes'] = "The number of DVD's and Lectures in the package may differ from the numbers shown. To all the subscribers of video courses of Lalit sardana Sir & Shweta Sardana Madam study packages, Sample Papers, Solved Papers of relevant target exam will be provided by studyadda as a complementary.";
			$returnValue['notes_html'] = "The number of DVD's and Lectures in the package may differ from the numbers shown. To all the subscribers of video courses of Lalit sardana Sir & Shweta Sardana Madam study packages, Sample Papers, Solved Papers of relevant target exam will be provided by studyadda as a complementary.";	
			 $num = $row['id'];
			
			 $las = $num%10;
			 $zer = "1";
			 $imm = "http://dev.hybridinfotech.com/assets/frontend/images/";
	$returnValue['video_image'] = $imm.$las.".png";
			
		
		}
		return $returnValue;
	}
	
?>
