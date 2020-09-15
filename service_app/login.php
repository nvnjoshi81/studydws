<?php
		
		include("config.php");
		$tmp = array();
		$subTmp = array();
		$postStatusString = "publish";
		$email = $_POST["email"] ;
		$password = md5($_POST["password"]) ;
		$ullog = "select * from cmscustomers where email='$email' and password ='$password' and status = '1'";
		 $mullog = mysqli_query($conn,$ullog) ;
		 $tuol = mysqli_num_rows($mullog) ;
if($tuol > 0)
	{
		while($roul = mysqli_fetch_array($mullog))
		{
	
        $data = array("response"=>array("status" => "true","username" => $roul["firstname"],"email" => $roul["email"], "user_id" => $roul["id"],"category_id" => $roul["subject_id"],"user_key" => $roul["user_key"], "verified" => $roul["status"],"device_id"=>$device_id, "msg" => "Success"));
                }
        $newarray = $data;

	echo json_encode($newarray);
       }
       else
       {
	
        $data = array("response"=>array("status" => "false","username" => "","email" => "","user_id" => "", "verified" => "", "msg" => "please check the credentials or contact admin"));

	$newarray = $data;

	echo json_encode($newarray);
}

?>