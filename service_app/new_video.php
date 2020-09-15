<?php
error_reporting(0);
include ('config.php');
  $user_id = $_POST['user_id'];
  $exam_id = $_POST['exam_id'];
  $subject_id = $_POST['subject_id'];
	$tmp = array();
	$subTmp = array();
	//echo "SELECT cmsvideoslist.name, cmsvideoslist.display_image,cmsvideoslist.id,cmsvideolist_relations.id as v_relations_id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id,categories.name as exam,cmssubjects.name as subject,cmschapters.name as chapter FROM cmsvideolist_relations JOIN categories ON cmsvideolist_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsvideolist_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsvideolist_relations.chapter_id=cmschapters.id JOIN cmsvideoslist ON cmsvideolist_relations.videolist_id=cmsvideoslist.id WHERE cmsvideolist_relations.exam_id = '$exam_id' OR cmsvideolist_relations.subject_id = '$subject_id' GROUP BY cmsvideolist_relations.videolist_id ORDER BY cmsvideoslist.id DESC";exit;
	if($exam_id && $subject_id){
	    
	$result = mysqli_query($conn,"SELECT cmsvideoslist.name, cmsvideoslist.display_image,cmsvideoslist.id,cmsvideolist_relations.id as v_relations_id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id,categories.name as exam,cmssubjects.name as subject,cmschapters.name as chapter FROM cmsvideolist_relations JOIN categories ON cmsvideolist_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsvideolist_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsvideolist_relations.chapter_id=cmschapters.id JOIN cmsvideoslist ON cmsvideolist_relations.videolist_id=cmsvideoslist.id WHERE cmsvideolist_relations.exam_id = '$exam_id' and cmsvideolist_relations.subject_id = '$subject_id' GROUP BY cmsvideolist_relations.videolist_id ORDER BY cmsvideoslist.id DESC");
    }else if($exam_id){
       
	$result = mysqli_query($conn,"SELECT cmsvideoslist.name, cmsvideoslist.display_image,cmsvideoslist.id,cmsvideolist_relations.id as v_relations_id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id,categories.name as exam,cmssubjects.name as subject,cmschapters.name as chapter FROM cmsvideolist_relations JOIN categories ON cmsvideolist_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsvideolist_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsvideolist_relations.chapter_id=cmschapters.id JOIN cmsvideoslist ON cmsvideolist_relations.videolist_id=cmsvideoslist.id WHERE cmsvideolist_relations.exam_id = '$exam_id'  GROUP BY cmsvideolist_relations.videolist_id ORDER BY cmsvideoslist.id DESC");
    }
	while($row = mysqli_fetch_array($result)){
		$id = $row['id'];
	
		$job = array();
		$job = getuser($id,$user_id,$exam_id,$subject_id,$conn);
		$subTmp[] = $job;
	}
	if($subTmp){$tmp['status'] = "true";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);
	mysqli_close($conn);
    
	function getuser($id,$user_id,$exam_id,$subject_id,$conn) {		
		$returnValue = array();
        $result = mysqli_query($conn,"SELECT * FROM cmsvideoslist WHERE id = '$id'");
		if($row = mysqli_fetch_array($result)) 
		{
			
			//$returnValue['video_name'] = $row['name'];
			//$id  = $row['name'];
		
		//	$returnValue['user_lname'] = $row['last_name'];
		//	$returnValue['user_email'] = $row['email'];
			/*$returnValue['user_contact'] = $row['contactno'];*/
		//	$returnValue['address'] = $row['address'];
		  //  $prefiximg = "https://mindnbody.fit/admin/upload/user/";
		//	$returnValue['user_image'] = $prefiximg.$row['image'];
		}
	//	echo "SELECT `P`.*, `P`.`id` as `productlist_id`, `C`.`name` as `exam`, `S`.`name` as `subject`, `CH`.`name` as `chapter` FROM `cmspricelist` `P` JOIN `categories` `C` ON `C`.`id`=`P`.`exam_id` LEFT JOIN `cmssubjects` `S` ON `P`.`subject_id`=`S`.`id` LEFT JOIN `cmschapters` `CH` ON `P`.`chapter_id`=`CH`.`id` WHERE `P`.`exam_id` = '28' AND `P`.`type` = 1 AND `P`.`price` >0 AND `P`.`discounted_price` >0 and `p`.`item_id`=0 ";exit;
		   $resulttt = mysqli_query($conn,"SELECT `P`.*, `P`.`id` as `productlist_id`, `C`.`name` as `exam`, `S`.`name` as `subject`, `CH`.`name` as `chapter` FROM `cmspricelist` `P` JOIN `categories` `C` ON `C`.`id`=`P`.`exam_id` LEFT JOIN `cmssubjects` `S` ON `P`.`subject_id`=`S`.`id` LEFT JOIN `cmschapters` `CH` ON `P`.`chapter_id`=`CH`.`id` WHERE `P`.`exam_id` = '$exam_id' AND `P`.`type` = 1 AND `P`.`price` >0 AND `P`.`discounted_price` >0");
		if($rowss = mysqli_fetch_array($resulttt)) 
		  { 
		      $returnValue['iddddd'] =$rowss['productlist_id'];
		  
		  }
		
	//	echo "select * from cmsvideoslist join cmsorder_details on cmsvideoslist.id =cmsorder_details.product_id join cmsorders on cmsorders.id  WHERE cmsorders.user_id = '$user_id' and cmsorder_details.product_id='$idi'  ";
		    $resultt = mysqli_query($conn,"select * from cmsvideoslist join cmsorder_details on cmsvideoslist.id =cmsorder_details.product_id join cmsorders on cmsorders.id  WHERE cmsorders.user_id = '$user_id' and cmsorder_details.product_id='$idi' ");
		if($rows = mysqli_fetch_array($resultt)) 
		  { 
		     
		     // if($id==$iddd){
		    $returnValue['parchas'] = 1;
		     // }else{
		     //  $returnValue['parchas'] = 0;   
		     // }
		  }
		
			
		
		
		
		return $returnValue;
	}
	
?>

