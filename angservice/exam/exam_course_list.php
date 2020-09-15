<?php 
	 include('../../service_app/config.php');
	  
	$tmp = array();
		$subTmp = array();
		$postStatusString = "publish";
		$cat_id = $_GET['id'];
header("Access-Control-Allow-Origin: *");
//echo	"SELECT * FROM `cmspackages_counter` WHERE `exam_id`='$cat_id' and total_package > '0'  and subject_id > '0'  GROUP BY subject_id ";

	$result = mysqli_query($conn,"SELECT * FROM `cmspackages_counter` WHERE `exam_id`='$cat_id' and total_package > '0'  and subject_id > '0'  GROUP BY subject_id ");		
		
		while($row = mysqli_fetch_array($result)) {
			  $mar_id = $row['id'];
			$job = array();
			$job = getcoursebycat($mar_id,$conn);
			$subTmp[] = $job;
		}
	
	
		$tmp = $subTmp;
	
		echo json_encode($tmp);
	//	mysqli_close();
		
		function getcoursebycat($mar_id,$conn) {		
			$returnValue = array();
		    // echo "SELECT * FROM cmspackages_counter WHERE subject_id = '$mar_id'";
			$result = mysqli_query($conn, "SELECT * FROM cmspackages_counter WHERE id = '$mar_id' and total_package > '0' " );
			while($rows = mysqli_fetch_array($result)) 
			{
		$returnValue['exam_id'] = $iid = $rows['exam_id'];
		$returnValue['exam_name'] = $rows['exam_name'];
		$returnValue['subject_id'] = $subid = $rows['subject_id'];
		$returnValue['subject_name'] = $rows['subject_name'];
		$returnValue['total_package'] = $rows['total_package'];
		$returnValue['total_question'] = $rows['total_question'];
		$returnValue['module_type'] = $rows['module_type'];
		$returnValue['level'] = $rows['level'];
        $returnValue['main_id'] =  $rows['id'];
        
     
     //  echo "SELECT * FROM cmspackages_counter WHERE exam_id = '$iid'";
        
        
			$result = mysqli_query($conn,"SELECT * FROM `cmspackages_counter` WHERE `exam_id`='$iid'  and subject_id = '$subid' and total_package > '0'");
        	while($row = mysqli_fetch_array($result)) 
        	{
        	    $chapid = $row['id'];
        		$chap = getchapbysub($chapid,$conn,$mar_id);
        		$subchap[] = $chap;
        		$returnValue['packagesr'] = $subchap;
        	}
			}
	        	return $returnValue;
		}
		
		function getchapbysub($chapid,$conn,$mar_id) {
		    
		    
		$returnValue = array();
//echo "SELECT * FROM cmspricelist where id = '$chapid' ";
		$results = mysqli_query($conn, "SELECT * FROM cmspackages_counter where id = '$chapid'  ");
		while($rows = mysqli_fetch_array($results)) 
		{
            $returnValue['exam_id'] =  $rows['exam_id'];
		$returnValue['exam_name'] = $rows['exam_name'];
		$returnValue['subject_id'] =  $rows['subject_id'];
		$returnValue['subject_name'] = $rows['subject_name'];
		$returnValue['total_package'] = $rows['total_package'];
		$returnValue['total_question'] = $rows['total_question'];
		$returnValue['module_type'] = $rows['module_type'];
		$returnValue['level'] = $rows['level'];
        $returnValue['main_id'] =  $rows['id'];
          
}
		
	
		return $returnValue;	
		
		}
		
  
  ?>
 
