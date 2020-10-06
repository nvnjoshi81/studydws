<?php
	include('config.php');
		$user_key = $_REQUEST['user_key'];
	$user_id = $_REQUEST['user_id'];
	$id = $_REQUEST['id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	  while($ryu = mysqli_fetch_array($oppf)){
	$get_api = $ryu['user_key'];
	  }
  }
	$id = $_GET['id'];
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
	if($get_api){
	$result = mysqli_query($conn,"SELECT * FROM cmscustomers where id = '$id'");
	}
	while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);

	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		//echo "SELECT * FROM categories WHERE id = '$mar_id'";
		$result = mysqli_query($conn,"SELECT * FROM cmscustomers WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['first_name'] = $row['firstname'];
		$returnValue['last_name'] = $row['lastname'];
		$returnValue['email'] = $row['email'];
		$returnValue['mobile'] = $row['mobile'];
		
		$prefiximg = "http://dev.hybridinfotech.com/upload/user/";
			$returnValue['image'] = $prefiximg.$row['image'];
			
		
		
			$returnValue['id'] = $row['id'];
	  $returnValue['city_name'] = $row['city_id'];
	    
	

		}
		return $returnValue;
	}
	mysqli_close($conn);
?>
