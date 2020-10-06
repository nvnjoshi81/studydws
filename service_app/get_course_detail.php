<?php
error_reporting(0);
	include('config.php');
	
	$category = $_POST['category_id'];
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	
    $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
    $oppf = mysqli_query($conn, $self);
    $rww = mysqli_num_rows($oppf);
    if($rww > 0)
    {
	while($ryu = mysqli_fetch_array($oppf)){
	$get_api = $ryu['user_key'];
	}
  }
  
  
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";

    if($get_api)
    {
    $qry = "SELECT id FROM cmspackages_counter WHERE exam_id = '$category' AND level = 'exam' AND total_package > '0' AND total_question > '0'";
	$result = mysqli_query($conn,$qry);
    }

	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "no data";}
	echo json_encode($tmp);
	
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$qry = "SELECT id, total_package, total_question, module_type FROM cmspackages_counter WHERE id = '$mar_id' and total_package > '0' and total_question > '0'";
		$result = mysqli_query($conn,$qry);
		if($row = mysqli_fetch_array($result)) 
		{
		    $modtype;$imgmodtype;
		    if($row['module_type'] == "question-bank")
		    {
		     $modtype = "Question Bank";
		     $imgmodtype = "https://www.studyadda.com/assets/frontend/product_images/100_100_question_bank.png";
		     $tp = "Total Question Banks : ".$row['total_package']."+";
		     $tq = "Total Questions : ".$row['total_question'];
		    }
		    else if($row['module_type'] == "sample-papers")
		    {
		     $modtype = "Sample Papers";
		     $imgmodtype = "https://www.studyadda.com/assets/frontend/product_images/100_100_sample_papers.png";
		     $tp = "Total Sample Papers : ".$row['total_package']."+";
		     $tq = "Total Questions : ".$row['total_question'];
		    }
		    else if($row['module_type'] == "solved-papers")
		    {
		     $modtype = "Solved Papers";
		     $imgmodtype = "https://www.studyadda.com/assets/frontend/product_images/100_100_solved_papers.png";
		     $tp = "Total Solved Papers : ".$row['total_package']."+";
		     $tq = "Total Questions : ".$row['total_question'];
		    }
		    else if($row['module_type'] == "online-test")
		    {
		     $modtype = "Online Tests";
		     $imgmodtype = "https://www.studyadda.com/assets/frontend/product_images/100_100_online_test.png";
		     $tp = "Total Online Test : ".$row['total_package']."+";
		     $tq = "Total Questions : ".$row['total_question'];
		    }
		    else if($row['module_type'] == "study-packages")
		    {
		     $modtype = "Study Packages";
		     $imgmodtype = "https://www.studyadda.com/assets/frontend/product_images/100_100_study_packages.png";
		     $tp = "Total Study packages : ".$row['total_package']."+";
		    }
		    else if($row['module_type'] == "ncert-solution")
		    {
		     $modtype = "NCERT Solutions";
		     $imgmodtype = "https://www.studyadda.com/assets/frontend/product_images/100_100_ncert_solutions.png";
		     $tp = "Total NCERT Chapters : ".$row['total_package']."+";
		     $tq = "Total Questions : ".$row['total_question'];
		    }
		    else if($row['module_type'] == "videos")
		    {
		     $modtype = "Videos";
		     $imgmodtype = "https://www.studyadda.com/assets/frontend/product_images/100_100_video_lecture_series.png";
		     $tp = "Total Lecture Series : ".$row['total_package']."+";
		     $tq = "Total Videos : ".$row['total_question'];
		    }
		    else if($row['module_type'] == "notes")
		    {
		     $modtype = "Notes";
		     $imgmodtype = "https://www.studyadda.com/assets/frontend/product_images/100_100_notes.png";
		     $tp = "Total Notes : ".$row['total_package']."+";
		    }
		    if($modtype>"")
		    {
            $returnValue['module_type'] = $modtype;
		    }
		    else
		    {
		        $returnValue['module_type'] = $row['module_type'];
		    }
            $returnValue['total_package'] = $tp;
            if($tq > "")
            {
                $returnValue['total_question'] = $tq;
            }
            else
            {
                $returnValue['total_question'] = "";
            }
            $returnValue['module_image'] = $imgmodtype;
		    $returnValue['id'] = $row['id'];
		}
		return $returnValue;
	}
	
	mysqli_close($conn);
	
?>
