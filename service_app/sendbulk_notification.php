<?php 
include('config.php');

  date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
   $date = date('Y-m-d H:i:s');

    $title = $_REQUEST['title'];
    $msg = $_REQUEST['description'];     
    $tokens = $_REQUEST['token']; 
    $pages = $_REQUEST['pages'];
    $exam_id = $_REQUEST['exam_id'];
    $type = $_REQUEST['type'];
    $id = $_REQUEST['id'];
  $tokens = array($tokens);  
    //$g_tkn = mysqli_query($conn,"select * from user_tokens where user_id = '$user_id' limit 1");
           // while($mg_tkn = mysqli_fetch_array($g_tkn))
            //{  $regId = $mg_tkn["token_name"]; }
           // echo "insert into notifications (title,description,pages,exm_id,type,id_1,noti_date) values ('$title','$msg','$pages','$exam_id','$type','$id','$date')";
    $inn = "insert into notifications (title,description,pages,exm_id,type,id_1,noti_date) values ('$title','$msg','$pages','$exam_id','$type','$id','$date')";
    $opp = mysqli_query($conn, $inn); 
  
//$push_notification_android="";
push_notification_android($tokens,$title,$msg,$exam_id,$type,$id);
function push_notification_android($tokens,$title,$msg,$exam_id,$type,$id) {
$url = 'https://fcm.googleapis.com/fcm/send';
$api_key = 'AAAAIVmGV8Y:APA91bHkI6zYMCqxo14P4--xh5Fjr36gi6Z1_vk8p9Zm-ituhRT9qJYfOKRPIzt-LTkJMJ8JuBEScDKgqpzZfMiFnAhBZ_nu7c6VNYQg2ut7XfKCcsXuhnva-nNHe2c23ZYAeLXmlwSX';
$messageArray = array();
$messageArray["notification"] = array (
    'title' => $title,
    'message' => $msg,
    //'customParam' => $customParam,
    'exam_id' => $exam_id,
    'type' => $type,
    'id' => $id,
    'sound' => 'default', 
    'badge' => '1',
);
$fields = array(
    'registration_ids' => $tokens,
    'data' => $messageArray,
    'priority'=>'high',
);
$headers = array(
    'Authorization: key=' . $api_key, //GOOGLE_API_KEY
    'Content-Type: application/json'
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
$result = curl_exec($ch);
//print_r($result);
if ($result === FALSE) {
    echo 'Android: Curl failed: ' . curl_error($ch);
}
// Close connection
curl_close($ch);
return $result;
}

?>