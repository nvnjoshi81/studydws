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
	if (!empty($_POST['user_id']) && !empty($get_api) && !empty($_POST['user_id']) && !empty($_POST['mobile'])) 
    {
    $id = $_POST['user_id'];
    $mobile = $_POST['mobile'];
    $self = "select * from cmscustomers where mobile = '$mobile'";
    $oppf = mysqli_query($conn, $self);
    $rww = mysqli_num_rows($oppf);
    if($rww < 1)
    {
    $query_req1=mysqli_query($conn,"UPDATE cmscustomers SET mobile='$mobile' where id ='$id'");
	if($query_req1)
		{
			//$array1['id']="";
			$array1['status']="true";
			$array1['msg']="Mobile number updated successfully";
		
		}
		else
		{
			$array1['status']="false";
			$array1["msg"]= "Please try again";
		}
    }
    else
    {
        $array1['status']="false";
		$array1["msg"]= "Mobile Number already exists.";
    }
	}
	else
	{
		$array1['status']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
?>