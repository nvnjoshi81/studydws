<?php
error_reporting(0);
	include('../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
 $cat_id = $_GET['id'];
$subject_id = $_GET['subject_id'];
	 header("Access-Control-Allow-Origin: *");
		

  $result = mysqli_query($conn, "SELECT `postings`.`id` as `id`, `postings`.`title` as `title`, `relatedpostings`.`category_id`,
		`relatedpostings`.`subject_id`, `relatedpostings`.`chapter_id`, `categories`.`name` as `exam`, 
		`cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `postings` JOIN `relatedpostings`
		ON `relatedpostings`.`article_id`=`postings`.`id` LEFT JOIN `categories` ON `categories`.`id`=`relatedpostings`.
		`category_id` LEFT JOIN `cmssubjects` ON `cmssubjects`.`id`=`relatedpostings`.`subject_id` LEFT JOIN `cmschapters`
		ON `cmschapters`.`id`=`relatedpostings`.`chapter_id` WHERE `relatedpostings`.`category_id` = '$cat_id' AND 
		`relatedpostings`.`top_category_id` = '21' ORDER BY `relatedpostings`.`id`  LIMIT 12");
		 $coos = mysqli_num_rows($result);
  if ($coos!==0) {
            
             $data = array();
            while ($row = mysqli_fetch_array($result)) {          
                $data[] = $row;           
            }
              echo json_encode($data); 
      
  }
       
       else {	
           include('../service_app/config.php');
          /* echo "SELECT `postings`.`id` as `id`, `postings`.`title` as `title`, `postings`.`category_id`, `postings`.`subject_id`, `postings`.`chapter_id`,
		`categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `postings` LEFT JOIN 
		`categories` ON `categories`.`id`=`postings`.`category_id` LEFT JOIN `cmssubjects` ON `cmssubjects`.`id`=`postings`.`subject_id` LEFT JOIN 
		`cmschapters` ON `cmschapters`.`id`=`postings`.`chapter_id` WHERE `category_id` = '102' AND `top_category_id` = '21' ORDER BY `postings`.`id` DESC 
		LIMIT 20";*/
             $resultnew = mysqli_query($conn, "SELECT `postings`.`id` as `id`, `postings`.`title` as `title`, `postings`.`category_id`, `postings`.`subject_id`, `postings`.`chapter_id`,
		`categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `postings` LEFT JOIN 
		`categories` ON `categories`.`id`=`postings`.`category_id` LEFT JOIN `cmssubjects` ON `cmssubjects`.`id`=`postings`.`subject_id` LEFT JOIN 
		`cmschapters` ON `cmschapters`.`id`=`postings`.`chapter_id` WHERE `category_id` = '$cat_id' AND `top_category_id` = '21' ORDER BY `postings`.`id` 
		LIMIT 12");
		
		  $data = array();
            while ($row = mysqli_fetch_array($resultnew)) {   
            
                $data[] = $row;           
            }
             echo json_encode($data);
          }
         
            
           
          
            
        
    
	
	
?>
