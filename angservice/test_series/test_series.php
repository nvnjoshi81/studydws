<?php
error_reporting(0);
include('../../service_app/config.php');
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
$cat_id = $_GET['id'];
 header("Access-Control-Allow-Origin: *");
//echo  "SELECT * from cmspricelist join cmspackages_counter on  cmspricelist.exam_id=cmspackages_counter.exam_id where cmspricelist.subscription_expiry='1' and cmspricelist.subject_id='0' and cmspricelist.type='1' order by cmspricelist.id desc";
  $result = mysqli_query($conn, "SELECT * from cmspricelist join cmspackages_counter on  cmspricelist.exam_id=cmspackages_counter.exam_id where cmspricelist.subscription_expiry='1' and cmspricelist.subject_id='0' and cmspricelist.type='3'  GROUP BY cmspricelist.modules_item_name order by cmspricelist.id asc");
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
