<?php
error_reporting(0);
include('../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
//$exam_id = $_GET['exam_id'];
//$subject_id = $_GET['subject_id'];
 header("Access-Control-Allow-Origin: *");
  $result = mysqli_query($conn, "SELECT `V`.`id`, `title`, `V`.`video_source`, `V`.`video_url_code`, `V`.`video_file_name`, `V`.`video_image`, `V`.`short_video`,
  `V`.`is_featured`, `V`.`description`, `V`.`video_by`, `V`.`status`, `V`.`views`, `V`.`is_free`, `V`.`video_duration`, `V`.`custom_video_duration`, `V`.`amazonaws_link`,
  `V`.`amazon_cloudfront_domain`, `L`.`name` as `playlist`, `C`.`name` as `exam`, `S`.`name` as `subject`, `CH`.`name` as `chapter` FROM `cmsvideos` `V` JOIN `cmsvideolist_details`
  `VD` ON `V`.`id`=`VD`.`video_id` JOIN `cmsvideolist_relations` `R` ON `R`.`videolist_id`=`VD`.`videolist_id` JOIN `categories` `C` ON `C`.`id`=`R`.`exam_id` 
  LEFT JOIN `cmssubjects` `S` ON `R`.`subject_id`=`S`.`id` LEFT JOIN `cmschapters` `CH` ON `R`.`chapter_id`=`CH`.`id` JOIN `cmsvideoslist` `L` ON `L`.`id`=`VD`.`videolist_id` 
  WHERE `V`.`video_source` = 'youtube' AND `V`.`is_featured` = 1 AND `V`.`video_tag` != 'Career Point' AND `V`.`video_url_code` != '' GROUP BY `V`.`id` ORDER BY RAND() LIMIT 10");
        if (!$result) {
            die('Invalid query: ' . mysqli_error());
        } else {
            $data = array();
            while ($row = mysqli_fetch_array($result)) {          
                $data[] = $row;           
            }
            echo json_encode($data);
        }
    
	
	
?>
