<?php
include("config.php");
if (!empty($_POST['user_id']) && !empty($_POST['video_id']) && !empty($_POST['duration']) ) 
	{
  date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
   $date = date('Y-m-d H:i:s');
    $userid = $_POST['user_id'];
    $video_id = $_POST['video_id'];
    $duration = $_POST['duration'];
    $batch_date = $_POST['batch_date'];
    
      
	$in = "INSERT INTO user_video_story (user_id,video_id,duration,batch_date) VALUES ('$userid','$video_id','$duration','$date')";
			 $ob = mysqli_query($conn,$in);
			  $se = "SELECT * FROM user_video_story where user_id='$userid'";
			  $obs = mysqli_query($conn,$se);
			  $numrows = mysqli_num_rows($obs);
			  if($numrows > 0){
			   $row=mysqli_fetch_array($obs);
			   $reus=$row['user_id'];
			   
	$data = array("response"=>array("user_id" => $reus, "status" => "true", "msg" => "Video Story Add Successfully"));	
                  } else {
           $data = array("response"=>array("status" => "false", "msg" => "Video Not Inserted"));

                  }
             
                  
	}
	else 
	{
    $data = array("response"=>array("status" => "false", "msg" => "Enter all parameters!"));
    }

	$newarray = $data;
	echo json_encode($newarray);

?>


