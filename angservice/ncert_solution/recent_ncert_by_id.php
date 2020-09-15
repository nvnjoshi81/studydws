
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
  
  if($subject_id > 0){$subject_ids = "AND cmsncertsolutions_relations.subject_id = '$subject_id' "; } else {$subject_ids = ""; }
         
     /*    echo "SELECT * FROM cmsncertsolutions_relations join cmsncertsolutions on  cmsncertsolutions_relations.ncertsolutions_id = cmsncertsolutions.id 
	WHERE cmsncertsolutions_relations.exam_id='$cat_id' $subject_ids order by cmsncertsolutions_relations.id desc LIMIT 30";
	
	*/
	$result = mysqli_query($conn,"SELECT * FROM cmsncertsolutions_relations join cmsncertsolutions on  cmsncertsolutions_relations.ncertsolutions_id = cmsncertsolutions.id 
	WHERE cmsncertsolutions_relations.exam_id='$cat_id' $subject_ids order by cmsncertsolutions_relations.id desc LIMIT 30");
  	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['ncertsolutions_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
	
	$tmp = $subTmp;	

	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		
		$result = mysqli_query($conn,"SELECT * FROM cmsncertsolutions WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		  
    		$returnValue['id'] = $row['id'];
    		$returnValue['name'] =$nam = $row['name'];
    		
    			$str=$row['name'];
    		if(strlen($str)>30){ $names= substr($str,0,30)."...";}
    		else { $names = $str; }
    		
    			$returnValue['subject_name_short'] = $names;
    			
    	
    	
    	
          	$string = str_replace(' ', '-', $nam);
			$returnValue['urlprefix'] = strtolower($string);
	
		}
		return $returnValue;
	}
	
?>

