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
	
		
		if (!empty($_POST['id']) && !empty($get_api)) 

		{


    $id = $_POST['id'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $contactno = $_POST['mobile'];
     $city_id = $_POST['city_id'];
	
	  $ra = rand(1234,4565);
	   $image = $_FILES["image"]["name"] ;
    $tmp = $_FILES["image"]["tmp_name"] ;
    move_uploaded_file($tmp,"../upload/user/".$image) ;
	if($image){
	$upim = "UPDATE cmscustomers SET image = '$image' where id = '$id'";
	$osd = mysqli_query($conn,$upim);
	}
	  
	  $query_req1=mysqli_query($conn,"UPDATE cmscustomers SET firstname='$name',mobile='$contactno',email='$email',city_id='$city_id' where id ='$id'");
		
		if($query_req1)
		{
			//$array1['id']="";
			$array1['status']="true";
			$array1['msg']="Profile updated successfully";
		
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