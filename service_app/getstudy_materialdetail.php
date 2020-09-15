<?php
error_reporting(0);
	include('config.php');
	

	$device_id = $_POST['device_id'];
		$id = $_POST['id'];
	
		$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
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
    

   
	$result = mysqli_query($conn,"SELECT * FROM cmsstudymaterial_details where studymaterial_id = '$id' ");
	
	
}

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['file_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM cmsfiles where id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['displayname'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['displayname']);
		
			$returnValue['filename'] = $row['filename'];
			$returnValue['filepath'] = $row['filepath'];
			$returnValue['filename_one'] = $row['filename_one'];
			$returnValue['filepath_one'] = $row['filepath_one'];
			$returnValue['type'] = $row['type'];
			$returnValue['filetype'] = $row['filetype'];
			$returnValue['pagecount'] = $row['pagecount'];
			$returnValue['is_deleted'] = $row['is_deleted'];
				
	
			$returnValue['created_by'] = $row['created_by'];
			$returnValue['dt_created'] = $row['dt_created'];
			$returnValue['modified_by'] = $row['modified_by'];
			$returnValue['view_count'] = $row['view_count'];
			
			$cr = "http://dev.hybridinfotech.com/upload/pdfs/";
			
				$returnValue['view_file'] = $cr.$row['filename_one'];
			
			$returnValue['id'] = $row['id'];
		}
		return $returnValue;
	}
	
?>
