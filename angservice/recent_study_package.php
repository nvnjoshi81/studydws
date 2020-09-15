<?php
error_reporting(0);
include('../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
$cat_id = $_GET['id'];
//$subject_id = $_GET['subject_id'];
	 header("Access-Control-Allow-Origin: *");
//	echo  "SELECT * from cmspricelist where exam_id = '$cat_id'  and chapter_id = '0' and type='1' and status='show' and item_id > '0' ORDER BY id DESC ";
  $result = mysqli_query($conn, "SELECT * from cmspricelist where exam_id = '$cat_id'  and chapter_id = '0' and type='1' and status='show' and  item_id > '0' ORDER BY id DESC LIMIT 16");
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
