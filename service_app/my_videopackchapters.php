<?php
	include('config.php');
	error_reporting(0);
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$class_id = $_POST['class_id'];
	$subject_id = $_POST['subject_id'];
$va =array();
$tmp=array();
 $result = mysqli_query($conn,"SELECT cmschapters.id as chapter_id, cmschapters.name as cname, cmssubjects.id as sid, cmssubjects.name as sname FROM cmschapter_details cd JOIN cmschapters ON cd.chapter_id = cmschapters.id JOIN cmssubjects ON cd.subject_id = cmssubjects.id WHERE cd.class_id = '$class_id' AND cd.subject_id='$subject_id' ORDER BY cd.sortorder ASC, cd.id ASC" );
while($row = mysqli_fetch_array($result)) {
		  $chapter_id = $row['chapter_id'];
	$data = get_date($conn,$chapter_id,$class_id,$subject_id);
	
	if($data){
	    $va[]=$data;
	}
   }
   
   if(count($va)>0){
       $tmp['status'] = "success";$tmp['datatwo'] = $va; }
		
   else {$tmp['status'] = "false";$tmp['datatwo'] = "no data";}
 //	echo "<pre>";
	//	print_r($tmp);
	//	echo "<pre>";
  echo json_encode($tmp);
  
  function get_date($conn,$chapter_id,$class_id,$subject_id){
        
         $returnValue=array();
         $arr = array();
         $result = mysqli_query($conn,"SELECT * FROM cmschapters WHERE id = '$chapter_id'");
		if($rows = mysqli_fetch_array($result))
		{         $cha = $rows['id'];       
     	$result1 = mysqli_query($conn,"SELECT cmsvideoslist.name, cmsvideoslist.display_image, cmsvideoslist.id, cmsvideolist_relations.id as v_relations_id, cmsvideolist_relations.exam_id, cmsvideolist_relations.subject_id, cmsvideolist_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsvideolist_relations JOIN categories ON cmsvideolist_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsvideolist_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsvideolist_relations.chapter_id=cmschapters.id JOIN cmsvideoslist ON cmsvideolist_relations.videolist_id=cmsvideoslist.id WHERE cmsvideolist_relations.exam_id = '$class_id' AND cmsvideolist_relations.subject_id = '$subject_id' AND cmsvideolist_relations.chapter_id = '$cha' GROUP BY cmsvideolist_relations.videolist_id ORDER BY cmsvideoslist.id DESC");	 
 
         $nn = mysqli_num_rows($result1);
		 
			if($nn>0){ 
		    
			$class_id = $_POST['class_id'];
	        $subject_id = $_POST['subject_id'];
			$returnValue['class_id'] = $class_id;
			$returnValue['subject_id'] = $subject_id;
			$returnValue['chapter_id'] = $rows['id'];
			$str = $rows['name'];
		    $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['chapter_name'] = $str;
		
		    $arr=$returnValue;
			}
			
		}
		return $ress=(count($arr))? $arr : false;
		
  }
  
  

?>