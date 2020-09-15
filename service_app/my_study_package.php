<?php
error_reporting(0);
	include('config.php');
	

	
		$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
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

if($get_api){
    
    	$resultp = mysqli_query($conn,"SELECT * FROM cmsorders where user_id = '$user_id'");
		if($rowp = mysqli_fetch_array($resultp)) 
		{ $order =  $rowp['id'];	}
	$result = mysqli_query($conn,"SELECT * FROM cmsorder_details where order_id = '$order' and type = '1'");
}
	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		$tim = time();
		
	/*	echo "SELECT * FROM cmsorder_details join cmscart_items on cmsorder_details.product_id=cmscart_items.product_id where cmsorder_details.id = '$mar_id'	and cmscart_items.end_date > '$tim'" ;
				$result = mysqli_query($conn,"SELECT * FROM cmsorder_details join cmscart_items on cmsorder_details.product_id=cmscart_items.product_id where cmsorder_details.id = '$mar_id'
				and cmscart_items.end_date > '$tim'");
		*/
		$result = mysqli_query($conn,"SELECT * FROM cmsorder_details join cmscart_items on cmsorder_details.product_id=cmscart_items.product_id where cmsorder_details.id = '$mar_id' and cmsorder_details.type = '1'  and cmscart_items.end_date > '$tim'");
		if($row = mysqli_fetch_array($result)) 
		{

	
			$returnValue['product_id'] = $row['product_id'];
			$returnValue['dt_created'] = $row['dt_created'];
			$returnValue['end_date'] = $row['end_date'];
			$returnValue['price'] = $row['price'];
				$returnValue['product_id'] = $prr =$row['product_id'];
			$returnValue['id'] = $num = $row['id'];
			

			
				$resultpd = mysqli_query($conn,"SELECT * FROM cmspricelist where id = '$prr'");
		if($rowpd = mysqli_fetch_array($resultpd)) 
		{ 
		   	$returnValue['product_name'] =  $rowpd['modules_item_name'];
		   	$returnValue['item_id'] = $itid = $rowpd['item_id'];
		   		$returnValue['category_id'] = $itid = $rowpd['exam_id'];
		   		$returnValue['subject_id'] = $itid = $rowpd['subject_id'];
		   		$returnValue['chapter_id'] = $itid = $rowpd['chapter_id'];
		    
		}
		
			$resultpdd = mysqli_query($conn,"SELECT * FROM cmsfiles where id = '$itid'");
		if($rowpdd = mysqli_fetch_array($resultpdd)) 
		{ 
		   	$returnValue['filename_one'] =  $rowpdd['filename_one'];
		   	$returnValue['filename'] = $itid = $rowpdd['filename'];
		   	
		   		$cr = "http://dev.hybridinfotech.com/upload/pdfs/";
			
				$returnValue['view_file'] = $cr.$rowpdd['filename_one'];
				
				
		    
		}
		
		
		
		

		}
		return $returnValue;
	}
	
?>
