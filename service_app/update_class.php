<?php 
include ('config.php');
error_reporting(0);
$id=$_GET['id'];
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
  
$array1=array();
	{
	
		
		if (!empty($_POST['user_id']) && !empty($get_api)) 

		{


    $id = $_POST['user_id'];
    $class = $_POST['class_id'];
   
	

	  $query_req1=mysqli_query($conn,"UPDATE cmscustomers SET subject_id='$class' where id ='$id'");
		
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
	mysqli_close($conn);
?>