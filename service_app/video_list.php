<?php
error_reporting(E_ALL);
include('config.php');
ini_set('max_execution_time', 120);
if(isset($_POST['product_type'])){
$typeproduct=$_POST['product_type'];
}else{
	$typeproduct=2;
}
if(isset($_POST['exam_id'])){
$examid_post=$_POST['exam_id'];
}else{
	$examid_post=0;
}
if(isset($_POST['subject_id'])){
$subjectid_post=$_POST['subject_id'];
}else{
	$subjectid_post=0;
}
if(isset($_POST['chapter_id'])){
$chapterid_post=$_POST['chapter_id'];
}else{
	$chapterid_post=0;
}
if(isset($_POST['user_id'])){

$user_id = $_POST['user_id'];
}else{
	$user_id = 0;

}
	$user_key = 'SDGP.G2SRYFN';
	
   $get_api='SDGP.G2SRYFN'; 
  $mysqli = new mysqli("localhost","studywhm_study","Study1dd1","studywhm_stdproduction");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
	
 /*Get USer order product*/
 
	$purchased=array();
	$queryvideoprd="SELECT `A`.`product_id`, `B`.`type` as `product_type`, `B`.`exam_id`, `B`.`subject_id`, `B`.`chapter_id` FROM `cmsorder_details` `A` JOIN `cmsorders` `O` ON `O`.`id`=`A`.`order_id` JOIN `cmspricelist` `B` ON `A`.`product_id`=`B`.`id` WHERE `O`.`user_id` = '".$user_id."' AND `O`.`status` = 1";
	$resultQueVidPrd = $mysqli->query($queryvideoprd);
		while($product=$resultQueVidPrd->fetch_array(MYSQLI_ASSOC)) 
			{
		  $purchased[$product['product_type']][]=$product['product_id'];
			
			}
		
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";

 $queryvideolist="SELECT `cmsvideoslist`.`name`, `cmsvideoslist`.`display_image`, `cmsvideoslist`.`id`, `cmsvideolist_relations`.`id` as `v_relations_id`, `cmsvideolist_relations`.`exam_id`, `cmsvideolist_relations`.`subject_id`, `cmsvideolist_relations`.`chapter_id`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmsvideolist_relations` JOIN `categories` ON `cmsvideolist_relations`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmsvideolist_relations`.`subject_id`=`cmssubjects`.`id` LEFT JOIN `cmschapters` ON `cmsvideolist_relations`.`chapter_id`=`cmschapters`.`id` JOIN `cmsvideoslist` ON `cmsvideolist_relations`.`videolist_id`=`cmsvideoslist`.`id` WHERE `cmsvideoslist`.`name`!=''"; 
 
 if(isset($examid_post)&&$examid_post>0){
 $queryvideolist.=" and `cmsvideolist_relations`.`exam_id` = '".$examid_post."'"; 
 }
 
 if(isset($subjectid_post)&&$subjectid_post>0){
 $queryvideolist.=" and `cmsvideolist_relations`.`subject_id` = '".$subjectid_post."'"; 
 } 
 
 if(isset($chapterid_post)&&$chapterid_post>0){
 $queryvideolist.=" and   `cmsvideolist_relations`.`chapter_id` = '".$chapterid_post."'"; 
 }
 
 $queryvideolist.=" GROUP BY `cmsvideolist_relations`.`videolist_id` ORDER BY `cmsvideoslist`.`id` DESC ";

$result=$mysqli->query($queryvideolist);

// Perform a query, check for error
if (!$result) {
  echo("Error description: " . $mysqli -> error);
}

	while($row = $result->fetch_array()) {
	    $playlistId=$row['id'];
		$exam_id = $row['exam_id'];
		$subject_id = $row['subject_id'];
		$chapter_id = $row['chapter_id'];
		$playlistname=$row['name'];
		/*chek order made it for or not*/
		$rela = getVideoParent($playlistId,$mysqli);
			/*Start for product check final condition*/
		$playtoggel='hide';
		foreach($rela as $kp=>$vp){
			if(isset($purchased[$typeproduct])&&count($purchased[$typeproduct])>0){
	if (in_array($vp[0], $purchased[$typeproduct])) {
		
		$playtoggel='show';
	break;	
		}}	
	}
	/*End for product check final condition*/
	$subTmp[] =array($playlistId,$exam_id,$subject_id,$chapter_id,$playlistname,$playtoggel,$vp[0]);
	}
	
if($subTmp){
	$tmp['status'] = "success"; 
	$tmp['data'] = $subTmp; 
}else {
	$tmp['status'] = "false";
	$tmp['data'] = "Chek all Parameters";
	}
	echo json_encode($tmp);
	
	function getVideoParent($playlistId,$mysqli){
		
			$getProductQ="SELECT `A`.`videolist_id`, `A`.`exam_id`, `A`.`subject_id`, `A`.`chapter_id`, `B`.`id`, `B`.`videolist_id`, `B`.`video_id` FROM `cmsvideolist_relations` `A` JOIN `cmsvideolist_details` `B` ON `A`.`videolist_id`=`B`.`videolist_id` WHERE `B`.`videolist_id` = '".$playlistId."'";
			$result = $mysqli->query($getProductQ);
	$rela=$result->fetch_array(MYSQLI_ASSOC);
		
			$mproducts=array();
			if(isset($rela)&&count($rela)>0){
        
            $getproduct_one=getProduct($rela['exam_id'],$rela['subject_id'],$rela['chapter_id'],2,$mysqli);
            if(isset($getproduct_one)&&count($getproduct_one)>0){
				 $mproducts[]=$getproduct_one;
			}
            $getproduct_two=getProduct($rela['exam_id'],$rela['subject_id'],0,2,$mysqli);
			
            if(isset($getproduct_two)&&count($getproduct_two)>0){
				 $mproducts[]=$getproduct_two;
			}
            
            $getproduct_three=getProduct($rela['exam_id'],0,0,2,$mysqli);
			
               if(isset($getproduct_three)&&count($getproduct_three)>0){
				 $mproducts[]=$getproduct_three;
			}
            
	}
        
        return $mproducts; 
	}
	
	function getProduct($exam_id,$subject_id,$chapter_id,$type,$mysqli){
		$productQ="SELECT `C`.`id`, `C`.`exam_id`, `C`.`subject_id`, `C`.`chapter_id`, `C`.`item_id`, `C`.`type`, `C`.`price`, `C`.`discounted_price`, `C`.`description`, `C`.`offline_status`, `C`.`image`, `C`.`app_image`, `C`.`modules_item_id`, `C`.`modules_item_name`, `C`.`no_of_dvds`, `C`.`subscription_expiry`, `C`.`no_of_lectures`, `C`.`lecture_duration`, `C`.`no_of_subscribers`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist` `C` LEFT JOIN `categories` ON `C`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `C`.`subject_id`=`cmssubjects`.`id` LEFT JOIN `cmschapters` ON `C`.`chapter_id`=`cmschapters`.`id` WHERE `type` = '".$type."' AND `exam_id` = '".$exam_id."' AND `chapter_id` = '".$chapter_id."' AND `subject_id` = '".$subject_id."' AND `item_id` =0 GROUP BY `C`.`id`";
		
		$result = $mysqli->query($productQ);
		$productQ=array();
		while($rows=$result->fetch_array(MYSQLI_ASSOC)){
		$productQ=array($rows['id'],$rows['modules_item_name']);
	}
	return $productQ;
	}
	
$mysqli -> close();
?>
