
<?php
error_reporting(0);
include('../../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	 header("Access-Control-Allow-Origin: *");
  
	$result = mysqli_query($conn,"SELECT * from cmssolvedpapers where  is_deleted='1'  ORDER BY id DESC LIMIT 48");
  
	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
	
	$tmp = $subTmp;	

	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		
		$result = mysqli_query($conn,"SELECT * FROM cmssolvedpapers WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		  
    		$returnValue['category_id'] = $row['category_id'];
    		$str = htmlentities($row['name'], ENT_QUOTES, "UTF-8");
    		
    		if(strlen($str)>30){ $names= substr($str,0,30)."...";}
    		else { $names = $str; }
    		
    		
    		$returnValue['name'] = $names;
    		$returnValue['full_name'] = $str;
    		
			$returnValue['subject_id'] = $row['subject_id'];
			$returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['id'] = $row['id'];
		
		}
		return $returnValue;
	}
	
?>


