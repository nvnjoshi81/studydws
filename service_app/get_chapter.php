<?php
error_reporting(0);
	include('config.php');
	
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
    $va =array();
    $tmp=array();
$result = mysqli_query($conn,"SELECT cmschapters.id as chapter_id, cmschapters.name as cname, cmssubjects.id as sid, cmssubjects.name as sname FROM cmschapter_details cd JOIN cmschapters ON cd.chapter_id = cmschapters.id JOIN cmssubjects ON cd.subject_id = cmssubjects.id WHERE cd.class_id = '$category' AND cd.subject_id='$subject_id' ORDER BY cd.sortorder ASC, cd.id ASC");
while($row = mysqli_fetch_array($result)) {
	 $mar_id = $row['chapter_id'];
	$data = get_date($conn,$mar_id,$category,$subject_id);
	
	if($data){
	    $va[]=$data;
	}
   }
   
   if(count($va)>0){
       $tmp['status'] = "success";$tmp['data'] = $va; }
		
   else {$tmp['status'] = "false";$tmp['data'] = "no data";}
 //	echo "<pre>";
	//	print_r($tmp);
	//	echo "<pre>";
  echo json_encode($tmp);
  
  function get_date($conn,$mar_id,$category,$subject_id){
        
         $returnValue=array();
         $arr = array();
        // echo "SELECT * FROM cmschapters where id = '$mar_id'";
        $result = mysqli_query($conn,"SELECT * FROM cmschapters where id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		  //  echo "SELECT * FROM cmspricelist where exam_id = '$category' and type = '2' and subject_id ='$subject_id' and chapter_id = '$mar_id' ORDER BY discounted_price DESC";
		  $qry = "SELECT * FROM cmspricelist where exam_id = '$category' and type = '2' and subject_id ='$subject_id' ORDER BY discounted_price DESC";
	      $result1 = mysqli_query($conn,$qry);
	      while($rows = mysqli_fetch_array($result1)) { $nw = $rows['id'];}
	      $qry1 = mysqli_query($conn,"SELECT * FROM cmspricelist where id = '$nw'");
	      $nn = mysqli_num_rows($qry1);//1 api
	      
	      $qrym = "SELECT F.displayname, F.filename, F.filepath, F.filename_one, F.filepath_one, F.type, F.filetype, F.pagecount, F.is_deleted, F.id as item_id, P.price, P.discounted_price, D.file_id, F.filename as question, A.name as modules_item_name, P.id as productlist_id FROM cmsfiles F JOIN cmsstudymaterial_details D ON D.file_id=F.id JOIN cmsstudymaterial A ON A.id=D.studymaterial_id JOIN cmsstudymaterial_relations ON A.id=cmsstudymaterial_relations.studymaterial_id LEFT JOIN cmspricelist P ON P.item_id=F.id WHERE cmsstudymaterial_relations.exam_id = '$category' AND cmsstudymaterial_relations.subject_id = '$subject_id' AND P.type = 1 ORDER BY F.id DESC LIMIT 20";
	      $result2 = mysqli_query($conn,$qrym);
	      while($rows2 = mysqli_fetch_array($result2)) {  $tham = $rows2['item_id'];}
	     
	      $qry2 = mysqli_query($conn,"SELECT F.displayname, F.filename, F.filepath, F.filename_one, F.filepath_one, F.type, F.filetype, F.pagecount, F.is_deleted, F.id as item_id, P.price, P.discounted_price, D.file_id, F.filename as question, A.name as modules_item_name, P.id as productlist_id, PL.id as pricelist_id FROM cmsfiles F JOIN cmspricelist PL ON F.id = PL.item_id JOIN cmsstudymaterial_details D ON D.file_id=F.id JOIN cmsstudymaterial A ON A.id=D.studymaterial_id JOIN cmsstudymaterial_relations ON A.id=cmsstudymaterial_relations.studymaterial_id LEFT JOIN cmspricelist P ON P.item_id=F.id WHERE F.id = '$tham'");
	      $nn1 = mysqli_num_rows($qry2);//2 api
	       if($subject_id == "0" and $mar_id == "0")
        	{
        	    $qry3 = "SELECT cmssamplepapers.id FROM cmssamplepapers_relations LEFT JOIN categories ON cmssamplepapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssamplepapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssamplepapers_relations.chapter_id=cmschapters.id JOIN cmssamplepapers ON cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id WHERE cmssamplepapers_relations.exam_id = '$category' ORDER BY cmssamplepapers.id DESC";
        	}
        	else if($subject_id > "0" and $mar_id == "0")
        	{
        	    $qry3 = "SELECT cmssamplepapers.id FROM cmssamplepapers_relations LEFT JOIN categories ON cmssamplepapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssamplepapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssamplepapers_relations.chapter_id=cmschapters.id JOIN cmssamplepapers ON cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id WHERE cmssamplepapers_relations.exam_id = '$category' AND cmssamplepapers_relations.subject_id = '$subject_id' ORDER BY cmssamplepapers.id DESC";
        	}
        	else if($subject_id > "0" and $mar_id > "0")
        	{
        	    $qry3 = "SELECT cmssamplepapers.id FROM cmssamplepapers_relations LEFT JOIN categories ON cmssamplepapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssamplepapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssamplepapers_relations.chapter_id=cmschapters.id JOIN cmssamplepapers ON cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id WHERE cmssamplepapers_relations.exam_id = '$category' AND cmssamplepapers_relations.subject_id = '$subject_id' AND cmssamplepapers_relations.chapter_id = '$chapter_id' ORDER BY cmssamplepapers.id DESC";
        	}
        	$result3 = mysqli_query($conn,$qry3);
            
            while($row3 = mysqli_fetch_array($result3)) {
		    $mar_id3 = $row3['id'];}
		   	$result4 = mysqli_query($conn,"SELECT * FROM cmssamplepapers where id = '$mar_id3' and is_deleted = '1'");
	        $nn2 = mysqli_num_rows($result4);//3 api
	         if($subject_id == "0" and $mar_id == "0")
        	{
        	    $qry4 = "SELECT cmsquestionbank.id as questionbank_id, cmsquestionbank.name, cmsquestionbank_relations.exam_id, cmsquestionbank_relations.subject_id, cmsquestionbank_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsquestionbank_relations LEFT JOIN categories ON cmsquestionbank_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsquestionbank_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsquestionbank_relations.chapter_id=cmschapters.id JOIN cmsquestionbank ON cmsquestionbank.id=cmsquestionbank_relations.questionbank_id WHERE cmsquestionbank_relations.exam_id = '$category' ORDER BY `cmsquestionbank`.`id` DESC LIMIT 20";
        	}
        	else if($subject_id > "0" and $mar_id == "0")
        	{
        	    $qry4 = "SELECT * FROM cmsquestionbank_relations where exam_id = '$category' and subject_id='$subject_id' limit 20";
        	}
        	else if($subject_id > "0" and $mar_id > "0")
        	{
        	     $qry4 = "SELECT * FROM cmsquestionbank_relations where exam_id = '$category' and subject_id='$subject_id' and chapter_id = '$chapter_id' limit 20";
        	}
        	$result4 = mysqli_query($conn,$qry4);
	       	while($row4 = mysqli_fetch_array($result4)) { $mar_id4 = $row4['questionbank_id']; }
	        $result5 = mysqli_query($conn,"SELECT cmsquestionbank.id, cmsquestionbank.created_by, cmsquestionbank.dt_created, cmsquestionbank.modified_by, cmsquestionbank.view_count, cmsquestionbank.name, cmsquestionbank_relations.exam_id, cmsquestionbank_relations.subject_id, cmsquestionbank_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsquestionbank_relations LEFT JOIN categories ON cmsquestionbank_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsquestionbank_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsquestionbank_relations.chapter_id=cmschapters.id JOIN cmsquestionbank ON cmsquestionbank.id=cmsquestionbank_relations.questionbank_id WHERE cmsquestionbank.id = '$mar_id4'");
	        $nn3 = mysqli_num_rows($result5);//4 api
	        
	         if($subject_id == "0" and $mar_id == "0")
        	{
        	    $qry5 = "SELECT postings.id as id, postings.title as title, postings.category_id, postings.subject_id, postings.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM postings LEFT JOIN categories ON categories.id=postings.category_id LEFT JOIN cmssubjects ON cmssubjects.id=postings.subject_id LEFT JOIN cmschapters ON cmschapters.id=postings.chapter_id WHERE category_id = '$category' AND top_category_id = '21' ORDER BY postings.id DESC LIMIT 100";
        	}
        	else if($subject_id > "0" and $mar_id == "0")
        	{
        	    $qry5 = "SELECT postings.id as id, postings.title as title, postings.category_id, postings.subject_id, postings.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM postings LEFT JOIN categories ON categories.id=postings.category_id LEFT JOIN cmssubjects ON cmssubjects.id=postings.subject_id LEFT JOIN cmschapters ON cmschapters.id=postings.chapter_id WHERE category_id = '$category' AND subject_id = '$subject_id' AND top_category_id = '21' ORDER BY postings.id DESC LIMIT 100";
        	}
        	else if($subject_id > "0" and $mar_id > "0")
        	{
        	    $qry5 = "SELECT postings.id as id, postings.title as title, postings.category_id, postings.subject_id, postings.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM postings LEFT JOIN categories ON categories.id=postings.category_id LEFT JOIN cmssubjects ON cmssubjects.id=postings.subject_id LEFT JOIN cmschapters ON cmschapters.id=postings.chapter_id WHERE category_id = '$category' AND subject_id = '$subject_id' AND chapter_id = '$chapter_id' AND top_category_id = '21' ORDER BY postings.id DESC LIMIT 100";
        	}
        	$result6 = mysqli_query($conn,$qry5);
        	while($row6 = mysqli_fetch_array($result6)) {$mar_id6 = $row6['questionbank_id'];}
	        $result7 = mysqli_query($conn,"SELECT * FROM postings where id = '$mar_id6' and is_deleted = '1'");
	        $nn4 = mysqli_num_rows($result7);//5 api
	        if($subject_id == "0" and $mar_id == "0")
        	{
        	    $qry6 = "SELECT cmssolvedpapers.id FROM cmssolvedpapers_relations LEFT JOIN categories ON cmssolvedpapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssolvedpapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssolvedpapers_relations.chapter_id=cmschapters.id JOIN cmssolvedpapers ON cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id WHERE cmssolvedpapers_relations.exam_id = '$category' GROUP BY cmssolvedpapers_relations.solvedpapers_id ORDER BY cmssolvedpapers.years DESC";
        	}
        	else if($subject_id > "0" and $mar_id == "0")
        	{
        	    $qry6 = "SELECT cmssolvedpapers.id FROM cmssolvedpapers_relations LEFT JOIN categories ON cmssolvedpapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssolvedpapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssolvedpapers_relations.chapter_id=cmschapters.id JOIN cmssolvedpapers ON cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id WHERE cmssolvedpapers_relations.exam_id = '$category' AND cmssolvedpapers_relations.subject_id = '$subject_id' GROUP BY cmssolvedpapers_relations.solvedpapers_id ORDER BY cmssolvedpapers.years DESC";
        	}
        	else if($subject_id > "0" and $mar_id > "0")
        	{          
        	    $qry6 = "SELECT cmssolvedpapers.id FROM cmssolvedpapers_relations LEFT JOIN categories ON cmssolvedpapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssolvedpapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssolvedpapers_relations.chapter_id=cmschapters.id JOIN cmssolvedpapers ON cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id WHERE cmssolvedpapers_relations.exam_id = '$category' AND cmssolvedpapers_relations.subject_id = '$subject_id' AND cmssolvedpapers_relations.chapter_id = '$chapter_id' GROUP BY cmssolvedpapers_relations.solvedpapers_id ORDER BY cmssolvedpapers.years DESC";
        	}
            $result8 = mysqli_query($conn,$qry6);
           	while($row7 = mysqli_fetch_array($result)) {$mar_id7 = $row7['id'];}
           	$result9 = mysqli_query($conn,"SELECT * FROM cmssolvedpapers where id = '$mar_id7' and is_deleted = '1'");
	        $nn5 = mysqli_num_rows($result9);//6 api
	        if($subject_id == "0" and $mar_id == "0")
        	{
        	    $qry7 = "SELECT cmsncertsolutions.name, cmsncertsolutions.id, cmsncertsolutions_relations.exam_id, cmsncertsolutions_relations.subject_id, cmsncertsolutions_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsncertsolutions_relations LEFT JOIN categories ON cmsncertsolutions_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsncertsolutions_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsncertsolutions_relations.chapter_id=cmschapters.id JOIN cmsncertsolutions ON cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id WHERE cmsncertsolutions_relations.exam_id = '$category' ORDER BY cmsncertsolutions.id DESC";
        	}
        	else if($subject_id > "0" and $mar_id == "0")
        	{
        	    $qry7 = "SELECT cmsncertsolutions.name, cmsncertsolutions.id, cmsncertsolutions_relations.exam_id, cmsncertsolutions_relations.subject_id, cmsncertsolutions_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsncertsolutions_relations LEFT JOIN categories ON cmsncertsolutions_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsncertsolutions_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsncertsolutions_relations.chapter_id=cmschapters.id JOIN cmsncertsolutions ON cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id WHERE cmsncertsolutions_relations.exam_id = '$category' AND cmsncertsolutions_relations.subject_id = '$subject_id' ORDER BY cmsncertsolutions.id DESC";
        	}
        	else if($subject_id > "0" and $mar_id > "0")
        	{
        	    $qry7 = "SELECT cmsncertsolutions.name, cmsncertsolutions.id, cmsncertsolutions_relations.exam_id, cmsncertsolutions_relations.subject_id, cmsncertsolutions_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsncertsolutions_relations LEFT JOIN categories ON cmsncertsolutions_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsncertsolutions_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsncertsolutions_relations.chapter_id=cmschapters.id JOIN cmsncertsolutions ON cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id WHERE cmsncertsolutions_relations.exam_id = '$category' AND cmsncertsolutions_relations.subject_id = '$subject_id' AND cmsncertsolutions_relations.chapter_id = '$chapter_id' ORDER BY cmsncertsolutions.id DESC";
        	}
        	$result10 = mysqli_query($conn,$qry7);
        	while($row8 = mysqli_fetch_array($result10)) {$mar_id8 = $row8['id'];}
        	$result11 = mysqli_query($conn,"SELECT * FROM cmsncertsolutions where id = '$mar_id' and is_deleted = '1'");
        	$nn6 = mysqli_num_rows($result11);//7 api
        	if($subject_id)
            {
              $qry8 = "SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest_relations.exam_id, cmsonlinetest_relations.subject_id, cmsonlinetest_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest_relations.exam_id = '$category' AND cmsonlinetest_relations.subject_id = '$subject_id' ORDER BY cmsonlinetest.id DESC";
            }
           	$result12 = mysqli_query($conn,$qry8);
        	while($row9 = mysqli_fetch_array($result12)) {$mar_id9 = $row9['id'];}	
        	$qry21 = "SELECT cmsonlinetest.name, cmsonlinetest.id, cmsonlinetest_relations.exam_id, cmsonlinetest_relations.subject_id, cmsonlinetest_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsonlinetest_relations LEFT JOIN categories ON cmsonlinetest_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsonlinetest_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsonlinetest_relations.chapter_id=cmschapters.id JOIN cmsonlinetest ON cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id WHERE cmsonlinetest.id = '$mar_id9'";
	      	$nn7 = mysqli_num_rows($qry21);//7 api
	      //echo $nn3;exit;
	      if($nn>0){ 
		    //$returnValue['name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
		    $str = $row['name'];
		    $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['name'] = $str;
			$returnValue['slug'] = $row['slug'];
			$returnValue['order'] = $row['order'];
			$returnValue['created'] = $row['created'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
		    $returnValue['keywords'] = $row['keywords'];
		    $returnValue['tagline'] = $row['tagline'];
			$returnValue['id'] = $row['id'];
		
		    $arr=$returnValue;
			
	        }elseif($nn1>0){
	        $str = $row['name'];
		    $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['name'] = $str;
			$returnValue['slug'] = $row['slug'];
			$returnValue['order'] = $row['order'];
			$returnValue['created'] = $row['created'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
		    $returnValue['keywords'] = $row['keywords'];
		    $returnValue['tagline'] = $row['tagline'];
			$returnValue['id'] = $row['id'];
		
		    $arr=$returnValue;
	          
	       }elseif($nn2>0){
	        $str = $row['name'];
		    $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['name'] = $str;
			$returnValue['slug'] = $row['slug'];
			$returnValue['order'] = $row['order'];
			$returnValue['created'] = $row['created'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
		    $returnValue['keywords'] = $row['keywords'];
		    $returnValue['tagline'] = $row['tagline'];
			$returnValue['id'] = $row['id'];
		
		    $arr=$returnValue;
	          
	       }elseif($nn3>0){
	        $str = $row['name'];
		    $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['name'] = $str;
			$returnValue['slug'] = $row['slug'];
			$returnValue['order'] = $row['order'];
			$returnValue['created'] = $row['created'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
		    $returnValue['keywords'] = $row['keywords'];
		    $returnValue['tagline'] = $row['tagline'];
			$returnValue['id'] = $row['id'];
		
		    $arr=$returnValue;
	          
	       }elseif($nn4>0){
	        $str = $row['name'];
		    $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['name'] = $str;
			$returnValue['slug'] = $row['slug'];
			$returnValue['order'] = $row['order'];
			$returnValue['created'] = $row['created'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
		    $returnValue['keywords'] = $row['keywords'];
		    $returnValue['tagline'] = $row['tagline'];
			$returnValue['id'] = $row['id'];
		
		    $arr=$returnValue;
	          
	       }elseif($nn5>0){
	        $str = $row['name'];
		    $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['name'] = $str;
			$returnValue['slug'] = $row['slug'];
			$returnValue['order'] = $row['order'];
			$returnValue['created'] = $row['created'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
		    $returnValue['keywords'] = $row['keywords'];
		    $returnValue['tagline'] = $row['tagline'];
			$returnValue['id'] = $row['id'];
		
		    $arr=$returnValue;
	          
	       }elseif($nn6>0){
	        $str = $row['name'];
		    $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['name'] = $str;
			$returnValue['slug'] = $row['slug'];
			$returnValue['order'] = $row['order'];
			$returnValue['created'] = $row['created'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
		    $returnValue['keywords'] = $row['keywords'];
		    $returnValue['tagline'] = $row['tagline'];
			$returnValue['id'] = $row['id'];
		
		    $arr=$returnValue;
	          
	       }elseif($nn7>0){
	        $str = $row['name'];
		    $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['name'] = $str;
			$returnValue['slug'] = $row['slug'];
			$returnValue['order'] = $row['order'];
			$returnValue['created'] = $row['created'];
			$returnValue['is_featured'] = $row['is_featured'];
			$returnValue['description'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['description']);
		    $returnValue['keywords'] = $row['keywords'];
		    $returnValue['tagline'] = $row['tagline'];
			$returnValue['id'] = $row['id'];
		
		    $arr=$returnValue;
	          
	      }
		  }
			
			return $ress=(count($arr))? $arr : false;
		}
		
	mysqli_close($conn);	
  
?>
