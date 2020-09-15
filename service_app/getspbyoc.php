<?php
error_reporting(0);
	include('config.php');
	//SELECT * FROM `cmsmergesection` WHERE `related_module_type` = 1 AND `module_id` = '582' AND `module_type` = 9
	$module_id = $_POST['module_id'];//"7"=Question Bank "6"=Sample Papers "10"=Solved Papers 9="Ncert Solution"
	$module_type = $_POST['module_type'];
	$exam_id=$_POST['exam_id'];
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
    $qry = "SELECT * FROM `cmsmergesection` WHERE `related_module_type` = 1 AND `module_id` = '$module_id' AND `module_type` = '$module_type'";
	
	$result = mysqli_query($conn,$qry);
    }

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['related_file_id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn,$exam_id,$user_id);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn,$exam_id,$user_id) {		
		$returnValue = array();
		//SELECT F.id, F.displayname, F.filename, F.filepath, F.filename_one, F.filepath_one, F.type, F.filetype, F.pagecount, F.is_deleted, P.price, P.discounted_price, D.file_id, F.filename as question, A.name FROM cmsfiles F JOIN cmsstudymaterial_details D ON D.file_id=F.id JOIN cmsstudymaterial A ON A.id=D.studymaterial_id LEFT JOIN cmspricelist P ON P.item_id=F.id WHERE F.id = '326'
		$result = mysqli_query($conn,"SELECT F.id, F.displayname, F.filename, F.filepath, F.filename_one, F.filepath_one, F.type, F.filetype, F.pagecount, F.is_deleted, P.price, P.discounted_price, D.file_id, F.filename as question, A.name FROM cmsfiles F JOIN cmsstudymaterial_details D ON D.file_id=F.id JOIN cmsstudymaterial A ON A.id=D.studymaterial_id LEFT JOIN cmspricelist P ON P.item_id=F.id WHERE F.id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		    $returnValue['name'] = $row['displayname'];
		    $result_pack = mysqli_query($conn,"SELECT C.id, C.exam_id, C.subject_id, C.chapter_id, C.item_id, C.type, C.price, C.discounted_price, C.description, C.offline_status, C.image, C.app_image, C.modules_item_id, C.modules_item_name, C.no_of_dvds, C.subscription_expiry, C.no_of_lectures, C.lecture_duration, C.no_of_subscribers, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmspricelist C LEFT JOIN categories ON C.exam_id=categories.id LEFT JOIN cmssubjects ON C.subject_id=cmssubjects.id LEFT JOIN cmschapters ON C.chapter_id=cmschapters.id WHERE type = '1' AND exam_id = '".$exam_id."' AND chapter_id = '0' AND subject_id = '0' AND item_id =0 GROUP BY C.id");
		    if(($rowval = mysqli_num_rows($result_pack)) >= 1)
		    {
		    if($row_pack = mysqli_fetch_array($result_pack)) 
		    {
		    $pr_id = $row_pack['id'];
		    //"SELECT A.product_id, B.type as product_type, B.exam_id, B.subject_id, B.chapter_id FROM cmsorder_details A JOIN cmsorders O ON O.id=A.order_id JOIN cmspricelist B ON A.product_id=B.id WHERE O.user_id = '$user_id' AND O.status = 1 and A.product_id='$pr_id'";
		    $result_pro = mysqli_query($conn,"SELECT A.product_id, B.type as product_type, B.exam_id, B.subject_id, B.chapter_id FROM cmsorder_details A JOIN cmsorders O ON O.id=A.order_id JOIN cmspricelist B ON A.product_id=B.id WHERE O.user_id = '$user_id' AND O.status = 1 and A.product_id='$pr_id'");
		    if(($rowpro = mysqli_num_rows($result_pro)) >= 1)
		    {
		    $returnValue['filename'] = $row['filepath_one'].$row['filename_one'];
		    $returnValue['row_pack'] = $rowpro;
		    $returnValue['product_id'] = $pr_id;
		    $result = mysqli_query($conn,"SELECT * FROM cmspricelist WHERE id = '$pr_id'");
    		while($rows = mysqli_fetch_array($result)) 
    		{
    		   $returnValue['app_image'] = "https://studyadda.com/assets/images/appimage/".$rows['app_image'];
    		   $returnValue['price'] = $rows['price'];
			   $returnValue['discounted_price'] = $rows['discounted_price'];
			   $returnValue['id'] =  $rows['id'];
    		}
		    
		    }
		    else
		    {
		        $returnValue['filename'] = "";
		        $returnValue['row_pack'] = 0;
		        $result = mysqli_query($conn,"SELECT * FROM cmspricelist WHERE id = '$pr_id'");
        		while($rows = mysqli_fetch_array($result)) 
        		{
        		   $returnValue['app_image'] = "https://studyadda.com/assets/images/appimage/".$rows['app_image'];
        		   $returnValue['price'] = $rows['price'];
    			    $returnValue['discounted_price'] = $rows['discounted_price'];
    			    $returnValue['id'] =  $rows['id'];
        		}
		        $returnValue['product_id'] = $pr_id;
		    }
		    //$returnValue['filename'] = $row['filepath_one'].$row['filename_one'];
		    //$returnValue['row_pack'] = $rowval;
		    }
		    }
		    else
		    {
		        $returnValue['filename'] = "";
		        $returnValue['price'] = $row['price'];
			    $returnValue['discounted_price'] = $row['discounted_price'];
			    $returnValue['id'] =  $row['id'];
		    }
			//$returnValue['price'] = $row['price'];
			//$returnValue['discounted_price'] = $row['discounted_price'];
			//$returnValue['id'] =  $row['id'];

		}
		return $returnValue;
	}
?>
