<?php 
	include ('config.php');
	 	 $id = $_POST['test_id'];
	
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
		    $result = mysqli_query($conn, "SELECT * FROM cmsquestions WHERE id = '$mar_id'");
			while($row = mysqli_fetch_array($result)) 
			{
			$str= $row['question'];
			
				 $str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
            $returnValue['question'] = $str;
            
            

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

		$ansp = $row['answer'];
		$ansp = utf8_encode($ansp);
        $ansp = strip_tags($ansp, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $ansp = htmlentities($ansp, ENT_QUOTES, "UTF-8");
        $ansp = preg_replace("!\r?\n!", "", $ansp);
        $ansp = str_replace("&nbsp;", "", $ansp);
        $ansp = str_replace("nbsp;", "", $ansp);
        $ansp = str_replace("&amp;", "", $ansp);
        $returnValue['your_answer'] = $ansp;
        $returnValue['answer_id']  = 	$row['id'];
        $returnValue['answer_correct']  = 	$row['is_correct'];
	
		}
		
	
		return $returnValue;	
		
		}
		
  
  ?>
 
