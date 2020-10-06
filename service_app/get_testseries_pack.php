<?php
error_reporting(0);
	include('config.php');
	$qry;$testid;$level;
	$testid = $_POST['id'];
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];
	$device_id = $_POST['device_id'];
	$level = $_POST['level'];
	
	if($subject_id)
	{
	    $qry = "SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest_relations.exam_id, cmsonlinetest_relations.subject_id, cmsonlinetest_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest_relations.exam_id = '$category' AND cmsonlinetest_relations.subject_id = '$subject_id' ORDER BY cmsonlinetest.id DESC";
	}
	else if($category)
	{
	  $qry = "SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest_relations.exam_id, cmsonlinetest_relations.subject_id, cmsonlinetest_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest_relations.exam_id = '$category' ORDER BY cmsonlinetest.id DESC";  
	}
	if($chapter_id)
	{
	  $qry = "SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest_relations.exam_id, cmsonlinetest_relations.subject_id, cmsonlinetest_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest_relations.exam_id = '$category' AND cmsonlinetest_relations.subject_id = '$subject_id'  AND cmsonlinetest_relations.chapter_id = '$chapter_id' ORDER BY cmsonlinetest.id DESC";
	}
	if($testid)
	{
	    $qry = "SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest_relations.exam_id, cmsonlinetest_relations.subject_id, cmsonlinetest_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest.id = '$testid'  ORDER BY cmsonlinetest.id DESC";
	}
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
      $res_2 ="" ; 
if($get_api){
    //$qry = "SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest_relations.exam_id, cmsonlinetest_relations.subject_id, cmsonlinetest_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest_relations.exam_id = '79' ORDER BY cmsonlinetest.id DESC";

}
        	$result2 = mysqli_query($conn,$qry);

             $res_2 = mysqli_num_rows($result2);
  if($res_2 > 0)
    { 
        	while($row = mysqli_fetch_array($result2)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn,$user_id);
		$subTmp[] = $job;
	}
    }
	
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);

	function getmarvelcategory($mar_id,$conn,$user_id) {		
		$returnValue = array();
		$qry = "SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest_relations.exam_id, cmsonlinetest_relations.subject_id, cmsonlinetest_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest.id = '$mar_id'";
		$result = mysqli_query($conn,$qry);
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['title'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
		$returnValue['id'] =$pid= $mar_id; //jk $row['id'];
		$returnValue['class_id'] = $row['exam_id'];
        $returnValue['subject_id'] = $row['subject_id'];
        $returnValue['chapter_id'] = $row['chapter_id'];
        $level = $_POST['level'];
        if($level == "home"){
		//$returnValue['level'] = "home";
		$category = $_POST['category_id'];
		$qry1 = "SELECT C.id FROM cmspricelist C LEFT JOIN categories ON C.exam_id=categories.id LEFT JOIN cmssubjects ON C.subject_id=cmssubjects.id LEFT JOIN cmschapters ON C.chapter_id=cmschapters.id WHERE type = 3 AND exam_id = '$category' AND chapter_id = '0' AND subject_id = '0' AND item_id = '0' GROUP BY C.id";
		$result1 = mysqli_query($conn,$qry1);
		if($row1 = mysqli_fetch_array($result1)) 
		{
		     //$returnValue['id'] =
		     $pid= $row1['id'];
		}
		}
		else
		{
		    // $returnValue['id'] =
		     $pid= $row['id'];
		}
		$num = $row['id'];
		$las = $num%10;
		$imm = "http://dev.hybridinfotech.com/assets/frontend/images/0";
	    $returnValue['image'] = $imm.$las.".jpg";
		$tim = time();
	    $resultg = "SELECT * FROM cmsorders join cmsorder_details on cmsorders.id =  cmsorder_details.order_id join cmspricelist on cmspricelist.id=cmsorder_details.product_id  where  cmsorders.user_id = '$user_id' and cmspricelist.type='3'  and cmsorder_details.product_id = '$pid' GROUP BY cmspricelist.modules_item_name ORDER BY cmsorders.id";
		$myss = mysqli_query($conn, $resultg);
		$coo = mysqli_num_rows($myss);
		if($coo){
		      
		       	$returnValue['activate'] =  "yes active";
			$rowg = ($rtt=mysqli_fetch_array($myss));
		{
		    	$returnValue['start_date'] =  $rowg['dt_created'];
		    	$returnValue['end_date'] =   $rowg['end_date'];
		}
		    }
		    else {
			 $returnValue['activate'] =  "no active";
					$returnValue['start_date'] =  "";
		    	$returnValue['end_date'] =   "";
		    }	
		
		}
		return $returnValue;
	}
	
	mysqli_close($conn);
	
?>
