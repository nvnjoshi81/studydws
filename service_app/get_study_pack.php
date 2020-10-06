<?php
error_reporting(0);
	include('config.php');
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];
	$device_id = $_POST['device_id'];
	$qry;
	if($subject_id){
	    $sub = "and subject_id = '$subject_id'";
	    $qry = "SELECT F.displayname, F.filename, F.filepath, F.filename_one, F.filepath_one, F.type, F.filetype, F.pagecount, F.is_deleted, F.id as item_id, P.price, P.discounted_price, D.file_id, F.filename as question, A.name as modules_item_name, P.id as productlist_id FROM cmsfiles F JOIN cmsstudymaterial_details D ON D.file_id=F.id JOIN cmsstudymaterial A ON A.id=D.studymaterial_id JOIN cmsstudymaterial_relations ON A.id=cmsstudymaterial_relations.studymaterial_id LEFT JOIN cmspricelist P ON P.item_id=F.id WHERE cmsstudymaterial_relations.exam_id = '$category' AND cmsstudymaterial_relations.subject_id = '$subject_id' AND P.type = 1 ORDER BY F.id DESC LIMIT 20";
	}
	else {
	  $sub = "";  
	  $qry = "SELECT F.displayname, F.filename, F.filepath, F.filename_one, F.filepath_one, F.type, F.filetype, F.pagecount, F.is_deleted, F.id as item_id, P.price, P.discounted_price, D.file_id, F.filename as question, A.name as modules_item_name, P.id as productlist_id FROM cmsfiles F JOIN cmsstudymaterial_details D ON D.file_id=F.id JOIN cmsstudymaterial A ON A.id=D.studymaterial_id JOIN cmsstudymaterial_relations ON A.id=cmsstudymaterial_relations.studymaterial_id LEFT JOIN cmspricelist P ON P.item_id=F.id WHERE cmsstudymaterial_relations.exam_id = '$category' AND P.type = 1 ORDER BY F.id DESC LIMIT 20";
	}
	
		if($chapter_id){
	    $chh = "and chapter_id = '$chapter_id'";
	    $qry = "SELECT F.displayname, F.filename, F.filepath, F.filename_one, F.filepath_one, F.type, F.filetype, F.pagecount, F.is_deleted, F.id as item_id, P.price, P.discounted_price, D.file_id, F.filename as question, A.name as modules_item_name, P.id as productlist_id FROM cmsfiles F JOIN cmsstudymaterial_details D ON D.file_id=F.id JOIN cmsstudymaterial A ON A.id=D.studymaterial_id JOIN cmsstudymaterial_relations ON A.id=cmsstudymaterial_relations.studymaterial_id LEFT JOIN cmspricelist P ON P.item_id=F.id WHERE cmsstudymaterial_relations.exam_id = '$category' AND cmsstudymaterial_relations.subject_id = '$subject_id' AND cmsstudymaterial_relations.chapter_id = '$chapter_id' AND P.type = 1 ORDER BY F.id DESC LIMIT 900";
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
    //$qry = "SELECT * FROM cmspricelist where exam_id = '$category' and type = '1' $sub $chh ORDER BY discounted_price DESC";
	$result = mysqli_query($conn,$qry);
    }
    while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['item_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn,$user_id,$category);
		$subTmp[] = $job;
	}
    if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
	else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);

	function getmarvelcategory($mar_id,$conn,$user_id,$category) {		
		$returnValue = array();
		$category = $_POST['category_id'];
    	$subject_id = $_POST['subject_id'];
    	$chapter_id = $_POST['chapter_id'];
    	$result = mysqli_query($conn,"SELECT F.displayname, F.filename, F.filepath, F.filename_one, F.filepath_one, F.type, F.filetype, F.pagecount, F.is_deleted, F.id as item_id, P.price, P.discounted_price, D.file_id, F.filename as question, A.name as modules_item_name, P.id as productlist_id, PL.id as pricelist_id FROM cmsfiles F JOIN cmspricelist PL ON F.id = PL.item_id JOIN cmsstudymaterial_details D ON D.file_id=F.id JOIN cmsstudymaterial A ON A.id=D.studymaterial_id JOIN cmsstudymaterial_relations ON A.id=cmsstudymaterial_relations.studymaterial_id LEFT JOIN cmspricelist P ON P.item_id=F.id WHERE F.id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['title'] = $row['modules_item_name'];
		$returnValue['id'] = $row['pricelist_id'];
		$num = $pid =$row['item_id'];
		$returnValue['class_id'] = $category;
        $returnValue['subject_id'] = $subject_id;
        $returnValue['chapter_id'] = $chapter_id;
		$las = $num%10;
		$imm = "http://dev.hybridinfotech.com/assets/frontend/images/0";
	    $returnValue['image'] = "https://studyadda.com//upload/webreader/".$row['filename']."/docs/".$row['filename'].".pdf_1_thumb.jpg";
		$tim = time();
        $result1 = mysqli_query($conn,"SELECT * FROM cmsorders join cmsorder_details on cmsorders.id =  cmsorder_details.order_id join cmspricelist on cmspricelist.id=cmsorder_details.product_id  where  cmsorders.user_id = '$user_id' and cmsorders.status = '1' and cmspricelist.type='2' GROUP BY cmspricelist.modules_item_name ORDER BY cmsorders.id" );
        if($rowg = mysqli_fetch_array($result1)){ $ss = $rowg['product_id']; 
        $resultgd = "SELECT * FROM cmspricelist where id = '$ss' and type = '2' and exam_id='$category'";
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
		}
		return $returnValue;
	}
	
	mysqli_close($conn);
	
	
?>
