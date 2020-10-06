<?php
	include('config.php');
				$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
		$category_id = $_POST['category_id'];
	
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
	$category_id = $_POST['category_id'];
	$postStatusString = "publish";
	$res_2 = "";
if($get_api){
	$result = mysqli_query($conn,"SELECT * FROM cmschapter_details where class_id = '$category_id' GROUP BY subject_id ");
    $res_2 = mysqli_num_rows($result);
}
 //   echo "dx== ".$res_2; die();
	if($res_2 > 0)
        {
	
        	while($row = mysqli_fetch_array($result)) 
            {    
            		$mar_id = $row['subject_id'];
            		$self = "SELECT * FROM cmspackages_counter WHERE `exam_id` = '$category_id' AND subject_id = '$mar_id' AND total_package > '0'";
                    $oppf = mysqli_query($conn, $self);
                    $rww = mysqli_num_rows($oppf);
                    
                     if($rww > 0)
                        {
                    		$job = array();
                    		$job = getmarvelcategory($mar_id,$category_id,$conn);
                    		$subTmp[] = $job;
                         }
                 }
	    }

if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "No data found";}

	echo json_encode($tmp);
	//mysqli_close($conn);
	function getmarvelcategory($mar_id,$category_id,$conn) {		
		$returnValue = array();
		$result = mysqli_query($conn,"SELECT * FROM cmssubjects WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['subject_name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
			$returnValue['subject_id'] = $row['id'];
		$returnValue['order'] = $row['order'];
			$returnValue['description'] = $row['description'];
			$returnValue['keywords'] = $row['keywords'];
			$returnValue['tagline'] = $row['tagline'];
		}
        
		return $returnValue;
	}
    mysqli_close($conn);	
?>
