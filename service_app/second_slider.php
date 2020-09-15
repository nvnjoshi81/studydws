<?php 
        error_reporting(0);
	    include ('config.php');
	 	$user_key = $_POST['user_key'];
	    $user_id = $_POST['user_id'];
	    $device_id = $_POST['device_id'];
	    $class_id = $_POST['class_id'];
		$subject_id = $_POST['subject_id'];
	    $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'";
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
        $result = mysqli_query($conn,"SELECT C.id, C.exam_id, C.subject_id, C.chapter_id, C.item_id, C.type, C.price, C.discounted_price, C.description, C.offline_status, image, C.modules_item_id, C.modules_item_name, C.no_of_dvds, C.subscription_expiry, C.no_of_lectures, C.lecture_duration, C.no_of_subscribers, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmspricelist C LEFT JOIN categories ON C.exam_id=categories.id LEFT JOIN cmssubjects ON C.subject_id=cmssubjects.id LEFT JOIN cmschapters ON C.chapter_id=cmschapters.id WHERE (type = 2 or type = 1 or type = 3) AND exam_id = '$class_id' AND chapter_id = '0' AND subject_id = '$subject_id' AND item_id =0 GROUP BY C.id");
        while($row = mysqli_fetch_array($result)) {
			 $mar_id = $row['id'];
			$job = array();
			$qryusrsrch = "SELECT * FROM cmsorders INNER JOIN cmsorder_details on cmsorders.id = cmsorder_details.order_id WHERE cmsorders.user_id = '$user_id' AND cmsorder_details.product_id = '$mar_id' AND cmsorders.status = '1'";
			$result1 = mysqli_query($conn, $qryusrsrch);
			$numr = mysqli_num_rows($result1);
			if($numr < 1)
			{
			$job = getcoursebycat($mar_id,$conn,$class_id);
			$subTmp[] = $job;
			}
		}
		
		if($subTmp){
    		$tmp['status'] = "success";
			$tmp['data'] = $subTmp;
		}
		else {
		    $tmp['status'] = "fail";
			$tmp['data'] = "no data";
		
			}
		echo json_encode($tmp);
		function getcoursebycat($mar_id,$conn,$class_id) {		
			$returnValue = array();
	
			$result = mysqli_query($conn, "SELECT * FROM cmspricelist WHERE id = '$mar_id'");
			while($rows = mysqli_fetch_array($result)) 
			{
			$returnValue['item_id'] = $rows['item_id'];
			$returnValue['id'] = $mar_id;
			$returnValue['type'] = $rows['type'];
			$returnValue['modules_item_name'] = $rows['modules_item_name'];
			$returnValue['price'] = $rows['price'];
			$dscprice = $rows['discounted_price'];
			if($dscprice < 1)
			{
			    $returnValue['discounted_price'] = $rows['price'];
			}
			else
			{
			    $returnValue['discounted_price'] = $rows['discounted_price'];
			}
			
			$img = "http://dev.hybridinfotech.com/assets/frontend/product_images/studypackage_blank.png";
			if($rows['app_image'] > "")
			{
			   $returnValue['image'] = "http://studyadda.com/assets/frontend/product_images/".$rows['app_image'];
			}
			else
			{
			    $returnValue['image'] = $img;
			}
			}
	        return $returnValue;
		}
  ?>
 
