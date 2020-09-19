<?php
include("config.php");
error_reporting(0);$mobile_no;


 $package = $_POST['package']; 
  $ran_no = $_POST['ran_no'];
  $device_id= $_POST['device_id'];
  if(isset($_POST['mobile_no']))
  {
  $mobile_no= $_POST['mobile_no'];
  }
  else
  {
  $mobile_no = "";   
  }


  if($first > $ran_no  AND $last > $ran_no )
  $pac = "com.studyaddaapp";
  
    $self = "select * from diff where $ran_no BETWEEN first and last and pac = '$package'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	 $tes_id = "123456TE123StudyYadda";
	  
  }
  

if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($tes_id)) 
    {

    $name = $_POST['name'];
   // $id = $_POST['user_id'];
    $email = $_POST['email'];
 
    
    
    $sel = "select * from cmscustomers where email = '$email'";
    $userchk = mysqli_query($conn,$sel);
    $numrows = mysqli_num_rows($userchk);
    if ($numrows < 1)
    {
        
          
	     function generate_random_password($length = 10) {
    $alphabets = range('A','Z');
    $numbers = range('0','9');
    $additional_characters = array('_','.');
    $final_array = array_merge($alphabets,$numbers,$additional_characters);
  $passwordn = '';
    while($length--) {
      $key = array_rand($final_array);
      $passwordn .= $final_array[$key];
    }
  
    return $passwordn;
  }
   $user_key = "SD".$api_no =   generate_random_password(10) ;
   $dtnow = strtotime("now");
   $in = "INSERT INTO cmscustomers (firstname,email,device_id,user_key,subject_id,is_app_registered, created_dt, usertype, is_social,mobile) VALUES ('$name','$email','$device_id','$user_key','0','1','$dtnow', 'student', '1','$mobile_no')";
             $ob = mysqli_query($conn,$in);
            if($ob)
            {
              $se = "SELECT * FROM cmscustomers where email='$email' and firstname='$name'" ;
              $trt = mysqli_query($conn,$se);
               $row=mysqli_fetch_array($trt);
               $re=$row['email']; 
                $re_id=$row['id'];
                $firstname=$row['firstname'];
                $device_id=$row['device_id'];
                $status=$row['status'];
				$category=$row['subject_id']; 
				$usrkey = $row["user_key"];
				if($row["mobile"] != "")
				{
				$mobile = $row["mobile"];
				}
				else
				{
				    $mobile = "";
				}
				$result = mysqli_query($conn,"SELECT * FROM categories WHERE id = '$category'");
        		if($row = mysqli_fetch_array($result)) 
        		{			 
        		//$category_name = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
        		$str = htmlentities($row['name'], ENT_QUOTES, "UTF-8");
            	$category_name = $str;
        		}        
                $data = array("response"=>array("email" => $email,"mobile" => $mobile,"username" => $firstname,"user_id" => $re_id,"category" => $category, "category_name" => $category_name, "status" => "true","user_key" => $usrkey, "verified" => "1","device_id"=>$device_id, "msg" => "Sign up Successful"));  
                
            }
            else
            {
                //$data = array("response"=>array("status" => "true", "msg" => "Something went wrong! Unable to Sign up.", "mobile" => ""));
                $data = array("response"=>array("email" => $email,"mobile" => $mobile,"username" => $firstname,"user_id" => $re_id,"category" => $category, "category_name" => $category_name, "status" => "true","user_key" => $usrkey, "verified" => "1","device_id"=>$device_id, "msg" => "Something went wrong! Unable to Sign up."));
            }
            } 
    else
    {
    $userc =  mysqli_fetch_array($userchk) ;
    $uid = $userc["id"] ;
    $emails=$userc['email']; 
    $re_id=$userc['id'];
    $firstname=$userc['firstname'];
    $section=$userc['section'];
	$category=$userc['subject_id'];
	$usrkey = $userc["user_key"];
	if($userc["mobile"] != "")
	{
	    $mobile = $userc["mobile"];
	}
	else
	{
	    $mobile = "";
	}
	$result = mysqli_query($conn,"SELECT * FROM categories WHERE id = '$category'");
	if($row = mysqli_fetch_array($result)) 
	{			 
	//$category_name = preg_replace('/[^A-Za-z0-9]/', ' ', $row['name']);
	$str = htmlentities($row['name'], ENT_QUOTES, "UTF-8");
	$category_name = $str;
	}
	$status=$userc['status'];
    $device_id= $_POST['device_id'];
    $devid = $userc['device_id'];
    if($device_id == $devid || $devid == "")
    {
        $up = "UPDATE cmscustomers SET device_id = '$device_id' where email = '$email'";
        $opp = mysqli_query($conn, $up);
        $data = array("response"=>array("email" => $email,"mobile" => $mobile,"username" => $firstname,"user_id" => $re_id,"category" => $category, "category_name" => $category_name, "status" => "true","user_key" => $usrkey, "verified" => "1","device_id"=>$device_id, "msg" => "Sign up Successful"));
    }
    else
    {
        $up = "UPDATE cmscustomers SET device_id = '$device_id' where email = '$email'";
        $opp = mysqli_query($conn, $up);
        $data = array("response"=>array("email" => $email,"mobile" => $mobile,"username" => $firstname,"user_id" => $re_id,"category" => $category, "category_name" => $category_name, "status" => "true","user_key" => $usrkey, "verified" => "1","device_id"=>$device_id, "msg" => "Sign up Successful"));           
    }
    }
    }
    else 
    {
    $data = array("response"=>array("status" => "true", "msg" => "Enter all parameters!", "mobile" => ""));
    }

    $newarray = $data;
    echo json_encode($newarray);

?>