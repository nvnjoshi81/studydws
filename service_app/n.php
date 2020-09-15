<?php
/*STUDYPACKAGE*/
error_reporting(E_ALL);
ini_set('max_execution_time', 120); 
ini_set('error_reporting', E_ALL);
if(isset($_REQUEST['product_type'])){
$typeproduct=$_REQUEST['product_type'];
}else{
$typeproduct=1;
}
if(isset($_REQUEST['exam_id'])){
$examid_post=$_REQUEST['exam_id'];
}else{
$examid_post=0;
}
if(isset($_REQUEST['subject_id'])){
$subjectid_post=$_REQUEST['subject_id'];
}else{
$subjectid_post=0;
}
if(isset($_REQUEST['chapter_id'])){
$chapterid_post=$_REQUEST['chapter_id'];
}else{
	$chapterid_post=0;
}
if(isset($_REQUEST['user_id'])){
$user_id = $_REQUEST['user_id'];
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
 /*Get User order product*/ 
	$purchased=array();
	$queryvideoprd="SELECT `A`.`product_id`, `B`.`type` as `product_type`, `B`.`exam_id`, `B`.`subject_id`, `B`.`chapter_id` FROM `cmsorder_details` `A` JOIN `cmsorders` `O` ON `O`.`id`=`A`.`order_id` JOIN `cmspricelist` `B` ON `A`.`product_id`=`B`.`id` WHERE `O`.`user_id` = '".$user_id."' AND `O`.`status` = 1 and `B`.type='".$typeproduct."'";

	$resultQueVidPrd = $mysqli->query($queryvideoprd);
		while($product=$resultQueVidPrd->fetch_array(MYSQLI_ASSOC)) 
			{
		     $purchased[$product['product_type']][]=$product['product_id'];			
			}

foreach ($purchased as $k => $v) {
foreach ($v as $k1 => $v1) {
if(is_array($v1)){
$productResult =NULL;
die($v1.' is not define!');
}else{
	//$productquery="SELECT `P`.`id`, `P`.`exam_id`, `P`.`subject_id`, `P`.`chapter_id`, `P`.`item_id`, `P`.`type`, `P`.`price`, `P`.`discounted_price`, `P`.`description`, `P`.`offline_status`, `P`.`image`, `P`.`modules_item_id`, `P`.`modules_item_name`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist` `P` LEFT JOIN `categories` ON `P`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `P`.`subject_id`=`cmssubjects`.`id` LEFT JOIN `cmschapters` ON `P`.`chapter_id`=`cmschapters`.`id` WHERE `P`.`id` = '".$v1."'";
	
        if(isset($examid_post)){
            $purchased_data_array = array();
            $subjects_array = array();
            $chapters_array = array();
			
            $chaptersubjects_q = " SELECT `cmschapters`.`id` as `cid`, `cmschapters`.`name` as `cname`, `cmssubjects`.`id` as `sid`, `cmssubjects`.`name` as `sname` FROM `cmschapter_details` `cd` JOIN `cmschapters` ON `cd`.`chapter_id` = `cmschapters`.`id` JOIN `cmssubjects` ON `cd`.`subject_id` = `cmssubjects`.`id` WHERE `cd`.`class_id` = '".$examid_post."'";
			if($subjectid_post>0){
			$chaptersubjects_q .=" AND `cmssubjects`.`id` = '".$subjectid_post."'";
			}
            $chaptersubjects_q .=" ORDER BY `cd`.`sortorder` ASC, `cd`.`id` ASC ";
				
	$chaptersubjects_op = $mysqli->query($chaptersubjects_q);
		while($record=$chaptersubjects_op->fetch_array(MYSQLI_ASSOC)) 
			{
				
				if (!in_array($record['sname'], $subjects_array)) {
                    $subjects_array[$record['sid']] = array('name' => $record['sname']);
                    }
					    if ($subjectid_post > 0 && $subjectid_post == $record['sid']) {
						$sm = getStudyMaterialCount($examid_post, $record['sid'], $record['cid'],$mysqli);
						if(!in_array($record['cname'], $chapters_array)) {

                            $chapters_array[$record['cid']] = array('name' => $record['cname'], 'count' => count($sm));
                        } else {
                            $chapters_array[$record['cid']]['count'] = count($sm);
                        }
                    }
					
					
					 if (array_key_exists($record['sname'], $purchased_data_array)) {
                        array_push($purchased_data_array[$record['sname']]['chapters'], array($record['cid'], $record['cname']));
                    } else {
                        $purchased_data_array[$record['sname']]['id'] = $record['sid'];
                        if (isset($purchased_data_array[$record['sname']]['chapters'])) {
                            array_push($purchased_data_array[$record['sname']]['chapters'], array($record['cid'], $record['cname']));
                        } else {
                            $purchased_data_array[$record['sname']]['chapters'][0] = array($record['cid'], $record['cname']);
                        }
                    }	
		}
} 
}
}
}

	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";

 $queryvideolist="SELECT cmsstudymaterial_relations.exam_id,cmsstudymaterial_relations.subject_id,cmsstudymaterial_relations.chapter_id,`F`.`displayname`, `F`.`filename`, `F`.`filepath`, `F`.`filename_one`, `F`.`filepath_one`, `F`.`type`, `F`.`filetype`, `F`.`pagecount`, `F`.`is_deleted`, `F`.`id` as `item_id`, `P`.`price`, `P`.`discounted_price`, `D`.`file_id`, `F`.`filename` as `question`, `A`.`name` as `modules_item_name`, `P`.`id` as `productlist_id` FROM `cmsfiles` `F` JOIN `cmsstudymaterial_details` `D` ON `D`.`file_id`=`F`.`id` JOIN `cmsstudymaterial` `A` ON `A`.`id`=`D`.`studymaterial_id` JOIN `cmsstudymaterial_relations` ON `A`.`id`=`cmsstudymaterial_relations`.`studymaterial_id` LEFT JOIN `cmspricelist` `P` ON `P`.`item_id`=`F`.`id` WHERE `P`.`type` = '".$typeproduct."' and `P`.`item_id`>0 "; 
 
 if(isset($examid_post)&&$examid_post>0){
 $queryvideolist.=" and `cmsstudymaterial_relations`.`exam_id` = '".$examid_post."'"; 
 }
 
 if(isset($subjectid_post)&&$subjectid_post>0){
 $queryvideolist.=" and `cmsstudymaterial_relations`.`subject_id` = '".$subjectid_post."'"; 
 } 
 if(isset($chapterid_post)&&$chapterid_post>0){
 $queryvideolist.=" and `cmsstudymaterial_relations`.`chapter_id` = '".$chapterid_post."'"; 
 }
$queryvideolist.=" ORDER BY `F`.`id` DESC ";
$result=$mysqli->query($queryvideolist);
//echo $queryvideolist
// Perform a query, check for error
if (!$result) {
  echo("Error description: " . $mysqli -> error);
} 
	while($row = $result->fetch_array()) {
	    $playlistId=$row['item_id'];
		$exam_id = $row['exam_id'];
		$subject_id = $row['subject_id'];
		$chapter_id = $row['chapter_id'];
		$playlistname=RemoveSpecialChar($row['displayname']);
	/*Check for purchased product */
    /*chek order made it for or not*/
	$type=1;
	
	$rela = getPackageParent($exam_id,$subject_id,$chapter_id,$type,$mysqli);
	$playtoggel='hide';
	foreach($rela[0] as $k=>$v){
		if(isset($purchased[1])){
	if(in_array($k, $purchased[1])) {
	$playtoggel='show';
	$allproduct_array[$playlistId]=array($playlistId,$exam_id,$subject_id,$chapter_id,$playlistname,$playtoggel);	
	}else{
	$playtoggel='hide';
	$allproduct_array[$playlistId]=array($playlistId,$exam_id,$subject_id,$chapter_id,$playlistname,$playtoggel);
		}
		}
	}				


	$subTmp[] =array($playlistId,$exam_id,$subject_id,$chapter_id,$playlistname,$playtoggel);
/*Start for product check final condition*/

//echo "Users order product";
//print_r($purchased[1]); die;

	}
	
	/*End for product check final condition*/
	//$subTmp[] =array($playlistId,$exam_id,$subject_id,$chapter_id,$playlistname,$playtoggel,$vp[0]);
	
if($subTmp){
	$tmp['status'] = "success"; 
	$tmp['data'] = $subTmp;

}else {
	$tmp['status'] = "false";
	$tmp['data'] = "Chek all Parameters";
	}
	
	echo json_encode($tmp);
	function RemoveSpecialChar($value){
$result  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$value);

return $result;
}
	function getStudyMaterialCount($examid,$subjectid=0,$chapterid=0,$mysqli){
		
		    $sm = "SELECT `cmsstudymaterial`.`id` FROM `cmsstudymaterial` JOIN `cmsstudymaterial_relations` ON `cmsstudymaterial_relations`.`studymaterial_id`=`cmsstudymaterial`.`id` JOIN `cmsstudymaterial_details` ON `cmsstudymaterial_details`.`studymaterial_id`=`cmsstudymaterial`.`id` WHERE `cmsstudymaterial_relations`.`exam_id` = '".$examid."'";
			if(isset($subjectid)&&$subjectid>0){
            $sm .=" AND `cmsstudymaterial_relations`.`subject_id` = '".$subjectid."'"; 
			}
			if(isset($subjectid)&&$subjectid>0){
			$sm .=" AND `cmsstudymaterial_relations`.`chapter_id` = '".$chapterid."'";
			}
	$resultsm = $mysqli->query($sm);
    $resultsm_arr= array();
	while($rows=$resultsm->fetch_array(MYSQLI_ASSOC)){
	$resultsm_arr[]=$rows['id'];
	}
		return $resultsm_arr; 
	}
	
	function getPackageParent($exam_id,$subject_id,$chapter_id,$type,$mysqli){
    	$mproducts=array();
        
		$getproduct_one=getProduct($exam_id,0,0,$type,$mysqli);
        if(isset($getproduct_one)&&count($getproduct_one)>0){
    		 $mproducts[]=$getproduct_one;
    			}
				
        //$getproduct_two=getProduct($exam_id,$subject_id,0,$type,$mysqli);
    	
        if(isset($getproduct_two)&&count($getproduct_two)>0){
    	//$mproducts[]=$getproduct_two;
    	}
	
        return $mproducts; 
	}
	function getProduct($exam_id,$subject_id,$chapter_id,$type,$mysqli){
		/*$productQ_old="SELECT `C`.`id`, `C`.`exam_id`, `C`.`subject_id`, `C`.`chapter_id`, `C`.`item_id`, `C`.`type`, `C`.`price`, `C`.`discounted_price`, `C`.`description`, `C`.`offline_status`, `C`.`image`, `C`.`app_image`, `C`.`modules_item_id`, `C`.`modules_item_name`, `C`.`no_of_dvds`, `C`.`subscription_expiry`, `C`.`no_of_lectures`, `C`.`lecture_duration`, `C`.`no_of_subscribers`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist` `C` LEFT JOIN `categories` ON `C`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `C`.`subject_id`=`cmssubjects`.`id` LEFT JOIN `cmschapters` ON `C`.`chapter_id`=`cmschapters`.`id` WHERE `type` = '".$type."' AND `exam_id` = '".$exam_id."' AND `chapter_id` = '".$chapter_id."' AND `subject_id` = '".$subject_id."' AND `item_id` =0 GROUP BY `C`.`id`";
		*/
			
		$productQ="SELECT `C`.`id`, `C`.`exam_id`, `C`.`subject_id`, `C`.`chapter_id`, `C`.`item_id`, `C`.`type`, `C`.`price`, `C`.`discounted_price`, `C`.`description`, `C`.`offline_status`, `C`.`image`, `C`.`app_image`, `C`.`modules_item_id`, `C`.`modules_item_name`, `C`.`no_of_dvds`, `C`.`subscription_expiry`, `C`.`no_of_lectures`, `C`.`lecture_duration`, `C`.`no_of_subscribers`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist` `C` LEFT JOIN `categories` ON `C`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `C`.`subject_id`=`cmssubjects`.`id` LEFT JOIN `cmschapters` ON `C`.`chapter_id`=`cmschapters`.`id` WHERE `C`.`type` ='".$type."' 
		and `C`.`exam_id` = '".$exam_id."'";
if($subject_id>0){
		$productQ .=" AND `C`.`subject_id` = '".$subject_id."' "; 
}
if($subject_id>0){
		$productQ .=" AND `C`.`chapter_id` = '".$chapter_id."' ";
}
		$productQ.=" AND `C`.`item_id`=0 GROUP BY `C`.`id` ORDER BY `C`.`id` DESC"; 
	
		$result = $mysqli->query($productQ);
		
		while($rows=$result->fetch_array(MYSQLI_ASSOC)){
		$productQ_arr[$rows['id']]=array($rows['modules_item_name']);
	}
	if(is_array($productQ_arr)&&count($productQ_arr)>0){
	return $productQ_arr;
	}else{
		return array();
	}
	}
	
$mysqli -> close();
?>
