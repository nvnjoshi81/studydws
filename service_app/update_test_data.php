<?php 
include ('config.php');
error_reporting(0);
$id=$_GET['id'];
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$test_id = $_POST['test_id'];
	$device_id = $_POST['device_id'];
	$id = $_POST['update_id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'  and device_id = '$device_id'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	  while($ryu = mysqli_fetch_array($oppf)){
	$get_api = $ryu['user_key'];
	  }
  }
  
  	


	
$array1=array();
	{
	
		
		if (!empty($_POST['user_id'])) 

		{
		    
		    
		    
   $sel = "select * from cmsusertest where test_id = '$test_id' AND user_id = '$user_id'";
$osd = mysqli_query($conn,$sel);
while($ssr = mysqli_fetch_array($osd))
{   $rmar = $ssr['right_answer_marks'];
$wmar = $ssr['wrong_answer_marks'];

	}
	
	  $selt = "SELECT * FROM cmsonlinetest where id = '$test_id'";
$osdt = mysqli_query($conn,$selt);
while($ssrt = mysqli_fetch_array($osdt))
{  $tttime = $ssrt['time'];


	}
	

	
		      
	    	  $se = "SELECT * FROM cmsusertest_detail where usertest_id = '$id' and is_correct = '1' ";
			  $ob = mysqli_query($conn, $se);
			    $right = mysqli_num_rows($ob); 
			   
			    $se1 = "SELECT * FROM cmsusertest_detail where usertest_id = '$id' and is_correct = '2'  ";
			  $ob1 = mysqli_query($conn, $se1);
			     $review = mysqli_num_rows($ob1); 
			   
			    $se2 = "SELECT * FROM cmsusertest_detail where usertest_id = '$id' and is_correct = '0' ";
			  $ob2 = mysqli_query($conn, $se2);
			     $wrong = mysqli_num_rows($ob2);
			   
			   
			   $omark = $rmar*$right;
			   $attamp = $right+$review+$wrong;
			
			
		$ses =	 "SELECT * FROM cmsonlinetest_details where onlinetest_id = '$test_id'";
			  $obs = mysqli_query($conn, $ses);
			    $tot = mysqli_num_rows($obs); 
			   
			   $notat = $tot-$attamp;
$tim = time();

  "UPDATE cmsusertest SET  obtain_marks = '$omark', reviewed_qus='$review',attampted_ques='$attamp',not_attampted_qus='$notat',total_qus='$tot',correct_ans='$right',
	  incorrect_ans='$wrong',status='1' where id ='$id'";
	  $query_req1=mysqli_query($conn,"UPDATE cmsusertest SET  obtain_marks = '$omark', reviewed_qus='$review',attampted_ques='$attamp',not_attampted_qus='$notat',total_qus='$tot',correct_ans='$right',
	  incorrect_ans='$wrong',status='1',dt_created='$tim',total_time='$tttime' where id ='$id'");
		
		if($query_req1)
		{
			//$array1['id']="";
			$array1['status']="true";
			$array1['msg']="Class updated successfully";
		
		}
		else
		{
			$array1['status']="false";
			$array1["query"]= "Please try again";
		}
			
		
	}
	else
	{
		$array1['status']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
?>