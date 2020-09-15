<?php 
error_reporting(0);
	include ('config.php');
	 	 $name = $_POST['name'];
	
	$tmp = array();
		$subTmp = array();
		$postStatusString = "publish";
//1	
$sel = "SELECT * FROM cmsncertsolutions where name like '%$name%'";
 $result = mysqli_query($conn, $sel);
  $cou = mysqli_num_rows($result);

 //2
 $sel2 = "SELECT * FROM cmsonlinetest where name like '%$name%'";
 $result2 = mysqli_query($conn, $sel2);
 $cou2 = mysqli_num_rows($result2);

 //3
 $sel3 = "SELECT * FROM cmsquestionbank where name like '%$name%'";
 $result3 = mysqli_query($conn, $sel3);
 $cou3 = mysqli_num_rows($result3);
 //4
 $sel4 = "SELECT * FROM cmssamplepapers where name like '%$name%'";
 $result4 = mysqli_query($conn, $sel4);
 $cou4 = mysqli_num_rows($result4);
 //5
 $sel5 = "SELECT * FROM cmssolvedpapers where name like '%$name%'";
 $result5 = mysqli_query($conn, $sel5);
 $cou5 = mysqli_num_rows($result5);
 
  //6
 $sel6 = "SELECT * FROM cmsstudymaterial where name like '%$name%'";
 $result6 = mysqli_query($conn, $sel6);
 $cou6 = mysqli_num_rows($result6);
 
 //7
 $sel7 = "SELECT * FROM cmsvideoslist where name like '%$name%'";
 $result7 = mysqli_query($conn, $sel7);
 $cou7 = mysqli_num_rows($result7);
 
 //8
 $sel8 = "SELECT * FROM cmspricelist where modules_item_name like '%$name%'";
 $result8 = mysqli_query($conn, $sel8);
 $cou8 = mysqli_num_rows($result8);

if($cou){
 $sel = "SELECT * FROM cmsncertsolutions where name like '%$name%'";
}

if($cou2){
 $sel = "SELECT * FROM cmsonlinetest where name like '%$name%'";
}

if($cou3 > 0){
$sel = "SELECT * FROM cmsquestionbank where name like '%$name%'";
}

if($cou4 > 0){
$sel = "SELECT * FROM cmssamplepapers where name like '%$name%'";
}

if($cou5 > 0){
$sel = "SELECT * FROM cmssolvedpapers where name like '%$name%'";
}

if($cou6 > 0){
$sel = "SELECT * FROM cmsstudymaterial where name like '%$name%'";
}

if($cou7 > 0){
$sel = "SELECT * FROM cmsvideoslist where name like '%$name%'";
}

$result = mysqli_query($conn, $sel);
$cou1 = mysqli_num_rows($result);
if($cou1 > 0){
while($row = mysqli_fetch_array($result)) {
			 $mar_id = $row['id'];
			$job = array();
			$job = getcoursebycat($mar_id,$conn,$cou,$cou1,$cou2,$cou3,$cou4,$cou5,$cou6,$cou7);
			$subTmp[] = $job;
		}
}
		$tmp['status'] = "success";
		if($subTmp){
	$tmp['data'] = $subTmp;
		}
		else {
			$tmp['data'] = "no data";
		
			}
		echo json_encode($tmp,$tmpt);
	
		
		function getcoursebycat($mar_id,$conn,$cou,$cou1,$cou2,$cou3,$cou4,$cou5,$cou6,$cou7) {		
			$returnValue = array();
			
if($cou){$result = mysqli_query($conn, "SELECT * FROM cmsncertsolutions WHERE id = '$mar_id'");}
if($cou2){$result = mysqli_query($conn, "SELECT * FROM cmsonlinetest WHERE id = '$mar_id'");}
if($cou3){$result = mysqli_query($conn, "SELECT * FROM cmsquestionbank WHERE id = '$mar_id'");}
if($cou4){$result = mysqli_query($conn, "SELECT * FROM cmssamplepapers WHERE id = '$mar_id'");}
if($cou5){$result = mysqli_query($conn, "SELECT * FROM cmssolvedpapers WHERE id = '$mar_id'");}
if($cou6){$result = mysqli_query($conn, "SELECT * FROM cmsstudymaterial WHERE id = '$mar_id'");}
if($cou7){$result = mysqli_query($conn, "SELECT * FROM cmsvideoslist WHERE id = '$mar_id'");}

			while($row = mysqli_fetch_array($result)) 
			{
			    $returnValue['id'] = $iid = $row['id'];
			     $returnValue['result_name'] = $iid = $row['name'];
				}
	        	return $returnValue;
		}
		
	
 ?>
 
