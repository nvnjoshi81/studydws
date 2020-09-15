<?php
error_reporting(0);
include('../../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
 $cat_id = $_GET['types'];
 $containtype = $_GET['containtype'];
 header("Access-Control-Allow-Origin: *");

if($containtype==1){ $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id' AND 
  `cmspricelist`.`type` = '$containtype' and `cmspricelist`.`subscription_expiry`='1' and `cmspricelist`.`subject_id`='0' and `cmspricelist`.`chapter_id`='0' AND
  `cmspricelist`.`price` > '0' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");
}

if($containtype==2){ $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id'  AND 
  `cmspricelist`.`type` = '$containtype' AND `cmspricelist`.`price` > '0' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");
}


if($containtype==3){ $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id'  AND 
  `cmspricelist`.`type` = '$containtype' AND `cmspricelist`.`price` > '0' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");
}


if($containtype==4){ $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id'  AND 
  `cmspricelist`.`type` = '$containtype' AND `cmspricelist`.`price` > '0' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");
}

if($containtype==5){ $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id'  AND 
  `cmspricelist`.`type` = '$containtype' AND `cmspricelist`.`price` > '0' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");
}

if($containtype==6){ $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id'  AND 
  `cmspricelist`.`type` = '$containtype' AND `cmspricelist`.`price` > '0' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");
}

if($containtype==7){ $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id'  AND 
  `cmspricelist`.`type` = '$containtype' AND `cmspricelist`.`price` > '0' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");
}

if($containtype==8){ $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id'  AND 
  `cmspricelist`.`type` = '$containtype' AND `cmspricelist`.`price` > '0' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");
}

if($containtype==9){ $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id'  AND 
  `cmspricelist`.`type` = '$containtype' AND `cmspricelist`.`price` > '0' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");
}

if($containtype==10){ $result = mysqli_query($conn, "SELECT `cmspricelist`.`id` as `productlist_id`, `cmspricelist`.`exam_id`, `cmspricelist`.`subject_id`,
  `cmspricelist`.`chapter_id`, `cmspricelist`.`item_id`, `cmspricelist`.`type`, `cmspricelist`.`price`, `cmspricelist`.`discounted_price`, 
  `cmspricelist`.`description`, `cmspricelist`.`offline_status`, `cmspricelist`.`image`, `cmspricelist`.`modules_item_id`, `cmspricelist`.`modules_item_name`, 
  `cmsfiles`.`displayname`, `cmsfiles`.`filename`, `categories`.`name` as `exam`, `cmssubjects`.`name` as `subject`, `cmschapters`.`name` as `chapter` FROM `cmspricelist`
  LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` 
  LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE cmspricelist.exam_id='$cat_id'  AND 
  `cmspricelist`.`type` = '$containtype' AND `cmspricelist`.`price` > '0' GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC");
}

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
