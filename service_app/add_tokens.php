<?php
include("config.php");
if (!empty($_POST['token']) && !empty($_POST['user_id'])) 
	{

    $userid = $_POST['user_id'];
    $token = $_POST['token'];
    
       $ssdr = "select * from user_tokens where user_id = '$userid' and token_name = '$token' ";
         $ssdfg = mysqli_query($conn,$ssdr); 
         $dsa = mysqli_num_rows($ssdfg);
           if($dsa > 0) 
           {
               $data = array("response"=>array("status" => "false", "msg" => "This Token Already Registered"));
               
           } else {
   
	$in = "INSERT INTO user_tokens (token_name,user_id) VALUES ('$token','$userid')";
			 $ob = mysqli_query($conn,$in);
			  $se = "SELECT * FROM user_tokens where user_id='$userid'";
			  $obs = mysqli_query($conn,$se);
			  $numrows = mysqli_num_rows($obs);
			  if($numrows > 0){
			   $row=mysqli_fetch_array($obs);
			   $reus=$row['user_id'];
			   $tknname=$row['token_name']; 
	$data = array("response"=>array("user_id" => $reus,"token" =>$tknname, "status" => "true", "msg" => "Token Add Successfully"));	
                  } else {
           $data = array("response"=>array("status" => "false", "msg" => "User Not Inserted"));

                  }
           }  
                  
	}
	else 
	{
    $data = array("response"=>array("status" => "false", "msg" => "Enter all parameters!"));
    }

	$newarray = $data;
	echo json_encode($newarray);
mysqli_close($conn);
?>


