<?php


error_reporting(0);
	include('config.php');
	
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
		$chapter_id = $_POST['chapter_id'];
	
		$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	
	
			if($subject_id){
	    $sub = "and subject_id = '$subject_id'";
	}
	else {
	  $sub = "";  
	}
	
		if($chapter_id){
	    $chh = "and chapter_id = '$chaptert_id'";
	}
	else {
	  $chh = "";  
	}
	
	
	
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
    


	$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest_relations where exam_id = '$category' $sub $chh");
}

	while($row = mysqli_fetch_array($result)) {
	    $mar_id = $row['onlinetest_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn,$i,$category);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn,$i,$category) {		
		$returnValue = array();
		


	


		$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest where id = '$mar_id' and is_deleted = '1'");
		if($row = mysqli_fetch_array($result)) 
		{
		    
		 
	
		    
		    
		    
$returnValue['name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
$returnValue['instructions'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['instructions']);
	
			$returnValue['formula_id'] = $row['formula_id'];
			
			$returnValue['time'] = $row['time'];
			$returnValue['calculater'] = $row['calculater'];
			$returnValue['type'] = $row['type'];
			$returnValue['qus_pdf'] = $row['qus_pdf'];
			$returnValue['ans_pdf'] = $row['ans_pdf'];
			//	$returnValue['formula_id'] = $row['formula_id'];
			$returnValue['solution_pdf'] = $row['solution_pdf'];
			$returnValue['created_from'] = $row['created_from'];
			$returnValue['created_from_id'] = $row['created_from_id'];
			$returnValue['created_by'] = $row['created_by'];
			$returnValue['dt_created'] = $row['dt_created'];
			$returnValue['is_deleted'] = $row['is_deleted'];
			$returnValue['view_count'] = $row['view_count'];
			$returnValue['id'] = $row['id'];
			
		$test =	"http://dev.hybridinfotech.com/assets/frontend/product_images/testseries_blank.png";
			$returnValue['image'] = $test;
			
			
$result = mysqli_query($conn,"SELECT * FROM categories where id = '$category'");
		if($rowp = mysqli_fetch_array($result)) 
		{
		    	$returnValue['class'] = $rowp['name'];
		}
			
		
		
    
		}
		return $returnValue;
	}
	
?>
