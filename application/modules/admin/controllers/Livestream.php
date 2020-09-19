<?php
    if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Livestream extends MY_Admincontroller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Livestream_model');
        $this->load->model('My_common_model', 'mcm');   
   	    	
        $this->load->library('pagination');
		
		
		    $cntarray[0]=   (object) array('id'=>'video','name' => 'Video');		
			
			$cntarray[1]=   (object) array('id' => 'study_package','name' => 'Study Package');
			
			$cntarray[2]=   (object) array('id' => 'test_series','name' => 'Test Series');	
			
			$cntarray[3]=   (object) array('id' => 'notes','name' => 'Notes');			
			
			$cntarray[4]=   (object) array('id' => 'solved_paper','name' => 'Solved Paper');
			
			$cntarray[5]=   (object) array('id' => 'question_bank','name' => 'Question Bank');
			
			$cntarray[6]=   (object) array('id' => 'ncert_solution','name' => 'Ncert Solution');
       
        $this->data['contentArray'] = $cntarray;
    }

   /*==================jk function start =========================================*/
        ////////////////////////////////////////////////////////////////////////////////////////
                    // notifications masege
        //////////////////////////////////////////////////////////////////////////////////////////
        
        public function index_5(){
               
                     $data = $this->mcm->get_classes('categories');
                    // $data = $this->mcm->get_data('categories',[]);
                     
                     $arr = array();    
                     foreach($data as $val)
                     {
                         $arr [] = ['name'=> $val->name,'order'=>$val->order,'id'=>$val->id];
                     }
                       
                      // echo"<pre>"; print_r($arr); die();
             $dataTOsend = ['class_list'=> $arr];   
                     //  $this->load->view('index', $dataTOsend );
                   
                     $this->data['class_list'] = $arr;
                     $this->data['content'] = 'livestream/index';
                     $this->load->view('common/template', $this->data);
                    
                     }
        
     public function get_subject()
        {       
            $id = $this->input->post('order_id');
			if(empty($id))
			{
			    $dataTosend = ['status'=>false, 'msg' => 'something went wrong please try again','body'=>''];
				echo json_encode($dataTosend); die();
			}
			 $temp_v =   explode(',', $id) ;
			 $class_id = (count($temp_v)>0)? $temp_v[0] : "";
			 $order_id = (count($temp_v)>0)? $temp_v[1] : "";
			
				$wh =['order'=>$id];
            $q = "select * from cmssubjects where id in (SELECT subject_id FROM `cmschapter_details` WHERE `class_id` = '$class_id' and
                    sortorder = '$order_id' GROUP by subject_id)";
                $res = $this->db->query($q)->result();
		        
			if(count($res) > 0)
				{
					$dataTosend = ['status'=>true, 'msg' => ' Success','body'=>$res];
				       echo json_encode($dataTosend);
				}else{
					$dataTosend = ['status'=>false, 'msg' => 'Subject Not Availeble','body'=>''];
				echo json_encode($dataTosend);
						}
          
         }
          public function get_chapter()
        {       
            $class_id     = $this->input->post('class_id');   
            $subject_id   = $this->input->post('subject');   
			
            $q = "SELECT *  FROM `cmschapters` WHERE `id` in (SELECT chapter_id  FROM `cmschapter_details` WHERE 
                    `class_id` = '$class_id' AND `subject_id` = '$subject_id')";
                    
		$res =   $res = $this->db->query($q)->result();
			if(count($res) > 0)   
				{
					$dataTosend = ['status'=>true, 'msg' => ' Success','body'=>$res];
				       echo json_encode($dataTosend);
				}else{
					$dataTosend = ['status'=>false, 'msg' => 'Subject Not Availeble','body'=>''];
				echo json_encode($dataTosend);
						}
          
         }
          
    public function add_Meeting()
		{
			$data = $this->input->post();
		        
		       // echo"<pre>"; print_r($data); die();
		
		   
		          $title        =  $this->input->post('title');
		          $comments     =  $this->input->post('comment');
		          $subject      =  $this->input->post('subject');  
		          $chapter      =  $this->input->post('chapter');
		          $time         =  $this->input->post('time');	
           	      $hosted_by      =  $this->input->post('hosted_by');
           	       
		          $date         =  $this->input->post('date');
		          $my_class     =  $this->input->post('my_class');
		
	//	echo $time. " ==jk== ".$date  	; die();	
		
		if(empty($title) || empty($date) || empty($my_class)  || empty($time) || empty($chapter) || empty($subject) || empty($hosted_by) )
		{
		    	$dataTosend = ['status'=>false, 'msg' =>'All Field Required', 'body'=>''];
			            	echo json_encode($dataTosend); die();
		}
       
                     $temp_v =   explode(',', $my_class) ;
        			 $class_id = (count($temp_v)>0)? $temp_v[0] : "";
        			 $order_id = (count($temp_v)>0)? $temp_v[1] : "";
        			 
       
       
        if(isset($date))
		{	$arr = explode('/', $date );
			$date = $arr[2].'-'.$arr[1].'-'.$arr[0];		
		}
	    
	 
                /*========== meeting time validation start ==============*/   
                    
                    /* $whh = ['host_id'=>$host_id,'m_type' =>$type,'date'=>$date,'from_time'=>$from_time];
                                   $count_row =  $this->cm->get_data('meeting_tbl',$whh);
                     if(count($count_row))
                     {
                         $dataTosend = ['status'=>false, 'msg' =>'This time already meeting set','body'=>''];
                                   echo json_encode($dataTosend); die(); 
                         
                     }*/
                      
                  /*========== meeting time validation end ==============*/
                  
             // echo "<pre>"; print_r($_FILES['filename']); die();
                           $img_name =''; 
                    if(isset($_FILES['filename']))
                    {
                        $img_name = rand(1000,9999).$_FILES['filename']['name'];
                         $Path1 =  "assets/host_file/".$img_name; 
               			if(!move_uploaded_file($_FILES['filename']['tmp_name'],$Path1))
        				{      
        				    $img_name ="";
        				}
                    }
                  
      		$newdata = [ 
							'meet_name'     => $title,
							'class_id' 		=> $class_id,
							'order_id' 		=> $order_id,
							'time'      	=> $time,
							'chapter_id' 	=> $chapter,
							'subject_id'    => $subject,
							'description'   => $comments,
							'date'		    => $date,
							'image'         => $img_name,
							'hosted_by'     => $hosted_by,
							
						 ];     

				$res = $this->mcm->save_data ('meeting_tbl',$newdata);
				if($res)
				{       
				           $title1 = str_replace(' ', '+', $title);
				     
				         /*        $checksum = sha1("createallowStartStopRecording=true&attendeePW=123&autoStartRecording=false&meetingID=".$res."&moderatorPW=12345&name=".$title1."&record=true&welcome=Welcome+to+AI+LiveF6zvjud7xTCCqxJUd0R3j6mvJDSYefxU8AAClYgjo");
                                $url = "https://meet.ailive.in/bigbluebutton/api/create?allowStartStopRecording=true&attendeePW=123&autoStartRecording=false&meetingID=".$res."&moderatorPW=12345&name=".$title1."&record=true&welcome=Welcome+to+AI+Live&checksum=".$checksum;
				              */  
			            //  $checksum = sha1("createallowStartStopRecording=true&attendeePW=123&autoStartRecording=false&meetingID=".$res.
                             //        "&moderatorPW=12345&name=".$title1."&record=true&welcome=Welcome+to+studyaddatyyADgqyEIjYXIuPCQBG3x53ELpLC1SnSZRRQS93wx0");

                        // $url = "https://live.studyadda.com/bigbluebutton/api/create?allowStartStopRecording=true&attendeePW=123&autoStartRecording=false&meetingID=".$res."&moderatorPW=12345&name=".$title1."&record=true&welcome=Welcome+to+studyadda&checksum=".$checksum;   
                            $checksum = sha1("createallowStartStopRecording=true&attendeePW=123&autoStartRecording=false&meetingID=".$res.
                                     "&moderatorPW=12345&name=".$title1."&record=true&welcome=Welcome+to+studyaddaDHtLLUf5qV5nWed8C8HNsnZArMFjSFJwWrtpRRp4I3I");

                         $url = "https://stream.studyadda.com/bigbluebutton/api/create?allowStartStopRecording=true&attendeePW=123&autoStartRecording=false&meetingID=".$res."&moderatorPW=12345&name=".$title1."&record=true&welcome=Welcome+to+studyadda&checksum=".$checksum;
           
           
				 // echo $url; die();            
				                    
                           if ($this->mcm->send_url_internal_meeting_id($url,$res))
                            {
                                
                                
                                $dataTosend = ['status'=>true, 'msg' => 'Meeting Created  Successfully','body'=> ''];
                                    	echo json_encode($dataTosend); die();
                            }else{    
                                    $this->db->where('meet_id', $res);
                                    $this->db->delete('meeting_tbl');     
                                
                                    	$dataTosend = ['status'=>false, 'msg' =>'Meeting  Not Create','body'=>''];
			                     	echo json_encode($dataTosend); die();
                                }
                         
                          $dataTosend = ['status'=>true, 'msg' => 'Meeting Created  Successfully','body'=> ''];
                                    	echo json_encode($dataTosend); die();
                                    	
			                	
				}else{
					    	$dataTosend = ['status'=>false, 'msg' =>'Meeting  Not Create','body'=>''];
			            	echo json_encode($dataTosend);
						}
				
						
		}
      
            	public function upcoming_meetings()
				 {
					           $data = $this->mcm->get_classes('categories');
                                // $data = $this->mcm->get_data('categories',[]);
                                 
                                 $arr = array();    
                                 foreach($data as $val)
                                 {
                                     $arr [] = ['name'=> $val->name,'order'=>$val->order,'id'=>$val->id];
                                 }
                                   
                                  /// echo"<pre>"; print_r($arr); die();
                                         // $dataTOsend = ['class_list'=> $arr];
					      //  $this->load->view('upcoming_meeting',$dataTOsend);
					            
					              $this->data['class_list'] = $arr;
                                $this->data['content'] = 'livestream/upcoming_meeting';
                                $this->load->view('common/template', $this->data);
					    }
						
           public function show_upcoming_meetings()
		     {
		           $subject      =  $this->input->post('subject');  
		           $my_class     =  $this->input->post('my_class');
		
	        	if(empty($my_class)  || empty($subject))
                		{
                		    	$dataTosend = ['status'=>false, 'msg' =>'All Field Required', 'body'=>''];
                			            	echo json_encode($dataTosend); die();
                		}
       
                      $temp_v =   explode(',', $my_class) ;
        			 $class_id = (count($temp_v)>0)? $temp_v[0] : "";
        			 $order_id = (count($temp_v)>0)? $temp_v[1] : "";
        			  date_default_timezone_set('Asia/Kolkata');
                       // $time    = date("H:i");
                       
                        $to_d_date = date('Y-m-d');
        		
        			 $data = array();   
        			$q = "select a.image,a.meet_id,a.meet_name,a.date,a.time,a.description,b.name as class_name,c.name as sub_name,d.name as chap_name from meeting_tbl as a left join categories as b on a.class_id = b.id left join 
        			      cmssubjects as c on a.subject_id = c.id left join cmschapters as d on a.chapter_id = d.id where 
        			      a.class_id = '$class_id' and a.subject_id = '$subject' and a.date >= '$to_d_date' order by date desc "; 
        		
        		   
        		
                	$data =  $this->db->query($q)->result();
        	$arr = array(); $job = array();
        	    
        	 //   echo "<pre>"; print_r($data); die();    
        	        foreach($data as $val)
        	        {   
        	            $arr['meet_id'] = $val->meet_id;
        	            $arr['meet_name'] = $val->meet_name;
        	            $arr['date'] = date('d/F/Y', strtotime($val->date));
        	            $arr['time'] = $val->time;  
        	            $arr['description'] = $val->description;
        	            $arr['class_name'] = $val->class_name;
        	            $arr['sub_name'] = $val->sub_name;   
        	            $arr['chap_name'] = $val->chap_name;
        	            if(is_null($val->image)  || $val->image == "")
        	            {
        	                 $arr['image'] =  "";
        	            }else{
        	                 $arr['image'] =  base_url('assets/host_file').'/'. $val->image;
        	            }
        	            
        	            $job[] =$arr;
        	        }
        	    
                if(count($data) > 0)
                  {
                      	        $dataTosend = ['status'=>true, 'msg' =>'Success', 'body'=>$job];
                			            	echo json_encode($dataTosend); die();
                  }else{
                            	$dataTosend = ['status'=>false, 'msg' =>'No date found', 'body'=>''];
                			 	echo json_encode($dataTosend); die();
                         }
                    
		   }
      
      public function start_meeting()
      {
          $id = $this->input->post('meet_id');
          date_default_timezone_set("Asia/Kolkata");
            $today_date = date("Y-m-d");
          
          if(empty($id))
          {
              $dataTosend = ['status'=>false, 'msg' =>'meeting Id  Field Required', 'body'=>''];
                			 	echo json_encode($dataTosend); die();
              
          }
      
        $data = array();
        $data = $this->mcm->get_data('meeting_tbl',['meet_id'=>$id]);
        if(count($data)> 0)
            {
                $date = $data[0]->date;
                if($date == $today_date)
                {  
                    $send_url = $data[0]->create_url;
                    $name = $data[0]->hosted_by;
                    $name = is_null($name) ? "Studyadd teacher": $name;
                  $user_name = str_replace(' ', '+', $name);
                       
                   
                    if($this->mcm->send_url($send_url))
                    {   
                          $checksum = sha1("joinfullName=".$user_name."&meetingID=".$id."&password=12345&redirect=trueDHtLLUf5qV5nWed8C8HNsnZArMFjSFJwWrtpRRp4I3I");
 		                  $url_2 = "https://stream.studyadda.com/bigbluebutton/api/join?fullName=".$user_name."&meetingID=".$id."&password=12345&redirect=true&checksum=".$checksum; 
                     // $job = array();
                     // $job = ['meet_id' =>$id,'url'=>$url_2];
                 
                 
                      
                      $c = "$id.,.$url_2";
                      
                       
                      
                     $job =  base64_encode($c);
                    // $ww = base64_decode($job);
                     
                     // echo $ww. "<br><br>".$c; die();
                     
                      $dataTosend = ['status'=>true, 'msg' =>'Success', 'body'=>$job];
                			 	echo json_encode($dataTosend); die();
                        
                    }else{
                            $dataTosend = ['status'=>false, 'msg' =>'something went wrong please try again', 'body'=>''];
                			 	echo json_encode($dataTosend); die();
                            }
                    
                }else{
                           $dataTosend = ['status'=>false, 'msg' =>'This meeting date greater then current date', 'body'=>''];
                			 	echo json_encode($dataTosend); die(); 
                    }
            }else{
                        	$dataTosend = ['status'=>false, 'msg' =>'Invalid meeting id', 'body'=>''];
                			 	echo json_encode($dataTosend); die();
                }
      }    
      
      public function host_join_meeting()
        {
       
            $data = $this->input->get('url');
            
            
            $ex = base64_decode($data);
            
             
                     if(!strpos($ex,'.,.'))
                       { ?>
                                <script>
                                    alert("Invalid url for this meeting");
                                    window.location.href = "https://www.studyadda.com/admin/Livestream/upcoming_meetings";
                                        
                                </script>
                           <?php
                           
                       }
            
            $dd =  explode('.,.', $ex);
             
                $job = array();
                      $job = ['meet_id' =>$dd[0],'url'=>$dd[1]];
            
                $this->load->view('test/video_start_host', $job);
        }
      
        public function user_join_meeting()
            {
                $data = $this->uri->segment(3);  // segment
                $ex = base64_decode($data);
                $dd =  explode('.,.', $ex);
                
             //echo $ex ."<br><br>"; print_r($dd); die();      
                    
                    $job = array();
                          $job = ['meet_id' =>$dd[0],'url'=>$dd[1]];
                   $this->load->view('video_start_host',$job);
            }
        
        
        
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                            /*meeting quiz functions start*/ 
     ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     
    public function get_host_quiz() 
        {           
                    $host_id = $this->session->userdata('userid');   
            /*  [userid] => 11    
                [first_name] => Sumit
                [last_name] => Hariyani*/
            
            //  echo "<pre>";      print_r($_SESSION); die();
                    
                     $data = array();    
                        
                    /* $premium_user = $this->psm->check_premium_user('order_detail',$host_id);
                           
                     	 if( ($premium_user == false) && ( $this->psm->check_memory_space('meeting_tbl',$host_id)))    
                           {
            		        $dataTosend = ['status'=>false, 'msg' =>'purchase Premium services plan', 'body'=>''];   
                                    echo json_encode($dataTosend); die();    
            		     }*/
                        
                    $data = $this->mcm->get_data('quiz_test',['host_id'=>$host_id]);
            
                  if(count($data)>0)   
                    {
                        $dataTosend = ['status'=>true, 'msg' =>'Success', 'body'=>$data];
                                    echo json_encode($dataTosend); die();
                      }else{
                               $dataTosend = ['status'=>false, 'msg' =>'NO Quiz available', 'body'=>''];
                                    echo json_encode($dataTosend); die();
                       }
            
                } 
                  
     
       public function add_quiz_meeting()
        { 
                $id = $this->input->post('id'); 
                $meet_id = $this->input->post('meet_id'); 
                $host_id = $this->input->post('host_id'); 
                 
        
               
                 $this->mcm->update_data('quiz_test',['meet_id'=>$meet_id,'host_id'=>$host_id],['meet_id'=>'0']);
             
        
        
        
                $data = $this->mcm->update_data('quiz_test',['test_id'=>$id],['meet_id'=>$meet_id]);
        
              if($data)
                {
                    $dataTosend = ['status'=>true, 'msg' =>'Quiz add successfully ', 'body'=>''];
                                echo json_encode($dataTosend); die();
                }else{
                           $dataTosend = ['status'=>false, 'msg' =>'Quiz Not add ', 'body'=>''];
                                echo json_encode($dataTosend); die();
                   }
        
            }
      
      public function get_quiz_result_2()
        { 
             $meet_id = $this->input->post('meet_id'); 
              $host_id = $this->session->userdata('userid');   
      
          
        $qx = $this->mcm->get_data('quiz_test',['meet_id'=>$meet_id,'host_id'=>$host_id]);
       
      
        $id = (count($qx))? $qx[0]->test_id:'';
        
     $dq = $this->mcm->get_data('question_table',['test_id'=>$id]);
      $question = count($dq) ; 
       
       $qs = "SELECT user_id FROM `quiz_anser_tbl`  where  meet_id ='$meet_id' and quiz_test_id ='$id' GROUP BY user_id";
    
     $res = $this->db->query($qs)->result_array();
    
     	$arr= array(); $job = array();
      	   
      
      	foreach ($res as $val) 
      	{
      		$dx = array();
		        $dx = $this->mcm->get_data('cmscustomers',['id'=>$val['user_id'] ]);
		          $arr['user_name'] = (count($dx))? $dx[0]->firstname : "" ;    
		          $arr['user_id'] = $val['user_id']; 

        $dz = $this->mcm->get_data('quiz_anser_tbl',[ 'meet_id'=>$meet_id,'user_id'=>$val['user_id'],'ans_status'=>'1' ,'quiz_test_id'=>$id]);
          $ans = (count($dz))? count($dz) : '0';
		      
	
	 $qr = ($question == '0')? 1: $question;
         $arr['percent'] = (round((($ans*100)/$qr),2))? round((($ans*100)/$qr),2).'  %' : "0  %";
              
                  
   			
   				$job[] = $arr;     
     	}

          if(count($job) > 0)
	          {
	              $dataTosend = ['status'=>true, 'msg' =>'success', 'body'=>$job];
	                echo json_encode($dataTosend); die();
	           
	            }else{
	                    $dataTosend = ['status'=>false, 'msg' =>'No data for this Quiz..', 'body'=>''];
	                      echo json_encode($dataTosend); die();
	                  }         

	      }
	    
	    public function add_assessment()
	        {
	             $this->data['content'] = 'livestream/add_quiz';
                     $this->load->view('common/template', $this->data);
	        }
	   
	       public function add_test()   
               {     
                          $ussid = $this->session->userdata('userid');   
        
                         /* echo "jk == ".$ussid ;
                           echo "<br>"; print_r($this->input->post());
                           die();*/
                           
                           $chhk = $this->input->post('chk_time');
                           if($chhk == '1'){
                          
                          $data = array('test_name'=>$this->input->post('test_name'),
                                        'test_type'=>$this->input->post('q_type'),
                                        'time_value'=>$this->input->post('chk_time'),
                                        'time_limit'=>$this->input->post('tm'),
                                        'host_id'=>$ussid
                             );
                                 } else {
                    
                        $data = array('test_name'=>$this->input->post('test_name'),
                                        'test_type'=>$this->input->post('q_type'),
                                        'time_value'=>'0',
                                        'time_limit'=>'0',
                                        'host_id'=>$ussid
                                     );
                    
                                 }
                     
                        $res = $this->mcm->save_data ('quiz_test',$data);
                            if($res)
                            {
                                $dataTosend = ['status'=>true, 'msg' => 'Quiz Add Successfully','body'=>$res];
                    				echo json_encode($dataTosend);
                            }else{
                                  $dataTosend = ['status'=>false, 'msg' => 'Quiz Not Inserted!...','body'=>''];
                    				echo json_encode($dataTosend);
                            }
             }
       
        public function q_and_ans_add()
             {   
                 $host_id =  $this->session->userdata('userid');
                 $q_name = $this->input->post('qsn');
                 $test_id = $this->input->post('test_id');  
                 $ans_opt = $this->input->post('ans_opt');          
                $opt = array();
                 $opt = $this->input->post('rdx');
             /*===========================validation form start =================================*/
                $check_opt = false;
                $q_name_check = (empty(trim($q_name)))? true : false;
                
                foreach($opt as $val)
                {
                    if(empty(trim($val)))
                    {        
                        $check_opt = true;
                        break;
                    }    
                }
                      if($q_name_check ) 
                        {
                            $dataTosend = ['status'=>false, 'msg' => ' Question is Blank ','body'=>''];
            				echo json_encode($dataTosend);  die();
                        }
                 if($check_opt ) 
                    {
                        $dataTosend = ['status'=>false, 'msg' => ' options is Blank ','body'=>''];
            			echo json_encode($dataTosend);  die();
                    }
            /*===========================validation form end =================================*/
            
                 
              
               $q_id = $this->mcm->save_data ('question_table',['question'=> trim($q_name),'test_id'=>$test_id,'host_id'=>$host_id]);
                
                 if(!(is_numeric($q_id)))
                     {    
                        $dataTosend = ['status'=>false, 'msg' => 'Question Not Inserted ','body'=>''];
            				echo json_encode($dataTosend);  die();
                     }
                 $res = true;   
                 for($i = 0;$i< count($opt);$i++)   
                 {   
                     if($i == $ans_opt )
                        {
                          $opt_id = $this->mcm->save_data ('answer_table',['options'=> trim($opt[$i]),'status'=>'1','question_id'=>$q_id]);
                          
                        }else{    
                              $opt_id = $this->mcm->save_data ('answer_table',['options'=> trim($opt[$i]),'question_id'=>$q_id]);
                             }
                        
                        if(!(is_numeric($q_id)))
                            {
                                $res = false;
                                 break; 
                            }
                    } 
                 if($res)
                 {
                     $dataTosend = ['status'=>true, 'msg' => 'success','body'=>''];
        				echo json_encode($dataTosend);
        	    	}else{
        					$dataTosend = ['status'=>false, 'msg' => 'No data Available ','body'=>''];
        				echo json_encode($dataTosend);
        						}
        		
                 
                 
                 
             }     
        
      public function get_question_list()
         {
                $test_id = $this->input->post('test_id');
                
                $dx = $this->mcm->get_data('question_table',['test_id'=>$test_id]);
            
                if(count($dx)>0)
                {
                     $dataTosend = ['status'=>true, 'msg' => 'Success','body'=> $dx];
    			    	echo json_encode($dataTosend);
                }else{
                             $dataTosend = ['status'=>false, 'msg' => 'no data Availeble','body'=>''];
    				        echo json_encode($dataTosend);
                        }
      
      
             }    
       /*===================jk function end ======================================*/
 
    public function index($page = 0) {
            //       * *** pgination _categories***  
        $config = array();
        $config["base_url"] = base_url() . "admin/livestream/index/";
        $config["total_rows"] = $this->Livestream_model->getMediaCount();
        $config["per_page"] = $this->config->item('records_per_page');
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;
        $config['first_link'] = '&lsaquo; First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &rsaquo;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        //$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;                

        $this->data["links"] = $this->pagination->create_links();
        $this->data['media'] = $this->Livestream_model->getcontent();
		$this->load->model('Examcategory_model');
        $this->data['media_array'] = $this->Livestream_model->getmedia();      
        $this->data['content'] = 'livestream/index_2';
        $this->load->view('common/template', $this->data);
    }

    public function add() { 
		$exams = $this->Examcategory_model->getAdminExamCatgeories();
        $this->data['exams'] = $exams;
        $this->data['content'] = 'livestream/add';
        $this->load->view('common/template', $this->data);
    }

     public function submitadd() {
         
          $imagefolder_path = '/assets/images/';
          $title = $this->input->post('title');         
          $description = $this->input->post('description');       
          $class_id = $this->input->post('class_id');	          
          $date = $this->input->post('date');
          $noti_type= $this->input->post('noti_type');		  
if(isset($date)&&$date!=''){
	 $date = $this->input->post('date');
}else{
	$date = date("F j, Y"); 
}		  
          $content_type = $this->input->post('content_type');		            
          $packageid = $this->input->post('packageid');
		
         $media_data = array(
            'title' => $title,
            'description' => $description,
			'class_id' => $class_id,
            'content_type' => $content_type,
            'packageid' => $packageid,
			'notitype'=>$noti_type,
            'date' => $date
        );
         
        $this->Livestream_model->createMedia($media_data);         
        $this->session->set_flashdata("message","Information Added Successfully.");
        redirect('admin/notification');
    }
    
     public function edit($media_id) {   
          /*         * *** pgination _categories***   */
        $config = array();
        $config["base_url"] = base_url() . "admin/livestream/index/";
        $config["total_rows"] = $this->Livestream_model->getMediaCount();
        $config["per_page"] = $this->config->item('records_per_page');
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;
        $config['first_link'] = '&lsaquo; First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &rsaquo;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        //$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;                

		$exams = $this->Examcategory_model->getAdminExamCatgeories();
        $this->data['exams'] = $exams;
        $this->data["links"] = $this->pagination->create_links();
        $this->data['media'] = $this->Livestream_model->getcontent();
            $mediaResult = $this->Livestream_model->getMediaById($media_id);
            $this->data['mediaResult']=$mediaResult;
            $this->data['content'] = 'livestream/edit';
            $this->load->view('common/template', $this->data);         
     }
     public function submitedit(){
          $imagefolder_path = '/assets/images/';
          $id = $this->input->post('id'); 
          $title = $this->input->post('title');         
          $description = $this->input->post('description');          
          $date = $this->input->post('date');
		  $class_id = $this->input->post('class_id');		  
		  $noti_type = $this->input->post('noti_type');
		  
		  
		  if(isset($date)&&$date!=''){
	 $date = $this->input->post('date');
}else{
	$date = date("F j, Y");
}	
          $content_type = $this->input->post('content_type');
          $packageid = $this->input->post('packageid');          
          $imagename = media_image_upload($imagefolder_path,'mediaimage');       
       
         if($imagename=='failed'){
             $images=$image;
         }else{
             $images=$imagename;
         }
         
         //Big Image
         $imagename_big = media_image_upload($imagefolder_path,'mediaimage_big');       
       
         if($imagename_big=='failed'){
             $images_big=$image_big;
         }else{
             $images_big=$imagename_big;
         }
         $media_data = array(
            'title' => $title,
            'description' => $description,
            'class_id' => $class_id,            
            'content_type' => $content_type,
            'packageid' => $packageid,
			'notitype'=>$noti_type,
            'date' => $date
        ); 
        $this->Livestream_model->editMedia($media_data,$id);
        $this->session->set_flashdata("message","Information Updated Successfully.");
        redirect('admin/livestream/edit/'.$id);
         
     }
     
     public function delete($id){
        $this->Livestream_model->deleteMedia($id);
        $this->session->set_flashdata("message","Information Deleted Successfully.");
        redirect('admin/notification');
     }
	 
     public function notify($id){
        $mediaResult = $this->Livestream_model->getMediaById($id);		
		$selectedclass=$mediaResult->class_id;
		if(isset($selectedclass)&&$selectedclass>0){
		$selectedclass=$mediaResult->class_id;
		}else{
		$selectedclass=0;
		}
		
		if(isset($mediaResult->title)){
		$title=$mediaResult->title;		
				}else{
					$title='Hello';
				}
				if(isset($mediaResult->description)){
		$description=$mediaResult->description;
				}else{
		$description='student';
				}
		$notifyInfoArray = $this->Livestream_model->getStudentByClassId($selectedclass);
		if(is_array($notifyInfoArray)){
		foreach($notifyInfoArray as $fireid){
		$url=base_url()."notify/?regId=".$fireid."&title=".$title."&message=".$description."&push_type=individual";

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $contents = curl_exec($ch);
 //echo $contents;
		sleep(3); die;
		}
		die;
        $this->session->set_flashdata("message","Information Sent Successfully.");
		}else{
			
        $this->session->set_flashdata("message","Information Not Found!");
		}
		
		
		
        //$this->Livestream_model->notify($id);
         redirect('admin/notification');
     }
	 
	 
    

}

?>
