<?php
error_reporting(0);
include('../../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
$cat_id = $_GET['exam_id'];
$typeid = $_GET['typeid'];
 $classname = $_GET['classname'];

//$subject_id = $_GET['subject_id'];
	 header("Access-Control-Allow-Origin: *");
		
  $result = mysqli_query($conn, "SELECT * from cmsncertsolutions where  is_deleted='1'  ORDER BY id DESC LIMIT 12");
        if (!$result) {
            die('Invalid query: ' . mysqli_error());
        } else {
            $data = array();
            while ($row = mysqli_fetch_array($result)) {          
                $data[] = "Ncert-solution for  ".$classname  ;         
            }
            echo json_encode($data);
        }
	
	
?>
