<?php
	include('config.php');
	error_reporting(0);
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$class_id = $_POST['class_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];

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


	$result = mysqli_query($conn,"SELECT A.product_id, B.type as product_type, B.exam_id, B.subject_id, B.chapter_id, B.item_id FROM cmsorder_details A JOIN cmsorders O ON O.id=A.order_id JOIN cmspricelist B ON A.product_id=B.id WHERE O.user_id = '$user_id' AND O.status = 1 AND B.type = '1' AND B.item_id = '0'  AND B.exam_id > '0'" );


	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['exam_id'];
		$job = array();
		$job = getmarvelcategoryn($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['datatwo'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['datatwo'] = "no data";}
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategoryn($mar_id,$conn) {
		$qry = "SELECT id, subject_id FROM cmschapter_details WHERE class_id = '$mar_id' GROUP BY subject_id";
		$result = mysqli_query($conn,$qry);
		
		while($row = mysqli_fetch_array($result)) 
		{
		//$returnValue['id'] = $rows['id'];
		$mar_id1 = $row['id'];
		$job1 = array();
		$job1 = getmarvelcategoryn1($mar_id1,$conn);
		$subTmp1[] = $job1;
	    }
		return $subTmp1;
	}
	function getmarvelcategoryn1($mar_id1,$conn) {
		$qry = "SELECT * FROM cmschapter_details where id = '$mar_id1'";
		$result = mysqli_query($conn,$qry);
		$returnValue = array();
		if($rows = mysqli_fetch_array($result))
		{
		$returnValue['subject_id'] = $mar_id1;
		}
		
		return $returnValue;
	}

?>
