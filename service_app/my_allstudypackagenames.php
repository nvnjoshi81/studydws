<?php
	include('config.php');
	error_reporting(0);
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$class_id = $_POST['class_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];
	
//echo "select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'";
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

//echo "SELECT A.product_id, B.type as product_type, B.exam_id, B.subject_id, B.chapter_id, B.item_id FROM cmsorder_details A JOIN cmsorders O ON O.id=A.order_id JOIN cmspricelist B ON A.product_id=B.id WHERE O.user_id = '$user_id' AND O.status = 1 AND B.type = '1' AND B.item_id = '0'";
	$result = mysqli_query($conn,"SELECT A.product_id, B.type as product_type, B.exam_id, B.subject_id, B.chapter_id, B.item_id FROM cmsorder_details A JOIN cmsorders O ON O.id=A.order_id JOIN cmspricelist B ON A.product_id=B.id WHERE O.user_id = '$user_id' AND O.status = 1 AND B.type = '1' AND B.item_id = '0'" );


	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['product_id'];
		$job = array();
		$job = getmarvelcategoryn($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['datatwo'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['datatwo'] = "no data";}
	echo json_encode($tmp);

	function getmarvelcategoryn($mar_id,$conn) {
		$returnValue = array();

		$result = mysqli_query($conn,"SELECT * FROM cmspricelist WHERE id = '$mar_id'");
		if($rows = mysqli_fetch_array($result))
		{
			$returnValue['id'] = $rows['id'];
			$returnValue['class_id'] = $rows['exam_id'];
			$returnValue['subject_id'] = $rows['subject_id'];
			$returnValue['chapter_id'] = $rows['chapter_id'];
			$returnValue['modules_item_name'] = $rows['modules_item_name'];
			$n=$rows['product_expiry_date'];
			$m = date('Y-m-d',$n);
			$date = strtotime($n);
            $new_date = strtotime('+ 2 year',strtotime($n));
            //$mm = date('Y-m-d', $new_date);
            $date=date_create("2023-03-31");
            $mm = date_format($date,"Y-m-d");
			$returnValue['expires_on'] = $mm;
		}
		return $returnValue;
	}
    mysqli_close($conn);
?>
