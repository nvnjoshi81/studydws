<?php 
	include ('config.php');
	
	 include('../service_app/config.php');
	  header("Access-Control-Allow-Origin: *");
	$tmp = array();
		$subTmp = array();
		$postStatusString = "publish";

//	$result = mysqli_query($conn,"SELECT * FROM categories where parent_id='21' LIMIT 2");


	$result = mysqli_query($conn,"SELECT * FROM `cmspricelist` WHERE `exam_id` > '0' and type='1' and subject_id > '0' GROUP BY exam_id ORDER BY price DESC");		
		
		while($row = mysqli_fetch_array($result)) {
			  $mar_id = $row['exam_id'];
			$job = array();
			$job = getcoursebycat($mar_id,$conn);
			$subTmp[] = $job;
		}
	
	
		$tmp = $subTmp;
	
		echo json_encode($tmp);
	//	mysqli_close();
		
		function getcoursebycat($mar_id,$conn) {		
			$returnValue = array();
		//     echo "SELECT * FROM categories WHERE id = '$mar_id'";
			$result = mysqli_query($conn, "SELECT * FROM categories WHERE id = '$mar_id'");
			while($rows = mysqli_fetch_array($result)) 
			{
		$returnValue['course_name'] = $rows['name'];
            $returnValue['course_id'] = $iid = $rows['id'];
        
     
       // "SELECT * FROM `cmspricelist` WHERE `exam_id` = '28' and type='1' and subject_id > '0' GROUP BY subject_id";
        
        
			$result = mysqli_query($conn,"SELECT * FROM cmspricelist WHERE exam_id = '$iid' and subject_id > '0' and type='1' GROUP BY subject_id ASC");
        	while($row = mysqli_fetch_array($result)) 
        	{
        	    $chapid = $row['subject_id'];
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
		$results = mysqli_query($conn, "SELECT * FROM cmssubjects where id = '$chapid' ");
		while($row = mysqli_fetch_array($results)) 
		{
            $returnValue['subject_id']  = 	$row['id'];
            $returnValue['sub_name'] = $row['name'];
          
}
		
	
		return $returnValue;	
		
		}
		
  
  ?>
 
