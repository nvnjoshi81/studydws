<?php
error_reporting(0);
include('../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
$cat_id = $_GET['id'];
 header("Access-Control-Allow-Origin: *");
  $result = mysqli_query($conn, "SELECT count(*) FROM `cmsvideolist_details` WHERE `videolist_id` = '$cat_id'");
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
