<?php
         
        //	header("Content-Type: application/json");

     $conn=mysqli_connect("localhost","studywhm_study","Study1dd1","studywhm_stdproduction");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  } 
        
                //send_meet_notification_count_tbl
                          date_default_timezone_set('Asia/Kolkata');
                          $t_date = date('Y-m-d H:i:s');
                        $night_time = date('H:i');   
             
                
                
              $qx = "insert into send_meet_notification_count_tbl(date) value('$t_date')";
                     mysqli_query($conn,$qx); 
                     
                    $DateTime = new DateTime();   
				        
				   $DateTime->modify('+2 hours');
                  $date =  $DateTime->format("Y-m-d"); 
				 
                       $time    = $DateTime->format("H:i");
                     
                     //$time    = '20:00';
                     
                     //$my_msg = "Pack your bags, {title} live class begins in 2 hours.";
                      
                      $my_msg = "Watch {title} live  in 2 hours.";
                     
                      $res1  =   class_all_students_fun($conn,$date,$time,$my_msg) ;  
                       
                     // two condition   
                      /*  $date_2 = date('Y-m-d');
                             $current_date = date('Y-m-d H:i:s');
                         $time_2 = date(" H:i",strtotime("+30 minutes", strtotime($current_date))); 
                          $my_msg = "Watch {title} live in 30 minutes.";
                          $res2 =  class_all_students_fun($conn,$date_2,$time_2,$my_msg) ;*/
            
               // three condition	  
                      	   $test_date_3 = new DateTime();   
                      	        
                             $date_3 =  $test_date_3->format("Y-m-d"); 
				            $time_3    = $test_date_3->format("H:i");
                           $my_msg = "Watch {title} live now.";
                    
                       $res3 =   class_all_students_fun($conn,$date_3,$time_3,$my_msg) ;
                   
           $SENDTODATA = ['res1'=>$res1,'res3'=>$res3];
             $dataTosend = [ 'status'=>true,'msg'=>'Success','body'=>$SENDTODATA];
                       echo json_encode($dataTosend); die();
           
            function my_custom_notificaction_fun($conn,$date,$time,$my_msg) 
                {
                    $q = "select a.user_id,b.class_id,b.url_type,b.meet_name,b.image,b.description,b.date,b.time from meeting_notification_tbl as a join meeting_tbl as b on a.meet_id = b.meet_id where b.date = '$date' and time = '$time'";
                                $result = mysqli_query($conn,$q);
                             $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
                       
                      $sub = array();
                    
                    foreach($data as $val)
                        {
                            $user_id     = $val['user_id'];
                            $meet_name   = $val['meet_name'];
                            $image       = ($val['image']) ?  "https://www.studyadda.com/assets/host_file/".$val['image'] : "" ;
                            $description = $val['description'];
                            $class_id    = $val['class_id'];
                            $url_type    = $val['url_type'];
                            
                             $condition = ['user_id'=>$user_id];
                            $token_res =  get_data($conn,$condition,'user_tokens');
                            
                          //  echo "<pre>"; print_r($token_res); die();
                            
                              $fruit = array_pop($token_res);
                                            
                                             $tokens =  $fruit['token_name'];           
                                         $tok =  $fruit['token_id'];          
                 					  
                                               $tokens = array($tokens);     
                                 $my_msg      =   str_replace("{title}", $meet_name ,$my_msg);
                                 
                                 
                           $sub[] =  push_notification_android($tokens,$meet_name,$my_msg,$class_id,$url_type,$tok,$image);    
                      }
                     return   $sum =  count($sub); 
                }     
            
            
            function clean($post_name) {
               $name = trim($post_name);
               $post_name = str_replace(' ', '', $name); 
               return preg_replace('/[^A-Za-z0-9\-]/', '', $post_name);
            }
            
            
            
          function get_data($con,$condition,$tbl)
                     {
                        
                         $where ="";
                          
                         foreach($condition as $key => $val)
                         {
                              $where .= "$key= '$val' and ";
                           }   
                         $abc = substr($where,0,-4);
                        
                           if($abc)
                           {
                                $q = "select * from $tbl  where $abc ";
                            }else{
                                   $q = "select * from $tbl ";
                                 }
                
                            $result = mysqli_query($con,$q);
                         $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
                         
                         return $data;   
                     }  
       
         function push_notification_android($tokens,$title,$msg,$exam_id,$type,$id,$image,$meet_name_spl)
            {
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $api_key = 'AAAAIVmGV8Y:APA91bHkI6zYMCqxo14P4--xh5Fjr36gi6Z1_vk8p9Zm-ituhRT9qJYfOKRPIzt-LTkJMJ8JuBEScDKgqpzZfMiFnAhBZ_nu7c6VNYQg2ut7XfKCcsXuhnva-nNHe2c23ZYAeLXmlwSX';
                    $messageArray = array();
                    $messageArray["notification"] = array (
                        'title' => $title,
                        'meet_name_spl' => $meet_name_spl,
                        'message' => $msg,
                        //'customParam' => $customParam,
                        'exam_id' => $exam_id,
                        'type' => $type,
                        'id' => $id,
                        'image'=>$image,
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
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    $result = curl_exec($ch);
                   
                    curl_close($ch);
                    return true;
                    }
        
        
        /*============= select class  all student send notification function */
     function class_all_students_fun($conn,$date,$time,$my_msg)            
       {
         
          $q = "select * from meeting_tbl where date ='$date' and time = '$time' GROUP by class_id ";
       
              mysqli_set_charset( $conn, 'utf8');
              $result = mysqli_query($conn,$q);  
              
              $data = mysqli_fetch_all($result,MYSQLI_ASSOC);      
                       
                      $sub = array();
                    
                    foreach($data as $val)
                        {
                            
                            $meet_name   = $val['meet_name'];
                            $image       = ($val['image']) ?  "https://www.studyadda.com/assets/host_file/".$val['image'] : "" ;
                            $class_id    = $val['class_id'];
                            $url_type    = $val['url_type'];
                            $meet_id     = $val['meet_id'];
                            $my_msg      =   str_replace("{title}", $meet_name ,$my_msg);
                            $meet_name_spl = clean($meet_name);
                            
                            $sub[]       =  all_users_send($conn,$meet_name,$my_msg,$class_id,$url_type,$meet_id,$image,$meet_name_spl);   
                          
                            $meet_name = "";$image ="";$class_id = "";$url_type ="";$meet_id = "";
                            
                        }
                        
                    return   $sum =  count($sub); 
       }  
       
     function all_users_send($conn,$meet_name,$my_msg,$class_id,$url_type,$meet_id,$image,$meet_name_spl)            
       {
                $q1 = "SELECT c.user_id  FROM cmspricelist as a join cmsorder_details as b on a.id = b.product_id join cmsorders as c 
               on b.order_id = c.id WHERE a.exam_id = '$class_id' and a.subject_id = '0' AND  a.chapter_id = '0' and a.item_id = '0'";
             
                      $result_1 = mysqli_query($conn,$q1);
                      $a1       = mysqli_fetch_all($result_1,MYSQLI_ASSOC);
                  
                   $q2 = "select id from cmscustomers where subject_id = '$class_id'";
                       $result_2 = mysqli_query($conn,$q2);
                      $a2       = mysqli_fetch_all($result_2,MYSQLI_ASSOC);
                        
                                $b1 = array(); $b2 = array();
                          foreach($a1 as $val) { $b1[] = $val['user_id']; }
                          foreach($a2 as $val) { $b2[] = $val['id']; }
                  
                     
                      $all_users = array_unique(array_merge($b1,$b2));
                      $all_users_str = ($all_users)? implode(',', $all_users) : 0;
                      
                       $all_users_count = count($all_users);
                 
                   $my_count =  ceil($all_users_count/1000);    
                  
                      $jobs = array();
              
                 for($i=0; $i< $my_count ; $i++)  
                 {     
                   
                       $my_l_id = 1000* $i;
                  
                  $qq = "SELECT token_name FROM user_tokens  WHERE  user_id in ($all_users_str) LIMIT 1000 OFFSET $my_l_id ";
                                    
                        $result = mysqli_query($conn,$qq);
                      $data   = mysqli_fetch_all($result,MYSQLI_ASSOC);
                               
                      $sub = array();  $tokens = array();  
                    
                    foreach($data as $val)
                        {
                            $tokens[]  = $val['token_name'];
                        }  
           
             /* $tokens = ["fdtTgR4WWGU:APA91bFBXB3rJbR0K2n7sbMlb1aPCVt0aSN9JcVG4rqGt-DGq-Z_3mZMYWWsJARsE1xYz3rxT_CaV4MQm6kULtDREzPUSx40YNX2hK-n_44H20cswideIV3-_TzyiUiOo9dcdppbojZ8",
    "dEXbIzQGRwo:APA91bHn2wFJH1v9hmsGA8Aw8tYz6EU8ymxqBlp5_cAfdEiMTGmP7pjYnt8MQgdyel1mQXekSTk48IOrUz-Q0oMA6IgDoZNHKNqLOZHCHvJ9oubCDXHqrfn6Z4OwGascldftdmyj3eN6"];
            */
             
                      $sub[] =  push_notification_android($tokens,$meet_name,$my_msg,$class_id,$url_type,$meet_id,$image,$meet_name_spl);       
                                
                 } 
                          
          
                   return $sum = count($sub);
         
       }
    mysqli_close($conn);     
    
    
    
    
    
    
    