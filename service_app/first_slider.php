<?php 
error_reporting(0);
	    include ('config.php');
	 	$user_key = $_POST['user_key'];
    	$user_id = $_POST['user_id'];
    	$device_id = $_POST['device_id'];
    	$class_id = $_POST['class_id'];
	    $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'";
        $oppf = mysqli_query($conn, $self);
        $rww = mysqli_num_rows($oppf);
        if($rww > 0){
    	while($ryu = mysqli_fetch_array($oppf)){
    	$get_api = $ryu['user_key'];
    	 }
        }
        $tmp = array();
        $subTmp = array();$subTmp_false = array();
        $postStatusString = "publish";
        $result = mysqli_query($conn,"SELECT cmspricelist.id, cmspricelist.exam_id, cmspricelist.subject_id,  cmspricelist.chapter_id, cmspricelist.item_id, cmspricelist.type, cmspricelist.price, cmspricelist.discounted_price, cmspricelist.description, cmspricelist.offline_status, cmspricelist.image, cmspricelist.modules_item_id, cmspricelist.modules_item_name, cmsfiles.displayname, cmsfiles.filename, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmspricelist LEFT JOIN categories ON cmspricelist.exam_id=categories.id LEFT JOIN cmssubjects ON cmspricelist.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmspricelist.chapter_id=cmschapters.id LEFT JOIN cmsfiles ON cmsfiles.id=cmspricelist.item_id WHERE cmspricelist.type in(2,1,3) AND cmspricelist.price >0 and item_id=0 and  cmspricelist.exam_id ='$class_id' and cmspricelist.subject_id = '0' AND cmspricelist.type = '1' GROUP BY cmspricelist.id ORDER BY cmspricelist.price DESC, cmspricelist.id DESC");
		while($row = mysqli_fetch_array($result)) 
		{
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
			else
			{
            $pack_details = get_order_details($mar_id,$conn,$class_id,$user_id);
            $subTmp_false[] = $pack_details;
			}
		}
		if($subTmp){
		    $tmp['status'] = "success";
			$tmp['data'] = $subTmp;
		}
		else if($subTmp_false) {
		    $tmp['status'] = "false";
			$tmp['data'] = $subTmp_false;
		}
		else {
		    $tmp['status'] = "false";
			$tmp['data'] = "no data";
		}
		echo json_encode($tmp);
		function getcoursebycat($mar_id,$conn,$class_id) 
		{		
			$returnValue = array();
			$result = mysqli_query($conn, "SELECT * FROM cmspricelist WHERE id = '$mar_id'");
			while($rows = mysqli_fetch_array($result)) 
			{
			$returnValue['item_id'] = $rows['item_id'];
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
			
			$img = "http://studyadda.com/assets/frontend/product_images/studypackage_blank.png";
			if($rows['thumb_image'] > "")
			{
			   $returnValue['image'] = "https://studyadda.com/assets/images/".$rows['thumb_image'];
			}
			else
			{
			    $returnValue['image'] = $img;
			}
			$returnValue['id'] = $rows['id'];
			}
			return $returnValue;
		}
		function get_order_details($mar_id,$conn,$class_id,$user_id)
		{
		$returnValue = array();
		$qry_order = "SELECT * FROM cmsorders INNER JOIN cmsorder_details on cmsorders.id = cmsorder_details.order_id WHERE cmsorders.user_id = '$user_id' AND cmsorder_details.product_id = '$mar_id'";
		$result_order = mysqli_query($conn, $qry_order);
		while($rows = mysqli_fetch_array($result_order)) 
		{
		    $epoch = $rows['created_dt'];;
            $dt = new DateTime("@$epoch");  // convert UNIX timestamp to PHP DateTime
            $dt = $dt->format('Y-m-d'); // output = 2017-01-01 00:00:00
            //$dt = $dt->modify('+1 years');
            $dt = strtotime($dt);$dt = strtotime('+1 years', $dt);$dt = date('Y-m-d', $dt);
            $result = mysqli_query($conn, "SELECT * FROM cmspricelist WHERE id = '$mar_id'");
			while($row = mysqli_fetch_array($result)) 
			{
			    $returnValue['modules_item_name'] = $row['modules_item_name'];
			}
			$date=date_create("2023-03-31");
            $mm = date_format($date,"Y-m-d");
			$returnValue['expiry_date'] = $mm;
            
		}
		return $returnValue;
		}
		
		/*function getchapbysub($chapid,$conn,$class_id) 
		{
		$returnValue = array();
        $result = mysqli_query($conn, "SELECT * FROM cmspricelist  where id = '$chapid' ");
		while($rows = mysqli_fetch_array($result)) 
		{

			$returnValue['item_id'] = $rows['item_id'];
			$returnValue['type'] = $rows['type'];
			$returnValue['price'] = $rows['price'];
			$returnValue['discounted_price'] = $rows['discounted_price'];
			$returnValue['offline_status'] = $rows['offline_status'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $rows['description']);
			$returnValue['modules_item_id'] = $rows['modules_item_id'];
			$returnValue['modules_item_name'] = $rows['modules_item_name'];
			$returnValue['no_of_dvds'] = $rows['no_of_dvds'];
			$returnValue['no_of_lectures'] = $rows['no_of_lectures'];
			$returnValue['subscription_expiry'] = $rows['subscription_expiry'];
			$returnValue['lecture_duration'] = $rows['lecture_duration'];
			$returnValue['id'] = $rows['id'];
			$img = "http://studyadda.com/assets/frontend/product_images/studypackage_blank.png";
			if($rows['image'] > "")
			{
			   $returnValue['image'] = "https://studyadda.com/assets/images/".$rows['thumb_image'];
			}
			else
			{
			    $returnValue['image'] = $img;
			}
	
		}
		
	
		return $returnValue;	
		
		}*/

    	mysqli_close($conn);	
  
  ?>
 
