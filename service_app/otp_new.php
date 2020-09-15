<?php
error_reporting(0);
include("config.php");



 $package = $_POST['package']; 
  $ran_no = $_POST['ran_no'];
  $email = $_POST['email'];


  if($first > $ran_no  AND $last > $ran_no)
  $pac = "com.studyadda";
  
     $self = "select * from diff where $ran_no BETWEEN first and last and pac = '$package'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	 $tes_id = "123456TE123StudyYadda";
	  
  }
  
  
if (!empty($_POST['otp'])&& !empty($tes_id)) {

   
    $otp = $_POST['otp'];

 $query = "select * from cmscustomers where otp='".$otp."' and email = '$email'";
    $result = mysqli_query($conn,$query);
    if (mysqli_num_rows($result) > 0) {
        $newarray = array();
        if ($row = mysqli_fetch_array($result)) {
  
        $update_staus=mysqli_query($conn,"update cmscustomers set status='1' where otp='".$row['otp']."' and email = '".$row['email']."'");
        
     $query1 = "select * from users where id='".$id."' and otp='".$otp."'";
                    $result1 = mysqli_query($conn,$query1);
                    while($row1=mysqli_fetch_array($result1))

                    {

$sta = $row1['verify_status']; 
$type = $row1['type'];           
         }
            $data = array("response"=>array("status" => "true","id" => $row['id'], "msg" => "Verified successfully."));
        }
    }
     else {
        $data = array("response"=>array("status" => "false", "msg" => "Invalid otp"));
    }

    $newarray = $data;
    echo json_encode($newarray);
} else {

    echo json_encode(array("response"=>array('status'=>'false','msg'=>'Invalid Request')));
}
?>