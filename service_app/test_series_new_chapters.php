<?php
error_reporting(0);
	include('config.php');
	
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$subject_id = $_POST['subject_id'];
	$category_id = $_POST['category_id'];
	$created_from_id = $_POST['created_from_id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	  while($ryu = mysqli_fetch_array($oppf)){
	$get_api = $ryu['user_key'];
	  }
  }
    $va =array();
    $tmp=array();
   // echo "SELECT cmschapters.id as id, cmschapters.name as cname, cmssubjects.id as sid, cmssubjects.name as sname FROM cmschapter_details cd JOIN cmschapters ON cd.chapter_id = cmschapters.id JOIN cmssubjects ON cd.subject_id = cmssubjects.id WHERE cd.class_id = '$category_id' AND cd.subject_id = '$subject_id' ORDER BY cd.sortorder ASC, cd.id ASC";
    $result = mysqli_query($conn,"SELECT cmschapters.id as id, cmschapters.name as cname, cmssubjects.id as sid, cmssubjects.name as sname FROM cmschapter_details cd JOIN cmschapters ON cd.chapter_id = cmschapters.id JOIN cmssubjects ON cd.subject_id = cmssubjects.id WHERE cd.class_id = '$category_id' AND cd.subject_id = '$subject_id' ORDER BY cd.sortorder ASC, cd.id ASC");
    while($row = mysqli_fetch_array($result)) {
		 $id = $row['id'];
	$data = get_date($conn,$id,$category_id,$created_from_id,$subject_id);
	
	if($data){
	    $va[]=$data;
	}
   }
   
   if(count($va)>0){
       $tmp['status'] = "success";$tmp['data'] = $va; }
		
   else {$tmp['status'] = "false";$tmp['data'] = "no data";}
 //	echo "<pre>";
	//	print_r($tmp);
	//	echo "<pre>";
  echo json_encode($tmp);
  
  function get_date($conn,$id,$category_id,$created_from_id,$subject_id){
        
         $returnValue=array();
         $arr = array();
        // echo "Select DISTINCT cmschapters.name as chapter, cmschapters.id FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE  cmschapters.id = '$id'";
         $result1 = mysqli_query($conn,"Select DISTINCT cmschapters.name as chapter, cmschapters.id FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE  cmschapters.id = '$id'");
		if($rows = mysqli_fetch_array($result1))
		{   
		   $result0 = mysqli_query($conn,"SELECT cmsonlinetest.name, cmsonlinetest.id FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest_relations.exam_id = '$category_id' AND cmsonlinetest.created_from_id = '$created_from_id' AND cmssubjects.id = '$subject_id' AND cmschapters.id = '$id'");
		   	while($row = mysqli_fetch_array($result0)) {$mar_id = $row['id'];}
		   	
		  $result2 = mysqli_query($conn,"SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest.exam_id, cmsonlinetest.subject_id, cmsonlinetest.chapter_id, cmsonlinetest.formula_id 
		, cmsonlinetest.time, cmsonlinetest.calculater, cmsonlinetest.qus_pdf, cmsonlinetest.ans_pdf, cmsonlinetest.solution_pdf, cmsonlinetest.view_count FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest.id = '$mar_id'");
             $nn = mysqli_num_rows($result2);
		 //echo $nn;
			if($nn>0){ 
	        $returnValue['chapter'] =  $rows['chapter'];
		    $returnValue['chapter_id']  = $rows['id'];
		
		    $arr=$returnValue;
			}
		}
				return $ress=(count($arr))? $arr : false;
		}
	
    mysqli_close($conn);		
  
?>
