<?php
error_reporting(0);
include('../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
$cat_id = $_GET['id'];
 header("Access-Control-Allow-Origin: *");
  $result = mysqli_query($conn, "SELECT id,exam_name,total_package,module_type from cmspackages_counter where exam_id = '$cat_id' and module_type='sample-papers' and level='exam'");
        if (!$result) {
            die('Invalid query: ' . mysqli_error());
        } else {
            $data = array();
            while ($row = mysqli_fetch_array($result)) {          
                $data[] = $row;           
            }
            echo json_encode($data);
        }
    
	

/*
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
$cat_id = $_GET['id'];
 header("Access-Control-Allow-Origin: *");
  $result = mysqli_query($conn, "SELECT id,exam_name,total_package,module_type from cmspackages_counter where exam_id = '$cat_id' and module_type='solved-papers' and level='exam'");
        if (!$result) {
            die('Invalid query: ' . mysqli_error());
        } else {
            $data = array();
            while ($row = mysqli_fetch_array($result)) {          
                $data[] = $row;           
            }
            echo json_encode($data);
        }
    
	*/
	
		
?>
