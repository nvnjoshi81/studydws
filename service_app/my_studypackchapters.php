<?php
	include('config.php');
	error_reporting(0);
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$class_id = $_POST['class_id'];
	$subject_id = $_POST['subject_id'];
  
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
   // echo "SELECT cmschapters.id as id, cmschapters.name as cname, cmssubjects.id as sid, cmssubjects.name as sname FROM cmschapter_details cd JOIN cmschapters ON cd.chapter_id = cmschapters.id JOIN cmssubjects ON cd.subject_id = cmssubjects.id WHERE cd.class_id = '$category_id' AND cd.subject_id = '$subject_id' ORDER BY cd.sortorder ASC, cd.id ASC";
    $result = mysqli_query($conn,"SELECT cmschapters.id as chapter_id, cmschapters.name as cname, cmssubjects.id as sid, cmssubjects.name as sname FROM cmschapter_details cd JOIN cmschapters ON cd.chapter_id = cmschapters.id JOIN cmssubjects ON cd.subject_id = cmssubjects.id WHERE cd.class_id = '$class_id' AND cd.subject_id = '$subject_id' ORDER BY cd.sortorder ASC, cd.id ASC" );
    while($row = mysqli_fetch_array($result)) {
		$mar_id = $row['chapter_id'];
	   $data = get_date($mar_id,$class_id,$subject_id,$conn);
	
	if($data){
	    $va[]=$data;
    	}
    }
   
   if(count($va)>0){
       $tmp['status'] = "success";$tmp['datatwo'] = $va; }
		
   else {$tmp['status'] = "false";$tmp['datatwo'] = "no data";}
 //	echo "<pre>";
	//	print_r($tmp);
	//	echo "<pre>";
  echo json_encode($tmp);
  
  function get_date($mar_id,$class_id,$subject_id,$conn){
        
         $returnValue=array();
         $arr = array();
         //echo "SELECT * FROM cmschapters WHERE id = '$mar_id'";
        $result = mysqli_query($conn,"SELECT * FROM cmschapters WHERE id = '$mar_id'");
		if($rows = mysqli_fetch_array($result))
		{
		    
		    $qry = mysqli_query($conn,"SELECT F.displayname, F.filename, F.filepath, F.filename_one, F.filepath_one, F.type, F.filetype, F.pagecount, F.is_deleted, F.id as item_id, P.price, P.discounted_price, D.file_id, F.filename as question, A.name as modules_item_name, P.id as productlist_id FROM cmsfiles F JOIN cmsstudymaterial_details D ON D.file_id=F.id JOIN cmsstudymaterial A ON A.id=D.studymaterial_id JOIN cmsstudymaterial_relations ON A.id=cmsstudymaterial_relations.studymaterial_id LEFT JOIN cmspricelist P ON P.item_id=F.id WHERE cmsstudymaterial_relations.exam_id = '$class_id' AND cmsstudymaterial_relations.subject_id = '$subject_id' AND cmsstudymaterial_relations.chapter_id = '$mar_id' AND P.type = 1 ORDER BY F.id DESC LIMIT 900");
		     while($row = mysqli_fetch_array($qry)) { $mar = $row['item_id'];}
		    
		    $resultt2 = mysqli_query($conn,"SELECT F.displayname, F.filename, F.filepath, F.filename_one, F.filepath_one, F.type, F.filetype, F.pagecount, F.is_deleted, F.id as item_id, P.price, P.discounted_price, D.file_id, F.filename as question, A.name as modules_item_name, P.id as productlist_id FROM cmsfiles F JOIN cmsstudymaterial_details D ON D.file_id=F.id JOIN cmsstudymaterial A ON A.id=D.studymaterial_id JOIN cmsstudymaterial_relations ON A.id=cmsstudymaterial_relations.studymaterial_id LEFT JOIN cmspricelist P ON P.item_id=F.id WHERE F.id = '$mar'");
			$nn = mysqli_num_rows($resultt2);
		   //echo $nn;
			if($nn>0){ 
			$class_id = $_POST['class_id'];
	        $subject_id = $_POST['subject_id'];
			$returnValue['class_id'] = $class_id;
			$returnValue['subject_id'] = $subject_id;
			$returnValue['chapter_id'] = $rows['id'];
			$str = $rows['name'];
		    /*$str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);*/
            //$returnValue['question'] = $str;
            $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['chapter_name'] = $str;
		    $arr=$returnValue;
			}
		}
				return $ress=(count($arr))? $arr : false;
		}
			
		
	mysqli_close($conn);


?>
