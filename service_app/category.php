<?php
error_reporting(0);
	include('config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
 $package = $_POST['package']; 
  $ran_no = $_POST['ran_no'];


  if($first > $ran_no  AND $last > $ran_no)
  $pac = "com.studyadda";
  
     $self = "select * from diff where $ran_no BETWEEN first and last and pac = '$package'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	 $tes_id = "123456TE123StudyYadda";
	  
  }
  
  if(!empty($tes_id)){
     
	$result = mysqli_query($conn,"SELECT * FROM categories where parent_id = '21' and status = 'show' and name != 'Other Exam' order by `order` DESC");
  }
	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
	
	if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
		
		

	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		
		$result = mysqli_query($conn,"SELECT * FROM categories WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		   
		
		//$returnValue['category_name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
    		$str = htmlentities($row['name'], ENT_QUOTES, "UTF-8");
    		$returnValue['category_name'] = $str;
    		$returnValue['category_id'] = $row['id'];
    		$returnValue['order'] = $row['order'];
			$returnValue['parent_id'] = $row['parent_id'];
			$returnValue['description'] = $row['description'];
			$returnValue['keywords'] = $row['keywords'];
			$returnValue['tagline'] = $row['tagline'];
			$returnValue['link'] = $row['link'];
			$returnValue['created'] = $row['created'];
			$returnValue['legacy_id'] = $row['legacy_id'];
	//	$returnValue['category_name'] = $nn;
		}
		return $returnValue;
	}
	
?>
