<?php
	include('config.php');
		
	if(isset($_POST['user_key'])&&$_POST['user_key']!=''){
	$user_key = $_POST['user_key'];	
	}else{
	$user_key = 0;
	}
		
	if(isset($_POST['user_id'])&&$_POST['user_id']!=''){
	$user_id = $_POST['user_id'];	
	}else{
	$user_id = 0;
	}
	
	if(isset($_POST['category_id'])&&$_POST['category_id']!=''){
	$category_id = $_POST['category_id'];	
	}else{
	$category_id = 0;
	}
	
	if(isset($_POST['device_id'])&&$_POST['device_id']!=''){
	$device_id = $_POST['device_id'];	
	}else{
	$device_id = 0;
	}
	$sub_status=0;
		if(isset($user_id)&&$user_id>0){
		    $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'";
    $oppf = mysqli_query($conn, $self);
    $rww = mysqli_num_rows($oppf);
	}else{
	$tmp['status'] = "false";$tmp['data'] = "";$tmp['msg'] = "Please Enter all parameters.";
	$rww=0;
		echo json_encode($tmp);  die();
	}
	
    if($rww > 0){
    	while($ryu = mysqli_fetch_array($oppf)){
    	$get_api = $ryu['user_key'];
    	}
    }
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
    if($get_api){
	//$result = mysqli_query($conn,"SELECT * FROM cmschapter_details where class_id = '$category_id' GROUP BY subject_id ");
	//$result = mysqli_query($conn,"SELECT * FROM cmsstudymaterial_relations where exam_id = '$category_id' GROUP BY subject_id ");
	
	$result = mysqli_query($conn,"SELECT `cmschapters`.`id` as `cid`, `cmschapters`.`name` as `cname`, `cmssubjects`.`id` as `subject_id`, `cmssubjects`.`name` as `sname`, `cmssubjects`.`imagename` FROM `cmschapter_details` `cd` JOIN `cmschapters` ON `cd`.`chapter_id` = `cmschapters`.`id` JOIN `cmssubjects` ON `cd`.`subject_id` = `cmssubjects`.`id` WHERE `cd`.`class_id` = '$category_id' group by `cmssubjects`.`name`");
	
	
	while($row = mysqli_fetch_array($result)) {
	$mar_id = $row['subject_id'];
	$self = "SELECT * FROM cmsstudymaterial_relations WHERE exam_id = '$category_id' and subject_id = '$mar_id'";
    $oppf = mysqli_query($conn, $self);
    if($rww = mysqli_num_rows($oppf) >= 1)
    {
        $sub_status=1;
    }
    $self = "SELECT * FROM cmsbooks_relations WHERE exam_id = '$category_id' and subject_id = '$mar_id'";
    $oppf = mysqli_query($conn, $self);
    if($rww = mysqli_num_rows($oppf) >= 1)
    {
        $sub_status=1;
    }
    $self = "SELECT * FROM cmsquestionbank_relations WHERE exam_id = '$category_id' and subject_id = '$mar_id'";
    $oppf = mysqli_query($conn, $self);
    if($rww = mysqli_num_rows($oppf) >= 1)
    {
        $sub_status=1;
    }
    $self = "SELECT * FROM cmssamplepapers_relations WHERE exam_id = '$category_id' and subject_id = '$mar_id'";
    $oppf = mysqli_query($conn, $self);
    if($rww = mysqli_num_rows($oppf) >= 1)
    {
        $sub_status=1;
    }
    $self = "SELECT * FROM cmssolvedpapers_relations WHERE exam_id = '$category_id' and subject_id = '$mar_id'";
    $oppf = mysqli_query($conn, $self);
    if($rww = mysqli_num_rows($oppf) >= 1)
    {
        $sub_status=1;
    }
    $self = "SELECT * FROM cmsvideolist_relations WHERE exam_id = '$category_id' and subject_id = '$mar_id'";
    $oppf = mysqli_query($conn, $self);
    if($rww = mysqli_num_rows($oppf) >= 1)
    {
        $sub_status=1;
    }
    $self = "SELECT * FROM cmsncertsolutions_relations WHERE exam_id = '$category_id' and subject_id = '$mar_id'";
    $oppf = mysqli_query($conn, $self);
    if($rww = mysqli_num_rows($oppf) >= 1)
    {
        $sub_status=1;
    }
    $self = "SELECT * FROM cmsonlinetest_relations WHERE exam_id = '$category_id' and subject_id = '$mar_id'";
    $oppf = mysqli_query($conn, $self);
    if($rww = mysqli_num_rows($oppf) >= 1)
    {
        $sub_status=1;
    }
    $self = "SELECT * FROM cmsnotes_relations WHERE exam_id = '$category_id' and subject_id = '$mar_id'";
    $oppf = mysqli_query($conn, $self);
    if($rww = mysqli_num_rows($oppf) >= 1)
    {
        $sub_status=1;
    }
    if($sub_status=1)
    {
	$self = "SELECT * FROM cmspackages_counter WHERE `exam_id` = '$category_id' AND subject_id = '$mar_id' AND total_package > '0'";
    $oppf = mysqli_query($conn, $self);
    $rww = mysqli_num_rows($oppf);
    if($rww > 0){
	$job = array();
	$job = getmarvelcategory($mar_id,$category_id,$conn);
	$subTmp[] = $job;
    }
    }
	}
    if($subTmp){
        $tmp['status'] = "success";$tmp['data'] = $subTmp;$tmp['msg'] = "success"; 
        
    }
	else 
	{ 
     $tmp['status'] = "true";$tmp['data'] = "No Subjects available in this class.";$tmp['msg'] = "true";
    }
    }
    else
    {
        $tmp['status'] = "false";$tmp['data'] = "";$tmp['msg'] = "You have logged in to a different device! Hence you are logged out of this device.";
    }
	echo json_encode($tmp);
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$category_id,$conn) {		
		$returnValue = array();
		$result = mysqli_query($conn,"SELECT * FROM cmssubjects WHERE id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		$returnValue['subject_name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
			$returnValue['subject_id'] = $row['id'];
		$returnValue['order'] = $row['order'];
			$returnValue['description'] = $row['description'];
			$returnValue['keywords'] = $row['keywords'];
			$returnValue['tagline'] = $row['tagline'];
			$returnValue['image'] = "https://studyadda.com/".$row['imagename'];
		}
        
		return $returnValue;
	}
	
?>
