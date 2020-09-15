
<?php
error_reporting(0);
include('../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	 header("Access-Control-Allow-Origin: *");
  $cat_id = $_GET['exam_id'];
  $subject_id = $_GET['subject_id'];
  $type = $_GET['type'];
  
  if($subject_id > 0){$subject_ids = "AND subject_id = '$subject_id' GROUP BY `chapter_id`"; } else {$subject_ids = "GROUP BY `subject_id`"; }
  
  if($type=='videos'){
     // echo "SELECT * FROM `cmsvideolist_relations` WHERE `exam_id`='$cat_id' and `chapter_id` > '0'  $subject_ids";
	$result = mysqli_query($conn,"SELECT * FROM `cmsvideolist_relations` WHERE `exam_id`='$cat_id' and `chapter_id` > '0'  $subject_ids");
  }
  
   else if($type=='study-packages'){
     //  echo "SELECT * FROM `cmspricelist` WHERE `exam_id`='$cat_id' and and type='1'  `chapter_id` > '0'  $subject_ids";
	$result = mysqli_query($conn,"SELECT * FROM `cmspricelist` WHERE `exam_id`='$cat_id' and type='1' and `chapter_id` > '0'  $subject_ids");
  }
  
	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['chapter_id'];
	 $mainid = $row['videolist_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn,$mainid);
		$subTmp[] = $job;
	}
	
	$tmp = $subTmp;	

	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn,$mainid) {		
		$returnValue = array();
		
		
		$result = mysqli_query($conn,"SELECT * FROM cmschapters WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		  
    	;
    		$returnValue['chapter_name'] =$nam = $row['name'];
          	$string = str_replace(' ', '-', $nam);
         	$str = preg_replace('/[^A-Za-z0-9\. -]/', '', $nam);
// Replace sequences of spaces with hyphen
  $str = preg_replace('/  */', '-', $str);




			$returnValue['urlprefix_chapter'] = strtolower($str);
			$returnValue['chapter_id'] = $cid =  $row['id'];
				$returnValue['id'] = $mainid;
		//	$str = htmlentities($row['name'], ENT_QUOTES, "UTF-8");
		
    		$str=$row['name'];
    		if(strlen($str)>25){ $names= substr($str,0,25)."...";}
    		else { $names = $str; }
    		
    			$returnValue['chapter_name_short'] = $names;
    			
    	
  /*	$result = mysqli_query($conn,"SELECT * FROM `cmsvideolist_relations` WHERE `exam_id`='$cat_id' AND `subject_id`='$subject_id' AND `chapter_id`='$cid'");
		if($row = mysqli_fetch_array($result)) 
		{
		    
		}*/
 // echo "SELECT * FROM cmsvideolist_details WHERE videolist_id = '$mainid'";
  	$resultsc = mysqli_query($conn,"SELECT * FROM cmsvideolist_details WHERE videolist_id = '$mainid'");
			$coo = mysqli_num_rows($resultsc);
		$returnValue['video_count'] = $coo;
		
		
			
		
		}
		return $returnValue;
	}
	
?>

