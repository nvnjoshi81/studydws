<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends MY_Controller {
    public function __construct() {
        parent:: __construct();
         $this->load->model('Meating_model');
           $this->load->model('My_common_model', 'mcm');   
    }
  /*  public function index(){       
    $this->data['content']='welcome';               
	$this->load->view('template',$this->data);
    }*/
    
    public function index()
    {
        $data = $this->input->get('url');
            $ex = base64_decode($data);
            $dd =  explode('.,.', $ex);
            
         //echo $ex ."<br><br>"; print_r($dd); die();      
                
                $job = array();
                      $job = [ 'user_id'=>$dd[0],'meet_id' =>$dd[1],'url'=>$dd[2]];
          
        
         $this->load->view('test/video_start_users',$job);
    }
    	 public function get_more_quiz_test()
         {
                $meet_id = $this->input->post('meet_id');   
                $q_no = $this->input->post('question_no');
                 $q_no = ($q_no)? $q_no: 0;    
                $u_id = $this->input->post('u_id');
                 
                
               	 $dx = array();
          
                      $dx = " select count(*) as coun from quiz_anser_tbl  where user_id = '$u_id' and meet_id ='$meet_id' and
                        quiz_test_id in (select test_id from  quiz_test where meet_id ='$meet_id') ";
                   
                
                  $res =  $this->db->query($dx)->result();
                 //print_r($res); die();
                 $res_res = (count($res)) ?$res[0]->coun : 0;
               if($res_res == 0)    
                  {
                          $dd = $this->mcm->get_data('quiz_test',['meet_id'=>$meet_id]);
                                              $job = array();
                                        if(count($dd)>0)
                                          {
                                            $send_data = array(); 
                                    
                                            foreach ($dd as $val) {
                                              
                                              $send_data['test_name'] = $val->test_name ;
                                              $send_data['test_type'] = $val->test_type;
                                              $send_data['time_limit'] = $val->time_limit;
                                              $send_data['test_id']    = $val->test_id;
                                                  
                                                     $test_id = $val->test_id; 
                                    
                                            if($val->test_type == 'Objective')
                                                {
                                                 
                                                  $sd  =  $this->mcm->get_data('question_table',['test_id'=>$test_id]);
                                                   
                                                    $arr = array(); $k = 0;
                                                    foreach ($sd as $vall) { 
                                    
                                                            $arr['question'] =$vall->question ; 
                                                            $arr['question_id'] =  $question_id =  $vall->question_id ;   
                                                       
                                                        $sdd = $this->mcm->get_data('answer_table',['question_id'=>$question_id]);
                                                      
                                                         foreach ($sdd as $lue)
                                                          {
                                                             $random = ['option_name'=>$lue->options , 'option_id'=>$lue->answer_id];
                                                             $arr['option'][] = $random;
                                                         }
                                    
                                                         if($k == $q_no)
                                                         {
                                                          $send_data['data_2'][]= $arr;
                                                         }
                                                      $k++;
                                    
                                                    $arr['option'] = [];
                                    
                                                }
                                                 
                                                    $send_data['q_count'] = count($sd);
                                    
                                                  $job = $send_data;
                                            }
                                          }
                                    
                                            //echo "<pre>"; print_r($job); die();
                                              if(count($job) > 0)
                                              {
                                    
                                                  $dataTosend = ['status'=>true, 'msg' =>'success', 'body'=>$job];
                                                    echo json_encode($dataTosend); die();
                                                }else{
                                                        $dataTosend = ['status'=>false, 'msg' =>'No data for this meeting..', 'body'=>''];
                                                          echo json_encode($dataTosend); die();
                                                      }
                                    
                                        }else{
                                    
                                             $dataTosend = ['status'=>false, 'msg' =>'false', 'body'=>''];
                                                    echo json_encode($dataTosend); die();
                                       
                                        }
                  }else{
                             $dataTosend = ['status'=>false, 'msg' =>'false', 'body'=>''];
                              echo json_encode($dataTosend); die();
                         } 
       
         } 
         
         
    public function get_quiz_test()
         {
        $meet_id = $this->input->post('meet_id');
        $q_no = $this->input->post('question_no');
        $q_no = ($q_no)? $q_no: 0;
        $dd = $this->mcm->get_data('quiz_test',['meet_id'=>$meet_id]);
              $job = array();
        if(count($dd)>0)
          {
            $send_data = array(); 
    
            foreach ($dd as $val) {
              
              $send_data['test_name'] = $val->test_name ;
              $send_data['test_type'] = $val->test_type;
              $send_data['time_limit'] = $val->time_limit;
              $send_data['test_id']    = $val->test_id;
                  
                     $test_id = $val->test_id; 
    
            if($val->test_type == 'Objective' )
                {
                 
                  $sd  =  $this->mcm->get_data('question_table',['test_id'=>$test_id]);
                   
                    $arr = array(); $k = 0;
                    foreach ($sd as $vall) { 
    
                            $arr['question'] =$vall->question ; 
                            $arr['question_id'] =  $question_id =  $vall->question_id ;   
                       
                        $sdd = $this->mcm->get_data('answer_table',['question_id'=>$question_id]);
                      
                         foreach ($sdd as $lue)
                          {
                             $random = ['option_name'=>$lue->options , 'option_id'=>$lue->answer_id];
                             $arr['option'][] = $random;
                         }
    
                         if($k == $q_no)
                         {
                          $send_data['data_2'][]= $arr;
                         }
                      $k++;
    
                    $arr['option'] = [];
    
                }
                 
                    $send_data['q_count'] = count($sd);
    
                  $job = $send_data;
            }
          }
    
            //echo "<pre>"; print_r($job); die();
              if(count($job) > 0)
              {
    
                  $dataTosend = ['status'=>true, 'msg' =>'success', 'body'=>$job];
                    echo json_encode($dataTosend); die();
                }else{
                        $dataTosend = ['status'=>false, 'msg' =>'No data for this meeting..', 'body'=>''];
                          echo json_encode($dataTosend); die();
                      }
    
        }else{
    
             $dataTosend = ['status'=>false, 'msg' =>'false', 'body'=>''];
                    echo json_encode($dataTosend); die();
       
        }
    
    
    }
    public function get_q_potion()
        { 
        $test_id = $this->input->post('test_id'); 
        $q_id = $this->input->post('q_id'); 
        $opt = $this->input->post('opt'); 

       
        $usr_id = $this->input->post('usr_id'); 
        $meet_id = $this->input->post('meet_id'); 
                
                          
      
       $dx = $this->mcm->get_data('quiz_anser_tbl',['meet_id'=>$meet_id,'q_id'=>$q_id,'quiz_test_id'=>$test_id,'user_id'=>$usr_id]) ;
       
       
         $q_status = $this->mcm->get_data('answer_table',['question_id'=>$q_id,'options'=>$opt]);             
         $status = (count($q_status))? $q_status[0]->status :"0";
      
        if(count($dx)>0)
          {   
              $option = $dx[0]->option_name;
            
                      $dataTosend = ['status'=>true, 'msg' =>' Success', 'body'=>$option];
                        echo json_encode($dataTosend); die();

          }else{
                   $dataTosend = ['status'=>false, 'msg' =>'NO option', 'body'=>''];
                        echo json_encode($dataTosend); die();
          }

      }
    public function get_host_quiz()   
        {           
        $host_id = $this->input->post('host_id');    
        $meet_id = $this->input->post('meet_id');    
         $data = array();    
            
         /*$premium_user = $this->psm->check_premium_user('order_detail',$host_id);
               
         	 if( ($premium_user == false) && ( $this->psm->check_memory_space('meeting_tbl',$host_id)))    
               {     
		        $dataTosend = ['status'=>false, 'msg' =>'purchase Premium services plan', 'body'=>''];   
                        echo json_encode($dataTosend); die();    
		     }*/
            $q = "SELECT a.*,b.meet_id as new_mid FROM `quiz_test` as a  left join quiz_anser_tbl as b on b.quiz_test_id = a.test_id  and 
                        b.meet_id = '$meet_id' WHERE host_id ='$host_id' GROUP by a.test_name ORDER by a.test_id desc" ;
                    
            $data = $this->db->query($q)->result();
       // $data = $this->cm->get_data('quiz_test',['host_id'=>$host_id]);
         
           // echo "<pre>"; print_r($data); die();    
    
      if(count($data)>0)   
        {
            $dataTosend = ['status'=>true, 'msg' =>'Success', 'body'=>$data];
                        echo json_encode($dataTosend); die();
        }else{
                   $dataTosend = ['status'=>false, 'msg' =>'NO Quiz available', 'body'=>''];
                        echo json_encode($dataTosend); die();
           }

    } 
      
    public function add_quiz_test_question()
      { 
        $test_id = $this->input->post('test_id'); 
        $q_id = $this->input->post('q_id'); 
        $opt = trim($this->input->post('opt')); 
          $usr_id = $this->input->post('usr_id'); 
       
         $meet_id = $this->input->post('meet_id'); 
     
       $dx = $this->mcm->get_data('quiz_anser_tbl',['meet_id'=>$meet_id,'q_id'=>$q_id,'quiz_test_id'=>$test_id,'user_id'=>$usr_id]) ;
      
       
         $q_status = $this->mcm->get_data('answer_table',['answer_id'=>$opt]);             
         $status = (count($q_status))? $q_status[0]->status :"0";
      
        if(count($dx)>0)
          {   
              $qa_id = $dx[0]->qa_id;

             $this->mcm->update_data('quiz_anser_tbl',['qa_id'=>$qa_id],['option_name'=>$opt,'ans_status'=>$status]);

             $dataTosend = ['status'=>true, 'msg' =>'Updete data Successfully', 'body'=>''];
                        echo json_encode($dataTosend); die();

          }else{
           
                  $save_data = '';
                  
                    $save_data =  $this->mcm->save_data('quiz_anser_tbl',['q_id'=>$q_id,'quiz_test_id'=>$test_id,'option_name'=>$opt,'user_id'=>$usr_id,'ans_status'=>$status,'meet_id'=>$meet_id]);
                     

                      if($save_data)    
                      {
                         $dataTosend = ['status'=>true, 'msg' =>'data inserted Successfully', 'body'=>''];
                        echo json_encode($dataTosend); die();
                      
                      }else{
                              $dataTosend = ['status'=>false, 'msg' =>'data not inserted','body'=>''];
                                echo json_encode($dataTosend); die();
                           }

                  }

    }   
    public function show_user_quiz_res()
        {
    
      $u_id = $this->input->post('u_id');
      $test_id = $this->input->post('test_id');
      $meet_id = $this->input->post('meet_id');
       $dx = array();
           
            $this->mcm->update_data('quiz_anser_tbl',['meet_id'=>$meet_id,'user_id'=>$u_id],['end_quiz'=>'1']); 
            
          $dz = $this->db->query("select quiz_test_id from quiz_anser_tbl where user_id= '$u_id' and end_quiz = '1' and meet_id= '$meet_id' GROUP by quiz_test_id")->result();
         
             $job = array();
            foreach($dz as $val)
            {
                $quiz_test_id = $val->quiz_test_id;
                        
                          $dx = $this->mcm->get_data('quiz_anser_tbl',['user_id'=>$u_id,'ans_status'=>'1','meet_id'=>$meet_id,'quiz_test_id'=>$quiz_test_id]);
                         
                       
                      $ans = (count($dx))? count($dx) : '0';
                   
             $qqq = $this->mcm->get_data('quiz_test',['test_id'=>$quiz_test_id]);
                      
                         $test_name = (count($qqq))? $qqq[0]->test_name :""; 
                    
                     //$test_id = (count($dx))? $dx[0]->quiz_test_id:'';     
                              $dq = array();
                            $dq = $this->mcm->get_data('question_table',['test_id'=>$quiz_test_id]);
                      $question = count($dq);        
                        $qr = ($question == '0')? 1: $question;
                      
                      $percent = (round((($ans*100)/$qr),2))? round((($ans*100)/$qr),2).'  %' : "0  %";  
                       
                       
                        $job[] = ['test_name'=>$test_name,'percent'=>$percent,'test_id' =>$test_id];
                        }
                    
                          $dataTosend = ['status'=>true, 'msg' =>'success', 'body'=>$job];
                                echo json_encode($dataTosend); die();
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
    /*===========================*/
    public function get_quiz_result()
     { 
        $id = $this->input->post('id'); 
        
        $host_id = $this->input->post('host_id'); 
         
     $dq = $this->mcm->get_data('question_table',['test_id'=>$id]);
      $question = count($dq) ; 
       
      $qs = "SELECT user_id, user_type,guest_r_id FROM `quiz_anser_tbl`  WHERE quiz_test_id ='$id' and end_quiz ='1' GROUP BY user_id,guest_r_id";



      $res = $this->db->query($qs)->result_array();
      
      

      	$arr= array(); $job = array();
      	
      //	echo "<pre>"; print_r($res); die();

      	foreach ($res as $val) 
      	{
      		
          

        if($val['user_type'] == "login_user")  
        {
        	$dx = array();
		          $dx = $this->mcm->get_data('user_tbl',['user_id'=>$val['user_id'] ]);
		          $arr['user_name'] = (count($dx))? $dx[0]->user_name : "" ; 
		          $arr['user_id'] = $val['user_id']; 

        $dz = $this->mcm->get_data('quiz_anser_tbl',['user_id'=>$val['user_id'],'ans_status'=>'1']);
          $ans = (count($dz))? count($dz) : '0';
		      
		}else{
		      	$dy = array();
		      $dy = $this->mcm->get_data('guest_user_tbl',['guest_id'=>$val['guest_r_id']]);

		        $arr['user_name'] = (count($dy))? $dy[0]->fname.' '.$dy[0]->lname : ""; 
      			$arr['user_id'] = $val['guest_r_id']; 

      $dz = $this->mcm->get_data('quiz_anser_tbl',['guest_r_id'=>$val['guest_r_id'],'ans_status'=>'1']);
          $ans = (count($dz))? count($dz) : '0';



       		 }    
     
      			   
      			
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
  
    public function get_quiz_result_2()
        { 
        $meet_id = $this->input->post('meet_id'); 
        $host_id = $this->input->post('host_id'); 
        $id = $this->input->post('test_id'); 
    
    
        $qx = $this->mcm->get_data('quiz_test',['test_id'=>$id]);
       
        $test_name = (count($qx))? $qx[0]->test_name : '';
        
     $dq = $this->mcm->get_data('question_table',['test_id'=>$id]);
      $question = count($dq) ; 
       
      $qs = "SELECT user_id, user_type,guest_r_id FROM `quiz_anser_tbl`  where  meet_id ='$meet_id' and quiz_test_id ='$id' and end_quiz = '1' GROUP BY user_id,guest_r_id";

      $res = $this->db->query($qs)->result_array();
      
      	$arr= array(); $job = array();
      	   
      //	echo "<pre>"; print_r($res); die();     

      	foreach ($res as $val) 
      	{
      
        if($val['user_type'] == "login_user")  
        {
        	$dx = array();
		          $dx = $this->mcm->get_data('user_tbl',['user_id'=>$val['user_id'] ]);
		          $arr['user_name'] = (count($dx))? $dx[0]->user_name : "" ;    
		          $arr['user_id'] = $val['user_id']; 
		          $arr['user_type'] = 'login_user'; 

        $dz = $this->mcm->get_data('quiz_anser_tbl',[ 'meet_id'=>$meet_id,'user_id'=>$val['user_id'],'ans_status'=>'1' ,'quiz_test_id'=>$id]);
          $ans = (count($dz))? count($dz) : '0';
		      
		}else{
		      	$dy = array();
		      $dy = $this->mcm->get_data('guest_user_tbl',['guest_id'=>$val['guest_r_id']]);

		        $arr['user_name'] = (count($dy))? $dy[0]->fname.' '.$dy[0]->lname : ""; 
      			$arr['user_id'] = $val['guest_r_id']; 
      			 $arr['user_type'] = 'guest_user'; 

      $dz = $this->mcm->get_data('quiz_anser_tbl',['meet_id'=>$meet_id,'guest_r_id'=>$val['guest_r_id'],'ans_status'=>'1' ,'quiz_test_id'=>$id]);
          $ans = (count($dz))? count($dz) : '0';
	 } 
	 
	 $qr = ($question == '0')? 1: $question;
         $arr['percent'] = (round((($ans*100)/$qr),2))? round((($ans*100)/$qr),2).'  %' : "0  %";
              $arr['test_id'] = $id;
              $arr['meet_id'] = $meet_id;
              $arr['test_name'] = $test_name;
                  
   			
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
           
     public function check_result()
        {
                 
                  $u_id = $this->input->post('u_id');
                  $test_id = $this->input->post('test_id');   
                  $meet_id = $this->input->post('meet_id');
                     
                 
                    $dx = array(); $dy = array();
                  
                        $dy = $this->mcm->get_data('quiz_anser_tbl',['user_id'=>$u_id,'end_quiz'=>'1','meet_id'=>$meet_id]);
                   
                    if(count($dy)> 0)
                     {
                         $dataTosend = ['status'=>true, 'msg' =>'Success ', 'body'=>''];
                                	echo json_encode($dataTosend); die();
                         
                     }else{
                                 $dataTosend = ['status'=>false, 'msg' =>'No data Avialable ', 'body'=>''];
                                	echo json_encode($dataTosend); die();
                            }      
                          
                        
        }
        
       // remove_quiz
        
       public function remove_quiz()
        {
                 
                  $test_id = $this->input->post('test_id');   
                  $meet_id = $this->input->post('meet_id');
                     
                 $res = $this->mcm->deleteRecord('quiz_anser_tbl',['quiz_test_id'=>$test_id,'meet_id'=>$meet_id]);
                  // 
                   
                   $dx = $this->mcm->get_data('quiz_test',['test_id'=>$test_id]);
                   $old_meet_id = (count($dx))? $dx[0]->meet_id :"";
                   if($old_meet_id == $meet_id)
                   {
                       $this->mcm->update_data('quiz_test',['test_id'=>$test_id],['meet_id'=>0]) ;
                   }
                   
                    if($res)
                     {
                                 $dataTosend = ['status'=>true, 'msg' =>'Success ', 'body'=>''];
                                	echo json_encode($dataTosend); die();
                         
                     }else{
                                 $dataTosend = ['status'=>false, 'msg' =>'Quiz not remove', 'body'=>''];
                                	echo json_encode($dataTosend); die();
                            }      
                          
                        
        }   
        
        
        
        
        
        
   /*==========================this code use for Api start ===============================*/
            public function download_excel()    
              {     
                      $test_id = $this->uri->segment(3);
                       $user_type = $this->uri->segment(4);   
                       $user_id = $this->uri->segment(5);
                       $meet_id = $this->uri->segment(6);
                          
                      //echo  $test_id." == " .$user_type.' ===  '.$user_id;  die();
                         
                       if($user_type == "login_user")     
                		{
                    	     $qs = "SELECT a.ans_status,b.question,c.options FROM  quiz_anser_tbl as a join question_table as b on a.q_id = b.question_id 
                    	                join answer_table as c on a.option_name = c.answer_id where  a.meet_id ='$meet_id' and a.quiz_test_id ='$test_id' and
            	                         a.user_id ='$user_id' ";
            	        	}else{
                    		        $qs = "SELECT a.ans_status,b.question,c.options FROM  quiz_anser_tbl as a join question_table as b on a.q_id = b.question_id 
                    	                join answer_table as c on  a.option_name = c.answer_id where  a.meet_id ='$meet_id' and a.quiz_test_id ='$test_id' and
            	                         a.guest_r_id ='$user_id' ";
                    		        }
                                 $res = $this->db->query($qs)->result_array();
                            	$arr= array(); $job = array();
                              	 $k = 1;
                                	foreach ($res as $val) 
                                 
                                   {
                            		     $arr['index'] = $k++;
                            		     $arr['question'] = $val['question'];
                            		     $arr['options'] = $val['options'];    
                            		     $arr['ans_status'] = ($val['ans_status'] == '1')? 'true': 'false';
                               				$job[] = $arr;  
                                  	}
                            			 //	echo "<pre>"; print_r($res); die(); 
                            			 
                            			 
            		/*=====================================================================================*/			
            					if(count($job) == "")
            					{
            						?> <script>
            							 alert("No participant for this Meeting!..");
            							 	window.history.back();    
            						</script>   
            				<?php die();	}
            		            $date = date('d/m/Y');
            			$file_name = 'Meeting_details_'.$date.'.csv'; 
            				     
            				  	
            				     header("Content-Description: File Transfer"); 
            				     header("Content-Disposition: attachment; filename=".$file_name); 
            				     header("Content-Type: application/csv;");
            				     
            				     $file = fopen('php://output', 'w');
            				 
            				     $header = array("#","Question","Select Option", "Result"); 
            				     fputcsv($file, $header);
            
            			    if(count($job))
            			    {
            			    	
            				     foreach ($job as  $key => $value)
            				     { 		
            				       fputcsv($file, $value); 
            				     }
            				 }else{
            				 		 fputcsv($file, [ '0'=> '1','1'=>"No User Join this Assessment!"]); 
            				 		}
            				     fclose($file); 
            				     exit; 		
            
                }
            /*==========================this code use for Api end ===============================*/

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
?>
