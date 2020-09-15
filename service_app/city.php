<?php
	include('config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	$result = mysqli_query($conn,"SELECT * FROM cmscity");
	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
	$tmp['status'] = "success";
	$tmp['data'] = $subTmp;
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		//echo "SELECT * FROM categories WHERE id = '$mar_id'";
		$result = mysqli_query($conn,"SELECT * FROM cmscity WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['city_name'] = $row['city_name'];
			$returnValue['state_id'] = $row['state_id'];
			$returnValue['city_id'] = $row['id'];

		}
		return $returnValue;
	}
	
?>
