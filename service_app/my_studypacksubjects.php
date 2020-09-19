<?php
	include('config.php');
	error_reporting(0);
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


$va =array();
    $tmp=array();
    //echo "SELECT cmssubjects.id as subject_id, cmssubjects.name as subject_name FROM cmschapter_details INNER JOIN cmssubjects ON cmssubjects.id = cmschapter_details.subject_id WHERE cmschapter_details.class_id = '$class_id' GROUP BY cmschapter_details.subject_id";
   $result = mysqli_query($conn,"SELECT cmssubjects.id as subject_id, cmssubjects.name as subject_name,cmschapter_details.class_id as class_id FROM cmschapter_details INNER JOIN cmssubjects ON cmssubjects.id = cmschapter_details.subject_id WHERE cmschapter_details.class_id = '$class_id' GROUP BY cmschapter_details.subject_id" );

   while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['subject_id'];
		 $ch = $row['class_id'];
		$self = "SELECT * FROM cmspackages_counter WHERE `exam_id` = '$class_id' AND subject_id = '$mar_id' AND total_package > '0'";
        $oppf = mysqli_query($conn, $self);
        $rww = mysqli_num_rows($oppf);
        if($rww > 0){
	   $data = get_date($mar_id,$class_id,$subject_id,$conn,$ch);
	
	if($data){
	    $va[]=$data;
    	}
    }
   }
   if(count($va)>0){
       $tmp['status'] = "success";$tmp['datatwo'] = $va; }
		
   else {$tmp['status'] = "false";$tmp['datatwo'] = "no data";}
 //	echo "<pre>";
	//	print_r($tmp);
	//	echo "<pre>";
  echo json_encode($tmp);
  
  function get_date($mar_id,$class_id,$subject_id,$conn,$ch){
        
         $returnValue=array();
         $arr = array();
        // echo "SELECT * FROM cmschapters WHERE id = '$mar_id'";
        $result = mysqli_query($conn,"SELECT * FROM cmssubjects WHERE id = '$mar_id'");
		if($rows = mysqli_fetch_array($result))
		  {
		  
		    $na = $rows['id'];
			//if($na !== '1' && $na !== '9'){ 
		    $class_id = $_POST['class_id'];
	        $returnValue['class_id'] = $class_id;
			$returnValue['subject_id'] = $rows['id'];
			$returnValue['subject_name'] = $rows['name'];
		    $arr=$returnValue;
			//}
		}
				return $ress=(count($arr))? $arr : false;
		}
			
		
?>
