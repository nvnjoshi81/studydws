<?php
error_reporting(0);$qry;
	include('config.php');
	
	
		$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	if($_REQUEST['class_id'] != "")
	$class_id = $_REQUEST['class_id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
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
	if ($class_id != "")
    {
        $qry = "SELECT cmspricelist.id as productlist_id, cmspricelist.exam_id, cmspricelist.subject_id, cmspricelist.chapter_id, cmspricelist.item_id, cmspricelist.type, cmspricelist.price, cmspricelist.discounted_price, cmspricelist.description, cmspricelist.offline_status, cmspricelist.image, cmspricelist.modules_item_id, cmspricelist.modules_item_name, cmsfiles.displayname, cmsfiles.filename, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmspricelist LEFT JOIN categories ON cmspricelist.exam_id=categories.id LEFT JOIN cmssubjects ON cmspricelist.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmspricelist.chapter_id=cmschapters.id LEFT JOIN cmsfiles ON cmsfiles.id=cmspricelist.item_id WHERE cmspricelist.type = 2 AND cmspricelist.price >0 AND cmspricelist.exam_id = '$class_id' GROUP BY cmspricelist.id ORDER BY cmspricelist.price DESC, cmspricelist.id DESC";
    }
    else
    {
        $qry = "SELECT cmspricelist.id as productlist_id, cmspricelist.exam_id, cmspricelist.subject_id, cmspricelist.chapter_id, cmspricelist.item_id, cmspricelist.type, cmspricelist.price, cmspricelist.discounted_price, cmspricelist.description, cmspricelist.offline_status, cmspricelist.image, cmspricelist.modules_item_id, cmspricelist.modules_item_name, cmsfiles.displayname, cmsfiles.filename, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmspricelist LEFT JOIN categories ON cmspricelist.exam_id=categories.id LEFT JOIN cmssubjects ON cmspricelist.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmspricelist.chapter_id=cmschapters.id LEFT JOIN cmsfiles ON cmsfiles.id=cmspricelist.item_id WHERE cmspricelist.type = 2 AND cmspricelist.price >0 GROUP BY cmspricelist.id ORDER BY cmspricelist.price DESC, cmspricelist.id DESC";
    }

if($get_api){
	$result = mysqli_query($conn,$qry);
}

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['productlist_id'];
		
		$job = array();
		/*$qry = "SELECT count(*) as item_count FROM `cmsorder_details` INNER JOIN cmsorders ON cmsorder_details.order_id = cmsorders.id WHERE cmsorder_details.product_id = '$mar_id' AND cmsorders.user_id = '$user_id'";
		$result_order = mysqli_query($conn,$qry);
		$num_order = mysqli_num_array($result_order);
		$job = array();
		if($num_order >= 1)
		{
		    
		}
		else
		{*/
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
		//}
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM cmspricelist WHERE id = '$mar_id'");
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
			
			$img = "http://dev.hybridinfotech.com/assets/frontend/product_images/studypackage_blank.png";
			if($rows['app_image'] > "")
			{
			   $returnValue['image'] = "http://studyadda.com/assets/frontend/product_images/".$rows['app_image'];
			}
			else
			{
			    $returnValue['image'] = $img;
			}
			$returnValue['id'] = $rows['id'];
			}
			return $returnValue;
	}
	
?>
