

<?php 

	 include('../../service_app/config.php');
	  header("Access-Control-Allow-Origin: *");
	$tmp = array();
		$subTmp = array();
		$postStatusString = "publish";

	//$result = mysqli_query($conn, "SELECT * FROM `cmssolvedpapers_relations` where  subject_id > '0' GROUP BY `exam_id` ORDER BY exam_id ASC");
	
//	echo "SELECT * FROM `cmssolvedpapers_relations` GROUP BY `exam_id` ASC";
		$result = mysqli_query($conn, "SELECT * FROM `cmssolvedpapers_relations` GROUP BY `exam_id` ASC");
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
			$sdd = mysqli_num_rows($result);
			 if($sdd > 0){
			     
			while($rows = mysqli_fetch_array($result)) 
			{
	
			$str = htmlentities($rows['name'], ENT_QUOTES, "UTF-8");
				$returnValue['course_name'] = $str;
        $returnValue['course_id'] = $iid = $rows['id'];
       
        
    //echo "SELECT * FROM cmssolvedpapers_relations WHERE exam_id = '$iid' and subject_id > '0'  GROUP BY subject_id ASC";
    
	$result = mysqli_query($conn,"SELECT * FROM cmssolvedpapers_relations WHERE exam_id = '$iid' and subject_id > '0'  GROUP BY subject_id ASC");
    while($row = mysqli_fetch_array($result)) 
        	{
        	    $chapid = $row['subject_id'];
        		$chap = getchapbysub($chapid,$conn,$mar_id);
        		$subchap[] = $chap;
        		$returnValue['packagesr'] = $subchap;
        	}
			} }
			else {	$returnValue['packagesr'] = "no data found"; }
	        	return $returnValue;
		}
		
		function getchapbysub($chapid,$conn,$mar_id) {
		    
		    
		$returnValue = array();
//echo "SELECT * FROM cmspricelist where id = '$chapid' ";
		$results = mysqli_query($conn, "SELECT * FROM cmssubjects where id = '$chapid' ");
		while($row = mysqli_fetch_array($results)) 
		{
            $returnValue['subject_id']  = 	$sid =$row['id'];
            
            if($sid > 0){
                $returnValue['sub_name'] = $row['name'];
            }else {
                $returnValue['sub_name'] = "No data here.";
            }
          
}
		
	
		return $returnValue;	
		
		}
		
  
  ?>
 
