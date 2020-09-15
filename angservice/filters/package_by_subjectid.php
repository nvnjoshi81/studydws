
<?php
error_reporting(0);
include('../../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	 header("Access-Control-Allow-Origin: *");
   $cat_id = $_GET['exam_id'];
  $subject_id = $_GET['subject_id'];
  $type = $_GET['type'];
  if($type==study-packages){$types='1';}
  
  if($subject_id > 0){$subject_ids = "AND subject_id = '$subject_id' GROUP BY `chapter_id`"; } else {$subject_ids = "GROUP BY `subject_id`"; }
  
 
   if($type==study-packages){
	$result = mysqli_query($conn,"SELECT * FROM `cmspricelist` WHERE `exam_id`='$cat_id' and type='$types' and `chapter_id` > '0'  $subject_ids");
  }
  
	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['chapter_id'];
	//	$mainid = $row['videolist_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
	
	$tmp = $subTmp;	

	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
	//	echo "SELECT * FROM cmschapters WHERE id = '$mar_id'";
		$result = mysqli_query($conn,"SELECT * FROM cmschapters WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{	$returnValue['chapter_name'] =$nam = $row['name'];
          	$string = str_replace(' ', '-', $nam);
         	$str = preg_replace('/[^A-Za-z0-9\. -]/', '', $nam);
// Replace sequences of spaces with hyphen
  $str = preg_replace('/  */', '-', $str);




			$returnValue['urlprefix_chapter'] = strtolower($str);
			$returnValue['chapter_id'] = $cid =  $row['id'];
			
			//$str = htmlentities($row['name'], ENT_QUOTES, "UTF-8");
    		
    		if(strlen($str)>35){ $names= substr($nam,0,35)."...";}
    		else { $names = $nam; }
    		
    			$returnValue['chapter_name_short'] = $names;
    			


$exid = $_GET['exam_id'];
$suid = $_GET['subject_id'];
$type = $_GET['type'];
   if($type==study-packages){$types='1';}
  
  	$resultsc = mysqli_query($conn,"SELECT * FROM `cmspricelist` WHERE `exam_id`='$exid' and type='$types' and `chapter_id` = '$cid' AND subject_id = '$suid'");
			$coo = mysqli_num_rows($resultsc);
		$returnValue['pack_count'] = $coo;
		
		
			
		
		}
		return $returnValue;
	}
	
?>

