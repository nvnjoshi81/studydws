<?php
error_reporting(0);
	include('config.php');
	
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
		$chapter_id = $_POST['chapter_id'];
	
		$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
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
    

    "SELECT * FROM cmsstudymaterial_relations where exam_id = '$category' and subject_id='$subject_id' and chapter_id = '$chapter_id' ";
	$result = mysqli_query($conn,"SELECT * FROM cmsstudymaterial_relations where exam_id = '$category' and subject_id='$subject_id' and chapter_id = '$chapter_id' ");
	
		$result = mysqli_query($conn,"SELECT * FROM cmsstudymaterial_relations where exam_id = '$category' and subject_id='$subject_id'");
}

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['studymaterial_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn,$user_id);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn,$user_id) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM cmsstudymaterial where id = '$mar_id' and is_deleted = '1'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
	
			$returnValue['created_by'] = $row['created_by'];
			$returnValue['dt_created'] = $row['dt_created'];
			$returnValue['modified_by'] = $row['modified_by'];
			$returnValue['view_count'] = $row['view_count'];
			$returnValue['id'] = $pid = $row['id'];
			

		    	
			 $num = $row['id'];
			
			 $las = $num%10;
	
			 $imm = "http://dev.hybridinfotech.com/assets/frontend/images/0";
	$returnValue['image'] = $imm.$las.".jpg";
		    
		}
		return $returnValue;
	}
	
?>
