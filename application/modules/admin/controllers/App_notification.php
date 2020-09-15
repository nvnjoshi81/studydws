<?php
    
     set_time_limit(100000);
    
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class App_notification extends MY_Admincontroller {

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
            
    /*===========jk function start ==============================*/

       public function show()
        {
             	 $this->data['content'] = 'app_notification/show_notification';
            $this->load->view('common/template', $this->data);  
        }

       
      public function add_notifications()
         {
                    $title = $this->input->post('title');
                    $description = $this->input->post('description');
                  
                   // echo $title." ==jk== ".$description; die();
                   
                    if(empty($title) || empty($description))
                    {
                          $dataTosend = ['status'=>false, 'msg' => 'All field required','body'=> '' ];
			                 echo json_encode($dataTosend); die();
                    }
                    
                         $opp =   $this->mcm->save_data ('notifications',['title'=>$title,'description'=>$description]);
                        if($opp)
                        {   
                              $q = "SELECT  user_id  FROM user_tokens GROUP by user_id ";
                               
                               $dx = $this->db->query( $q)->result(); 
                                $sub = array();
                               foreach ($dx as $val )
                               {
                                  $id =  $val->user_id;
                                   
                                    $dd = $this->mcm->get_data('user_tokens',['user_id'=>$id]); 
                                        
                                         $fruit = array_pop($dd);
                                        
                                     
             					         $tokens =  $fruit->token_name;           
             					         $tok =  $fruit->token_id;           
                                      
                                           $tokens = array($tokens);    
                                    
                                        
                                    $sub[] =  $this->mcm->push_notification_android($tokens,$title,$description,$id);
                                }
                                    
                              $dataTosend = ['status'=>false, 'msg' => 'Notification  insert successfully','body'=> $sub ];
			                 echo json_encode($dataTosend); die();
                            
                        }else{
                                     $dataTosend = ['status'=>false, 'msg' => 'Notification not inserted something went wrong please try again','body'=>''];
			                            	echo json_encode($dataTosend); die();
                             }
                        
                        
                        
                }
        
        
        /*=====================jk function end ========================================================*/

   public function index($page = 0) {
        $this->data['content'] = 'app_notification/index';
        $this->load->view('common/template', $this->data);
    }
	 
     public function androidnotify(){
		 
		 
		 $this->data['content'] = 'app_notification/appnotify';
            $this->load->view('common/template', $this->data);  
		 
		 
	 }
	 
	 
    

}

?>
