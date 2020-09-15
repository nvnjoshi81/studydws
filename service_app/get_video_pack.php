<?php
error_reporting(0);

 date('m/d/Y H:i:s', 1535950953);

	include('config.php');
	
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];
	$device_id = $_POST['device_id'];
	
		if($subject_id){
	    $sub = "and subject_id = '$subject_id'";
	}
	else {
	  $sub = "";  
	}
	
		if($chapter_id){
	    $chh = "and chapter_id = '$chaptert_id'";
	}
	else {
	  $chh = "";  
	}
	
	
	
	
		$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
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

if($get_api){
    $qry = "SELECT * FROM cmspricelist where exam_id = '$category' and type = '2' $sub $chh ORDER BY discounted_price DESC";
	$result = mysqli_query($conn,$qry);
}

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn,$user_id);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn,$user_id) {		
		$returnValue = array();
		$qry = "SELECT * FROM cmspricelist where id = '$mar_id'";
		$result = mysqli_query($conn,$qry);
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['title'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['modules_item_name']);
         $returnValue['subscription_expiry'] = $row['subscription_expiry'];
         $returnValue['class_id'] = $row['exam_id'];
         $returnValue['subject_id'] = $row['subject_id'];
         $returnValue['chapter_id'] = $row['chapter_id'];
			$returnValue['id'] = $pid = $row['id'];
			 $num = $row['id'];
			 $las = $num%10;
			 $imm = "http://dev.hybridinfotech.com/assets/frontend/images/";
	$returnValue['video_image'] = $imm.$las.".png";
	
//	echo "SELECT * FROM cmscart join cmscart_items on cmscart.id=cmscart_items.cart_id where cmscart.user_id = '$user_id' and cmscart_items.product_id = '$pid'";

$tim = time();

/*	 $resultg = "SELECT * FROM cmscart join cmscart_items on cmscart.id=cmscart_items.cart_id where cmscart.user_id = '$user_id' and cmscart_items.product_id = '$pid'
		and cmscart_items.end_date > '$tim'";*/
		
        $resultgd = "SELECT * FROM cmsorders join cmsorder_details on cmsorders.id =  cmsorder_details.order_id join cmspricelist on cmspricelist.id=cmsorder_details.product_id  where  cmsorders.user_id = '$user_id' and cmspricelist.type='2'  and cmsorder_details.product_id = '$pid' GROUP BY cmspricelist.modules_item_name ORDER BY cmsorders.id";	
	
	

		$myss = mysqli_query($conn, $resultgd);
		$coo = mysqli_num_rows($myss);
		if($coo > 0){
		    
		    	$returnValue['activate'] =  "yes active";
		
		$rowg = ($rtt=mysqli_fetch_array($myss));
		{
		    	$returnValue['start_date'] =  $rowg['dt_created'];
		    	$returnValue['end_date'] =   $rowg['end_date'];
		    
		}
		    }
		    else {
				$returnValue['activate'] =  "no active";
					$returnValue['start_date'] =  "";
		    	$returnValue['end_date'] =   "";
		    }
		
		}
		return $returnValue;
	}
	
?>
