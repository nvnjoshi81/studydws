<?php
error_reporting(0);
	include('config.php');
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

    if($get_api)
    {
    $qry = "SELECT p.id FROM postings p JOIN categories c ON c.id = p.category_id WHERE p.published = 1 AND p.top_category_id = 12 ORDER BY CAST(p.dt_created AS SIGNED) DESC LIMIT 10";
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
	mysqli_close($conn);
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$qry = "SELECT p.id, p.title, p.description, c.name as category_name FROM postings p JOIN categories c ON c.id = p.category_id WHERE p.published = 1 AND p.top_category_id = 12 AND p.id = '$mar_id' ORDER BY CAST(p.dt_created AS SIGNED) DESC LIMIT 10
";
		$result = mysqli_query($conn,$qry);
		if($row = mysqli_fetch_array($result)) 
		{
            $returnValue['category_name'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['category_name']);
            $str = $row['title'];
		    $str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
            $returnValue['title'] = $str;
            $str = $row['description'];
		    $str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);
            $returnValue['description'] = $str;
            $returnValue['id'] = $row['id'];
		}
		return $returnValue;
	}
	
?>
