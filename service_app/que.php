<?php 
	include ('config.php');
	 	 $id = $_POST['id'];
	
	$tmp = array();
		$subTmp = array();
		$postStatusString = "publish";

	$result = mysqli_query($conn,"SELECT * FROM cmsonlinetest_details where onlinetest_id = '$id'");
		
		
		while($row = mysqli_fetch_array($result)) {
			 $mar_id = $row['question_id'];
			$job = array();
			$job = getcoursebycat($mar_id,$conn);
			$subTmp[] = $job;
		}
		$tmp['status'] = "success";
		if($subTmp){
		//$tmp['data2'] = "Invalid key";
		
			$tmp['data'] = $subTmp;
		}
		else {
			$tmp['data'] = "Invalid key";
		
			}
		echo json_encode($tmp);
	//	mysqli_close();
		
		function getcoursebycat($mar_id,$conn) {		
			$returnValue = array();
		//	echo "SELECT * FROM cmsonlinetest_details WHERE onlinetest_id = '$mar_id'";
			$result = mysqli_query($conn, "SELECT * FROM cmsquestions WHERE id = '$mar_id'");
			while($row = mysqli_fetch_array($result)) 
			{
			$returnValue['question'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['question']);

			$returnValue['id'] = $iid = $row['id'];;
				
		
				
			//	echo "SELECT * FROM cmsonlinetest_details WHERE cmsquestions = '$iid'" ;
				$result = mysqli_query($conn,"SELECT * FROM cmsanswers WHERE question_id = '$iid'");
	        	while($row = mysqli_fetch_array($result)) 
	        	{
	        	    $chapid = $row['id'];
	        		$chap = getchapbysub($chapid,$conn);
	        		$subchap[] = $chap;
	        		$returnValue['answer'] = $subchap;
	        	}
				
				
				
					
	        	}
	        	return $returnValue;
		}
		
		function getchapbysub($chapid,$conn) {
		    
		    
		$returnValue = array();
//	echo "SELECT * FROM cmsanswers where id = '$chapid' " ;
		$result = mysqli_query($conn, "SELECT * FROM cmsanswers where id = '$chapid' ");
		while($row = mysqli_fetch_array($result)) 
		{

	//	$returnValue['answer_id'] = $row['id'];
		 $returnValue['answer'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['answer']);
	//	 $returnValue['correct_answer'] =  $row['is_correct'];
			
		
		}
		return $returnValue;	
		
		}
		
  
  ?>
 
