
<?php
error_reporting(0);
include('../../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	$cat_id=$_GET['exam_id'];
	 $containtype=$_GET['type'];
	 header("Access-Control-Allow-Origin: *");
  if($containtype==videos){ $containtype='2';}
  
  
 $result = mysqli_query($conn, "SELECT * FROM `cmspricelist` WHERE `exam_id`='$cat_id' and type='1' and `subject_id` > '0' group by subject_id");

  
	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['subject_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
	
	$tmp = $subTmp;	

	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		
		$result = mysqli_query($conn,"SELECT * FROM cmssubjects WHERE id = '$mar_id' ");
		if($row = mysqli_fetch_array($result)) 
		{
		  
    		$returnValue['subject_id'] = $iddd = $row['id'];
			$returnValue['subject_name'] =$nam = $row['name'];
			
			$string = str_replace(' ', '-', $nam);
         	$str = preg_replace('/[^A-Za-z0-9\. -]/', '', $nam);
// Replace sequences of spaces with hyphen
  $str = preg_replace('/  */', '-', $str);
	$returnValue['urlprefix_subject'] = strtolower($str);
	
			$str = htmlentities($row['name'], ENT_QUOTES, "UTF-8");
    		
    		if(strlen($str)>25){ $names= substr($str,0,25)."...";}
    		else { $names = $str; }
    			$returnValue['subject_short_name'] = $names;
    	
    		
    			$cat_id=$_GET['exam_id'];
    			$resultsc = mysqli_query($conn,"SELECT * FROM cmspricelist WHERE subject_id = '$iddd' and exam_id='$cat_id'");
			$coo = mysqli_num_rows($resultsc);
		$returnValue['video_count'] = $coo;
		
		
    		
		
		}
		return $returnValue;
	}
	
?>

