<?php
error_reporting(0);
	include('config.php');
	
	$category = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];$sp_cnt=0;$sop_cnt=0;$notes_cnt=0;$qb_cnt=0;$ncrt_cnt=0;
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
    if($subject_id == 0 and $chapter_id == 0)
	{
	    $qry_sap = "SELECT cmssamplepapers.id FROM cmssamplepapers_relations LEFT JOIN categories ON cmssamplepapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssamplepapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssamplepapers_relations.chapter_id=cmschapters.id JOIN cmssamplepapers ON cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id WHERE cmssamplepapers_relations.exam_id = '$category' ORDER BY cmssamplepapers.id DESC";
	    $qry_sop = "SELECT cmssolvedpapers.id FROM cmssolvedpapers_relations LEFT JOIN categories ON cmssolvedpapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssolvedpapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssolvedpapers_relations.chapter_id=cmschapters.id JOIN cmssolvedpapers ON cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id WHERE cmssolvedpapers_relations.exam_id = '$category' GROUP BY cmssolvedpapers_relations.solvedpapers_id ORDER BY cmssolvedpapers.years DESC";
	    $qry_notes = "SELECT postings.id as id, postings.title as title, postings.category_id, postings.subject_id, postings.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM postings LEFT JOIN categories ON categories.id=postings.category_id LEFT JOIN cmssubjects ON cmssubjects.id=postings.subject_id LEFT JOIN cmschapters ON cmschapters.id=postings.chapter_id WHERE category_id = '$category' AND top_category_id = '21' ORDER BY postings.id DESC LIMIT 100";
	    $qry_qb = "SELECT cmsquestionbank.id as questionbank_id, cmsquestionbank.name, cmsquestionbank_relations.exam_id, cmsquestionbank_relations.subject_id, cmsquestionbank_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsquestionbank_relations LEFT JOIN categories ON cmsquestionbank_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsquestionbank_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsquestionbank_relations.chapter_id=cmschapters.id JOIN cmsquestionbank ON cmsquestionbank.id=cmsquestionbank_relations.questionbank_id WHERE cmsquestionbank_relations.exam_id = '$category' ORDER BY `cmsquestionbank`.`id` DESC LIMIT 100";
	    $qry_ncrt = "SELECT cmsncertsolutions.name, cmsncertsolutions.id, cmsncertsolutions_relations.exam_id, cmsncertsolutions_relations.subject_id, cmsncertsolutions_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsncertsolutions_relations LEFT JOIN categories ON cmsncertsolutions_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsncertsolutions_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsncertsolutions_relations.chapter_id=cmschapters.id JOIN cmsncertsolutions ON cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id WHERE cmsncertsolutions_relations.exam_id = '$category' ORDER BY cmsncertsolutions.id DESC";
	}
	else if($subject_id > 0 and $chapter_id == 0)
	{
	    $qry_sap = "SELECT cmssamplepapers.id FROM cmssamplepapers_relations LEFT JOIN categories ON cmssamplepapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssamplepapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssamplepapers_relations.chapter_id=cmschapters.id JOIN cmssamplepapers ON cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id WHERE cmssamplepapers_relations.exam_id = '$category' AND cmssamplepapers_relations.subject_id = '$subject_id' ORDER BY cmssamplepapers.id DESC";
	    $qry_sop = "SELECT cmssolvedpapers.id FROM cmssolvedpapers_relations LEFT JOIN categories ON cmssolvedpapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssolvedpapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssolvedpapers_relations.chapter_id=cmschapters.id JOIN cmssolvedpapers ON cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id WHERE cmssolvedpapers_relations.exam_id = '$category' AND cmssolvedpapers_relations.subject_id = '$subject_id' GROUP BY cmssolvedpapers_relations.solvedpapers_id ORDER BY cmssolvedpapers.years DESC";
	    $qry_notes = "SELECT postings.id as id, postings.title as title, postings.category_id, postings.subject_id, postings.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM postings LEFT JOIN categories ON categories.id=postings.category_id LEFT JOIN cmssubjects ON cmssubjects.id=postings.subject_id LEFT JOIN cmschapters ON cmschapters.id=postings.chapter_id WHERE category_id = '$category' AND subject_id = '$subject_id' AND top_category_id = '21' ORDER BY postings.id DESC LIMIT 100";
	    $qry_qb = "SELECT * FROM cmsquestionbank_relations where exam_id = '$category' and subject_id='$subject_id' limit 20";
	    $qry_ncrt = "SELECT cmsncertsolutions.name, cmsncertsolutions.id, cmsncertsolutions_relations.exam_id, cmsncertsolutions_relations.subject_id, cmsncertsolutions_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsncertsolutions_relations LEFT JOIN categories ON cmsncertsolutions_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsncertsolutions_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsncertsolutions_relations.chapter_id=cmschapters.id JOIN cmsncertsolutions ON cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id WHERE cmsncertsolutions_relations.exam_id = '$category' AND cmsncertsolutions_relations.subject_id = '$subject_id' ORDER BY cmsncertsolutions.id DESC";
	}
	else if($subject_id > 0 and $chapter_id > 0)
	{
	    $qry_sap = "SELECT cmssamplepapers.id FROM cmssamplepapers_relations LEFT JOIN categories ON cmssamplepapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssamplepapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssamplepapers_relations.chapter_id=cmschapters.id JOIN cmssamplepapers ON cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id WHERE cmssamplepapers_relations.exam_id = '$category' AND cmssamplepapers_relations.subject_id = '$subject_id' AND cmssamplepapers_relations.chapter_id = '$chapter_id' ORDER BY cmssamplepapers.id DESC";
	    $qry_sop = "SELECT cmssolvedpapers.id FROM cmssolvedpapers_relations LEFT JOIN categories ON cmssolvedpapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssolvedpapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssolvedpapers_relations.chapter_id=cmschapters.id JOIN cmssolvedpapers ON cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id WHERE cmssolvedpapers_relations.exam_id = '$category' AND cmssolvedpapers_relations.subject_id = '$subject_id' AND cmssolvedpapers_relations.chapter_id = '$chapter_id' GROUP BY cmssolvedpapers_relations.solvedpapers_id ORDER BY cmssolvedpapers.years DESC";
	    $qry_notes = "SELECT postings.id as id, postings.title as title, postings.category_id, postings.subject_id, postings.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM postings LEFT JOIN categories ON categories.id=postings.category_id LEFT JOIN cmssubjects ON cmssubjects.id=postings.subject_id LEFT JOIN cmschapters ON cmschapters.id=postings.chapter_id WHERE category_id = '$category' AND subject_id = '$subject_id' AND chapter_id = '$chapter_id' AND top_category_id = '21' ORDER BY postings.id DESC LIMIT 100";
	    $qry_qb = "SELECT * FROM cmsquestionbank_relations where exam_id = '$category' and subject_id='$subject_id' and chapter_id = '$chapter_id' limit 20";
	    $qry_ncrt = "SELECT cmsncertsolutions.name, cmsncertsolutions.id, cmsncertsolutions_relations.exam_id, cmsncertsolutions_relations.subject_id, cmsncertsolutions_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsncertsolutions_relations LEFT JOIN categories ON cmsncertsolutions_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsncertsolutions_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsncertsolutions_relations.chapter_id=cmschapters.id JOIN cmsncertsolutions ON cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id WHERE cmsncertsolutions_relations.exam_id = '$category' AND cmsncertsolutions_relations.subject_id = '$subject_id' AND cmsncertsolutions_relations.chapter_id = '$chapter_id' ORDER BY cmsncertsolutions.id DESC";
	}
    else
    {
        $qry_sap = "SELECT cmssamplepapers.id FROM cmssamplepapers_relations LEFT JOIN categories ON cmssamplepapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssamplepapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssamplepapers_relations.chapter_id=cmschapters.id JOIN cmssamplepapers ON cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id WHERE cmssamplepapers_relations.exam_id = '$category' ORDER BY cmssamplepapers.id DESC";
	    $qry_sop = "SELECT cmssolvedpapers.id FROM cmssolvedpapers_relations LEFT JOIN categories ON cmssolvedpapers_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmssolvedpapers_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmssolvedpapers_relations.chapter_id=cmschapters.id JOIN cmssolvedpapers ON cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id WHERE cmssolvedpapers_relations.exam_id = '$category' GROUP BY cmssolvedpapers_relations.solvedpapers_id ORDER BY cmssolvedpapers.years DESC";
	    $qry_notes = "SELECT postings.id as id, postings.title as title, postings.category_id, postings.subject_id, postings.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM postings LEFT JOIN categories ON categories.id=postings.category_id LEFT JOIN cmssubjects ON cmssubjects.id=postings.subject_id LEFT JOIN cmschapters ON cmschapters.id=postings.chapter_id WHERE category_id = '$category' AND top_category_id = '21' ORDER BY postings.id DESC LIMIT 100";
	    $qry_qb = "SELECT cmsquestionbank.id as questionbank_id, cmsquestionbank.name, cmsquestionbank_relations.exam_id, cmsquestionbank_relations.subject_id, cmsquestionbank_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsquestionbank_relations LEFT JOIN categories ON cmsquestionbank_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsquestionbank_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsquestionbank_relations.chapter_id=cmschapters.id JOIN cmsquestionbank ON cmsquestionbank.id=cmsquestionbank_relations.questionbank_id WHERE cmsquestionbank_relations.exam_id = '$category' ORDER BY `cmsquestionbank`.`id` DESC LIMIT 100";
	    $qry_ncrt = "SELECT cmsncertsolutions.name, cmsncertsolutions.id, cmsncertsolutions_relations.exam_id, cmsncertsolutions_relations.subject_id, cmsncertsolutions_relations.chapter_id, categories.name as exam, cmssubjects.name as subject, cmschapters.name as chapter FROM cmsncertsolutions_relations LEFT JOIN categories ON cmsncertsolutions_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsncertsolutions_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsncertsolutions_relations.chapter_id=cmschapters.id JOIN cmsncertsolutions ON cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id WHERE cmsncertsolutions_relations.exam_id = '$category' ORDER BY cmsncertsolutions.id DESC";
    }
	$result = mysqli_query($conn,$qry_sap);
	$result_sop = mysqli_query($conn,$qry_sop);
	$result_notes = mysqli_query($conn,$qry_notes);
	$result_qb = mysqli_query($conn,$qry_qb);
	$result_ncrt = mysqli_query($conn,$qry_ncrt);
    }
    if($row = mysqli_num_rows($result))
    {
        $sp_cnt = 1;
    }
    if($row = mysqli_num_rows($result_sop))
    {
        $sop_cnt = 1;
    }
    if($row = mysqli_num_rows($result_notes))
    {
        $notes_cnt = 1;
    }
    if($row = mysqli_num_rows($result_qb))
    {
        $qb_cnt = 1;
    }
    if($row = mysqli_num_rows($result_ncrt))
    {
        $ncrt_cnt = 1;
    }
	$tmp['status'] = "success";$tmp['samplepaper_count'] = $sp_cnt;$tmp['solvedpaper_count'] = $sop_cnt;$tmp['questionbank_count'] = $qb_cnt;$tmp['notes_count'] = $notes_cnt;$tmp['video_count'] = 1;$tmp['studypackage_count'] = 1;$tmp['ncert_count'] = $ncrt_cnt;$tmp['testseries_count'] = 1;
    echo json_encode($tmp);
    mysqli_close($conn);
	
?>
