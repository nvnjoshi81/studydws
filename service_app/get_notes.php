<?php


error_reporting(0);
	include('config.php');
	
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
		$chapter_id = $_POST['chapter_id'];
	
		$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
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

if($get_api){
    
    if($subject_id == "0" and $chapter_id == "0")
	{
	    $qry = "SELECT postings.id as id, postings.title as title, postings.category_id, postings.subject_id, postings.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM postings LEFT JOIN categories ON categories.id=postings.category_id LEFT JOIN cmssubjects ON cmssubjects.id=postings.subject_id LEFT JOIN cmschapters ON cmschapters.id=postings.chapter_id WHERE category_id = '$category' AND top_category_id = '21' ORDER BY postings.id DESC LIMIT 100";
	}
	else if($subject_id > "0" and $chapter_id == "0")
	{
	    $qry = "SELECT postings.id as id, postings.title as title, postings.category_id, postings.subject_id, postings.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM postings LEFT JOIN categories ON categories.id=postings.category_id LEFT JOIN cmssubjects ON cmssubjects.id=postings.subject_id LEFT JOIN cmschapters ON cmschapters.id=postings.chapter_id WHERE category_id = '$category' AND subject_id = '$subject_id' AND top_category_id = '21' ORDER BY postings.id DESC LIMIT 100";
	}
	else if($subject_id > "0" and $chapter_id > "0")
	{
	    $qry = "SELECT postings.id as id, postings.title as title, postings.category_id, postings.subject_id, postings.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM postings LEFT JOIN categories ON categories.id=postings.category_id LEFT JOIN cmssubjects ON cmssubjects.id=postings.subject_id LEFT JOIN cmschapters ON cmschapters.id=postings.chapter_id WHERE category_id = '$category' AND subject_id = '$subject_id' AND chapter_id = '$chapter_id' AND top_category_id = '21' ORDER BY postings.id DESC LIMIT 100";
	}
	$result = mysqli_query($conn,$qry);
}
    if(mysqli_num_rows($result) > 0)
    {
	while($row = mysqli_fetch_array($result)) {
	   $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn,$i);
		$subTmp[] = $job;
	}
    }
    else
    {   //SELECT `postings`.`id` as `id`, `postings`.`title` as `title`, `relatedpostings`.`category_id`, `relatedpostings`.`subject_id`, `relatedpostings`.`chapter_id`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `postings` JOIN `relatedpostings` ON `relatedpostings`.`article_id`=`postings`.`id` LEFT JOIN `categories` ON `categories`.`id`=`relatedpostings`.`category_id` LEFT JOIN `cmssubjects` ON `cmssubjects`.`id`=`relatedpostings`.`subject_id` LEFT JOIN `cmschapters` ON `cmschapters`.`id`=`relatedpostings`.`chapter_id` WHERE `relatedpostings`.`category_id` = '$category' AND `relatedpostings`.`subject_id` = '$subject_id' AND `relatedpostings`.`chapter_id` = '$chapter_id' AND `relatedpostings`.`top_category_id` = '21' ORDER BY `relatedpostings`.`id` LIMIT 18
        if($subject_id == "0" and $chapter_id == "0")
	{
	    $qry = "SELECT `postings`.`id` as `id`, `postings`.`title` as `title`, `relatedpostings`.`category_id`, `relatedpostings`.`subject_id`, `relatedpostings`.`chapter_id`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `postings` JOIN `relatedpostings` ON `relatedpostings`.`article_id`=`postings`.`id` LEFT JOIN `categories` ON `categories`.`id`=`relatedpostings`.`category_id` LEFT JOIN `cmssubjects` ON `cmssubjects`.`id`=`relatedpostings`.`subject_id` LEFT JOIN `cmschapters` ON `cmschapters`.`id`=`relatedpostings`.`chapter_id` WHERE `relatedpostings`.`category_id` = '$category' AND `relatedpostings`.`top_category_id` = '21' ORDER BY `relatedpostings`.`id` LIMIT 18";
	}
	else if($subject_id > "0" and $chapter_id == "0")
	{
	    $qry = "SELECT `postings`.`id` as `id`, `postings`.`title` as `title`, `relatedpostings`.`category_id`, `relatedpostings`.`subject_id`, `relatedpostings`.`chapter_id`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `postings` JOIN `relatedpostings` ON `relatedpostings`.`article_id`=`postings`.`id` LEFT JOIN `categories` ON `categories`.`id`=`relatedpostings`.`category_id` LEFT JOIN `cmssubjects` ON `cmssubjects`.`id`=`relatedpostings`.`subject_id` LEFT JOIN `cmschapters` ON `cmschapters`.`id`=`relatedpostings`.`chapter_id` WHERE `relatedpostings`.`category_id` = '$category' AND `relatedpostings`.`subject_id` = '$subject_id' AND `relatedpostings`.`top_category_id` = '21' ORDER BY `relatedpostings`.`id` LIMIT 18";
	}
	else if($subject_id > "0" and $chapter_id > "0")
	{
	    $qry = "SELECT `postings`.`id` as `id`, `postings`.`title` as `title`, `relatedpostings`.`category_id`, `relatedpostings`.`subject_id`, `relatedpostings`.`chapter_id`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `postings` JOIN `relatedpostings` ON `relatedpostings`.`article_id`=`postings`.`id` LEFT JOIN `categories` ON `categories`.`id`=`relatedpostings`.`category_id` LEFT JOIN `cmssubjects` ON `cmssubjects`.`id`=`relatedpostings`.`subject_id` LEFT JOIN `cmschapters` ON `cmschapters`.`id`=`relatedpostings`.`chapter_id` WHERE `relatedpostings`.`category_id` = '$category' AND `relatedpostings`.`subject_id` = '$subject_id' AND `relatedpostings`.`chapter_id` = '$chapter_id' AND `relatedpostings`.`top_category_id` = '21' ORDER BY `relatedpostings`.`id` LIMIT 18";
	}
	$result = mysqli_query($conn,$qry);
    if(mysqli_num_rows($result) > 0)
    {
	while($row = mysqli_fetch_array($result)) {
	   $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn,$i);
		$subTmp[] = $job;
	}
    }
    }
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn,$i) {		
		$returnValue = array();
		


	


		$result = mysqli_query($conn,"SELECT * FROM postings where id = '$mar_id' and is_deleted = '1'");
		if($row = mysqli_fetch_array($result)) 
		{
		    
		 
	
		    
		    
		    
            $returnValue['name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['title']);
            $str = $row['description'];
		    $str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
            $str = str_replace("\\", "", $str);
            $returnValue['description'] = $str;
			$returnValue['adtype'] = $row['adtype'];
			$returnValue['meta_keywords'] = $row['meta_keywords'];
			
$returnValue['meta_description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['meta_description']);
			$returnValue['external_url'] = $row['external_url'];
			$returnValue['external_link'] = $row['external_link'];
			$returnValue['published'] = $row['published'];
			$returnValue['views'] = $row['views'];
			$returnValue['hits'] = $row['hits'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['view_count'] = $row['view_count'];
			
				$returnValue['id'] = $num = $row['id'];
			
			 $las = $num%10;
			 $imm = "http://dev.hybridinfotech.com/assets/frontend/images/0";
	$returnValue['image'] = $imm.$las.".jpg";
			
			
			//	$returnValue['imagetagfind'] = $i ; 
			
	             	
			
			

    
		}
		return $returnValue;
	}
	
?>
