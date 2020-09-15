<?php
error_reporting(0);
	include('config.php');
	
	$id = $_POST['id'];
    $device_id = $_POST['device_id'];
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
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
		    $str = $row['modules_item_name'];
		    $str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
            $returnValue['title'] = $str;
			$returnValue['exam_id'] = $row['exam_id'];
			$returnValue['app_image'] = "https://studyadda.com/assets/images/appimage/".$row['app_image'];
		    $returnValue['subject_id'] = $row['subject_id'];
			$returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['item_id'] = $row['item_id'];
			$returnValue['type'] = $row['type'];
			$returnValue['price'] = $row['price'];
		    $returnValue['discounted_price'] = $row['discounted_price'];
			$returnValue['subscription_expiry'] = $row['subscription_expiry'];
			$returnValue['no_of_testpapers'] = $row['no_of_lectures'];
			$returnValue['id'] = $row['id'];
			$notes = "The number of package may vary time to time.Study packages are available in soft (PDF format) copy only. After buying you will be able to download them, and then read over any device (Mobile, tab, desktop, laptop etc.) having PDF functionality. Also you can take their print-outs.";
			$notes = preg_replace("\n!", "", $notes);
			$returnValue['notes'] = "The number of Test Papers may vary time to time.Test series is available in online format only. After buying you can attempt any test any number of times.After attending any test you will be able to download complete paper along with its answers key & solutions.A large number of analytical tools are also provided at the end of test.";
			$returnValue['notes_html'] = "<ul><li><b><i><span>The number of Test Papers may vary time to time.</span></i></b></li><li><b><i><span>Test series is available in online format only. After buying you can attempt any test any number of times.After attending any test you will be able to download complete paper along with its answers key &amp; solutions.A large number of analytical tools are also provided at the end of test.</span></i></b></li></ul>";	
			$num = $row['id'];
			$las = $num%10;
	        $imm = "http://dev.hybridinfotech.com/assets/frontend/images/0";
	        $returnValue['image'] = $imm.$las.".jpg";
		}
		return $returnValue;
	}
?>
