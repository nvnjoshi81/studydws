<?php
		
		include ('config.php');
	 	 $usertest_id = $_POST['usertest_id'];
	 	 	$user_key = $_POST['user_key'];
     	$user_id = $_POST['user_id'];
		$device_id = $_POST['device_id'];
			$mar_ids = $_POST['question_id'];
	
		$tmp = array();
		$subTmp = array();
		$postStatusString = "publish";
	
	    $ullog = "SELECT * FROM cmsusertest_detail where question_id = '$mar_ids' and usertest_id = '$usertest_id' ORDER BY id DESC LIMIT 1";
		 $mullog = mysqli_query($conn, $ullog) ;
		 $tuol = mysqli_num_rows($mullog) ;
if($tuol > 0)
	{
		while($roul = mysqli_fetch_array($mullog))
		{
		$tmp['is_selectes_answer'] = $roul['users_answer'];}
echo json_encode($tmp);
}
else
{
	$tmp['is_selectes_answer'] = "";

	echo json_encode($tmp);
}

			 ?>