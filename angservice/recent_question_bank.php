<?php
error_reporting(0);
	include('../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
$cat_id = $_GET['id'];
$subject_id = $_GET['subject_id'];
	 header("Access-Control-Allow-Origin: *");
		
		
  $result = mysqli_query($conn, "SELECT * from cmsquestionbank_relations join  cmschapters on cmsquestionbank_relations.chapter_id=cmschapters.id where cmsquestionbank_relations.exam_id = '$cat_id' ORDER BY cmsquestionbank_relations.id desc LIMIT 12");
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
