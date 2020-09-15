
<?php
error_reporting(0);
include('../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	 header("Access-Control-Allow-Origin: *");
  
	$result = mysqli_query($conn,"SELECT * from categories  where parent_id='21'");
  
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
		
		
		$result = mysqli_query($conn,"SELECT * FROM categories WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		  
    		$returnValue['id'] = $row['id'];
    		$returnValue['name'] =$nam = $row['name'];
          	$string = str_replace(' ', '-', $nam);
			$returnValue['urlprefix'] = strtolower($string);
		}
		return $returnValue;
	}
	
?>

