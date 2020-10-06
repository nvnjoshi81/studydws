<?php 
	include ('config.php');
	 	 $id = $_POST['id'];
	
	$tmp = array();
		$subTmp = array();
		$postStatusString = "publish";

	 $result = mysqli_query($conn,"SELECT * FROM cmssolvedpapers_details where solvedpapers_id = '$id'");	
		
		
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
		
		
		
		
		
		function getcoursebycat($mar_id,$conn) {		
			$returnValue = array();
		//	echo "SELECT * FROM cmsonlinetest_details WHERE onlinetest_id = '$mar_id'";
			$result = mysqli_query($conn, "SELECT * FROM cmsquestions WHERE id = '$mar_id'");
			while($row = mysqli_fetch_array($result)) 
			{
			//$returnValue['question'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['question']);

			$returnValue['id'] = $iid = $row['id'];
			
			$str = $row['question'];
		    $str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
            $returnValue['question'] = $str;
				
		
				
				 "SELECT * FROM cmsanswers WHERE question_id = '1'" ;
			//	$result = mysqli_query($conn,"SELECT * FROM cmsanswers WHERE question_id = '1'");
					$result = mysqli_query($conn,"SELECT * FROM cmsanswers WHERE question_id = '$iid'");
				 $coouds = mysqli_num_rows($result);
	        	while($row = mysqli_fetch_array($result)) 
	        	{
	        	    $chapid = $row['id'];
	        		$chap = getchapbysub($chapid,$conn,$coouds);
	        		$subchap[] = $chap;
	        		$returnValue['answer'] = $subchap;
	        	}
				
				
				
					
	        	}
	        	return $returnValue;
		}
		
		function getchapbysub($chapid,$conn,$coouds) {
		    
		    
		$returnValue = array();

	if($coouds > 2){
		$result = mysqli_query($conn, "SELECT * FROM cmsanswers where id = '$chapid' ");
		while($row = mysqli_fetch_array($result)) 
		{

		 //$returnValue['answer'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['answer']);
		 
           $returnValue['answer_id']  = 	$row['id'];
           $returnValue['answer_correct']  = 	$row['is_correct'];
           
            $ansp = $row['answer'];
        $ansp = utf8_encode($ansp);
        $ansp = strip_tags($ansp, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $ansp = htmlentities($ansp, ENT_QUOTES, "UTF-8");
        $ansp = preg_replace("!\r?\n!", "", $ansp);
        $ansp = str_replace("&nbsp;", "", $ansp);
        $ansp = str_replace("nbsp;", "", $ansp);
        $ansp = str_replace("&amp;", "", $ansp);
        $returnValue['answer'] = $ansp;
        $ansext = $row['description'];
        $ansext = utf8_encode($ansext);
        $ansext = strip_tags($ansext, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $ansext = htmlentities($ansext, ENT_QUOTES, "UTF-8");
        $ansext = preg_replace("!\r?\n!", "", $ansext);
        $ansext = str_replace("&nbsp;", "", $ansext);
        $ansext = str_replace("nbsp;", "", $ansext);
        $ansext = str_replace("&amp;", "", $ansext);
        $returnValue['solution'] = $ansext;
	
		} }
		else {
		    
		    	$result = mysqli_query($conn, "SELECT * FROM cmsanswers where id = '$chapid' ");
		while($row = mysqli_fetch_array($result)) 
		{

		 //$returnValue['answer'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['answer']);
		 
           $returnValue['answer_id']  = 	$row['id'];
           $returnValue['answer_correct']  = 	"1";
           
            $ansp = $row['answer'];
        $ansp = utf8_encode($ansp);
        $ansp = strip_tags($ansp, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $ansp = htmlentities($ansp, ENT_QUOTES, "UTF-8");
        $ansp = preg_replace("!\r?\n!", "", $ansp);
        $ansp = str_replace("&nbsp;", "", $ansp);
        $ansp = str_replace("nbsp;", "", $ansp);
        $ansp = str_replace("&amp;", "", $ansp);
        $returnValue['answer'] = $ansp;
        $ansext = $row['description'];
        $ansext = utf8_encode($ansext);
        $ansext = strip_tags($ansext, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $ansext = htmlentities($ansext, ENT_QUOTES, "UTF-8");
        $ansext = preg_replace("!\r?\n!", "", $ansext);
        $ansext = str_replace("&nbsp;", "", $ansext);
        $ansext = str_replace("nbsp;", "", $ansext);
        $ansext = str_replace("&amp;", "", $ansext);
        $returnValue['solution'] = $ansext;
        
        //2
        
        
        
	
		}
	
	
		    
		 
		}
		
	
		return $returnValue;	
		
		}
	mysqli_close($conn);	
  
  ?>
 
