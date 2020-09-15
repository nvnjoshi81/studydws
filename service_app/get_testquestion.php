<?php 
	include ('config.php');
	 	 $id = $_POST['id'];
	 	 $usertest_id = $_POST['usertest_id'];
	
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
		    //echo "SELECT * FROM cmsonlinetest_details WHERE onlinetest_id = '$mar_id'";
			$result = mysqli_query($conn, "SELECT * FROM cmsquestions WHERE id = '$mar_id'");
			while($row = mysqli_fetch_array($result)) 
			{
			//$returnValue['question'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['question']);
			$str = $row['question'];
    		$str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
         	$returnValue['question'] = $str;
            $returnValue['id'] = $iid = $row['id'];$returnValue['type'] = $row['type'];
            $returnValue['question_url'] = "https://www.studyadda.com/apponline-test/qinfo/".$row['id'];
            $returnValue['question_answer_url'] = "https://studyadda.com/apponline-test/app-paper/qid/".$row['id'];
			$result = mysqli_query($conn,"SELECT * FROM cmsanswers WHERE question_id = '$iid'");
        	while($row = mysqli_fetch_array($result)) 
        	{
        	    $chapid = $row['id'];
        		$chap = getchapbysub($chapid,$conn,$mar_id);
        		$subchap[] = $chap;
        		$returnValue['answer'] = $subchap;
        	}
			}
	        	return $returnValue;
		}
		
		function getchapbysub($chapid,$conn,$mar_id) {
		    
		    
		$returnValue = array();
//	echo "SELECT * FROM cmsanswers where id = '$chapid' " ;
		$result = mysqli_query($conn, "SELECT * FROM cmsanswers where id = '$chapid' ");
		while($row = mysqli_fetch_array($result)) 
		{

		 //$returnValue['answer'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['answer']);
    		$str = $row['answer'];
    		$str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
            //$str = str_replace("\\", "\", $str);
         	$returnValue['answer'] = $str;
            $returnValue['answer_id']  = 	$row['id'];
            
            $returnValue['answer_correct']  = 	$row['is_correct'];
            
            
             $usertest_id = $_POST['usertest_id'];
             $sels = "SELECT * FROM cmsusertest_detail where question_id = '$mar_id' and usertest_id = '$usertest_id'";
$osdp = mysqli_query($conn,$sels);
 $ryy = mysqli_num_rows($osdp);
if($ryy){
while($ssr = mysqli_fetch_array($osdp))
{ $returnValue['is_selected']  = 	$ssr['users_answer'];}
    } else { $returnValue['is_selected']  =""; }
}
		
	
		return $returnValue;	
		
		}
		
  
  ?>
 
