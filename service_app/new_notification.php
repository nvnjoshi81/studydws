                
                             <?php
                             
       $tile = $this->input->post('title'); 
      $desc = $this->input->post('desc'); 
      $submit = $this->input->post('submit'); 
                             
          $link = mysqli_connect("localhost","tktktkt_dlcuser","dlcuser@123","tktktkt_dlc");
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL:" . mysqli_connect_error();
}


             /* $tile =    $_POST['title'];
              $desc =    $_POST['desc'];
              $submit =  $_POST['submit'];*/
      if($submit){
    $sql = "INSERT INTO dlc_notification (title,message) VALUES ('$tile', '$desc')";
     if(mysqli_query($link,$sql)){
       echo  $nnb = "<h6 style='color:red;'>Notification added successfully.</h6>";
       ?>
       <script type="text/javascript">
       window.location.href = "<?php echo base_url();?>Home";
       </script>
<?php
    } else {
        $sst =  "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
       
     mysqli_close($link);

// Enabling error reporting
    
      $links = mysqli_connect("localhost","tktktkt_dlcuser","dlcuser@123","tktktkt_dlc");
       
        require_once __DIR__ . '/newfcm/firebase.php';
        require_once __DIR__ . '/newfcm/push.php';
        
       
        $firebase = new Firebase();
        $push = new Push();

        // optional payload
        $payload = array();
        $payload['user_id'] = '1';
       
        // notification title
        $title = $tile  ;
        
        // notification message
        $message = $desc ;
        
        // push type - single user / topic
        $push_type = 'individual';
        
        $push->setTitle($title);
        $push->setMessage($message);
       
        //$push->setIsBackground(FALSE);
        $push->setPayload($payload);

        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
          
            $g_tkn = mysqli_query($links,"select * from dlc_tokens") ;
            while($mg_tkn = mysqli_fetch_array($g_tkn))
            { 
            $json = $push->getPush();
             $regId = $mg_tkn["token_name"];
            $response = $firebase->send($regId, $json); 
            }
            
        }

      }
                        

    ?>