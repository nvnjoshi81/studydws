<?php 
error_reporting(0);
	include ('config.php');
	 	 $name = $_POST['name'];
	 	 $category = $_POST['category'];
	 	 $user_id = $_POST['user_id'];
	 	 $class_id = $_POST['class_id'];
	
	$tmp = array();
		$subTmp = array();
		$postStatusString = "publish";
		
		if($category=="cmspricelist")
		{
		    $fin = "";
		    $names = "modules_item_name";
		} else { $fin = "GROUP BY name" ; 
		    
		   $names= "name" ; 
		  
		}
		if($category=="cmsncertsolutions"){ $did = "ncertsolutions_id";}
		if($category=="cmsonlinetest"){ $did = "onlinetest_id";}
		if($category=="cmssamplepapers"){ $did = "samplepaper_id";}
		if($category=="cmssolvedpapers"){ $did = "solvedpapers_id";}
		if($category=="cmsstudymaterial"){ $did = "studymaterial_id";}
		if($category=="cmsonlinetest"){ $did = "onlinetest_id";}
		
		$catrel = $category."_relations";

if($category=='cmsvideoslist'){
    $did = 'id';
     $sel = "SELECT * FROM $category  where exam_id = '$class_id'";
}
elseif($category=='cmsnotes')
{
    $categorys = "postings"; $sec = "cmsnotes_relations";
    echo $sel = "SELECT * FROM $categorys join $sec on $categorys.id = $sec.id where $sec.exam_id = '$class_id'";
}
else {
   $sel = "SELECT * FROM $category join $catrel on $category.id = $catrel.id where $catrel.exam_id = '$class_id'";
}
$result = mysqli_query($conn, $sel);

while($row = mysqli_fetch_array($result)) {
			 $mar_id = $row[$did];
			$job = array();
			$job = getcoursebycat($mar_id,$category,$conn,$user_id);
			$subTmp[] = $job;
		}

		$tmp['status'] = "success";
		if($subTmp){
	$tmp['data'] = $subTmp;
		}
		else {
			$tmp['data'] = "no data";
		
			}
		echo json_encode($tmp,$tmpt);
	
		
		function getcoursebycat($mar_id,$category,$conn,$user_id) {		
			$returnValue = array();
			
		  "SELECT * FROM $category WHERE id = '$mar_id'";

$result = mysqli_query($conn, "SELECT * FROM $category WHERE id = '$mar_id'");


			while($row = mysqli_fetch_array($result)) 
			{
			    $returnValue['id'] = $pid = $row['id'];
			    	if($category=="cmspricelist"){
			    	     $returnValue['result_name'] =  $row['modules_item_name'];
			    $tim = time();	     
			    	     	 $resultg = "SELECT * FROM cmscart join cmscart_items on cmscart.id=cmscart_items.cart_id where cmscart.user_id = '$user_id' and cmscart_items.product_id = '$pid' and cmscart_items.end_date > '$tim'";
		$myss = mysqli_query($conn, $resultg);
		$coo = mysqli_num_rows($myss);
		if($coo){
		    
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
			    	else {
			     $returnValue['result_name'] =  $row['name'];
			     
			     	$returnValue['activate'] =  "";
					$returnValue['start_date'] =  "";
		    	$returnValue['end_date'] =   "";
			     
			     
			    	}
				
				

			}
		    
		    
	        	return $returnValue;
		}
		
	
 ?>
 
