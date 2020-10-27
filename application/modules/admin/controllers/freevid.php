<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Freevid extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();          
        $this->load->database();
		$this->load->model('Freevideo_model');
        }
        public function index()
        {   
            $this->data['content']='freevid/index';
            $videolist=$this->Freevideo_model->getVideolist();
            $this->data['video_id']=$videolist->video_id; 
			$this->data['cron']='yes';
            $this->load->view('common/template',$this->data);
        }
            public function cron()
        {   
		    $this->data['content']='freevid/index';
            //$videolist=$this->Freevideo_model->getVideolist();
            $this->data['cron']='yes';
            $this->load->view('common/template',$this->data);
        }
        public function addfreevideo(){
         
         
           $fvideo  =  $this->input->post('fvideo');
           $this->Freevideo_model->saveVideo($fvideo);
           $this->session->set_flashdata('message', 'Playlist Id Saved Successfully.');
            redirect('/admin/freevid');
        }
		
		public function commentlist($cmtid=0)
        {
			
			if(isset($cmtid)&&$cmtid>0){
			 $cmtvyid = $this->Freevideo_model->getCommentlist($cmtid); 	
			$this->data['cmtvyid']=  $cmtvyid;   
			}		
			
			$this->load->model('Customer_model');		
            $this->data['content']='freevid/commentlist';
            $commentlistArray=$this->Freevideo_model->getCommentlist();
			
			foreach($commentlistArray as $key=>$value) {
			
				$posttype = $value->post_type;
				$com_dis=$value->com_dis;
				$status=$value->status;
				$comid = $value->com_id;
				
				if($posttype=="1") {
					$pt = "Study Material";
					
				}
				else if($posttype=="2") {
					$pt = "Video";
					$student_id=$value->student_id;
					 
					if(isset($value->student_id)&&$value->student_id>0){
						
					$customerArray=$this->Customer_model->getCustomerDetails($value->student_id);
					
					$student_id=$customerArray->id;
					$fullname=$customerArray->firstname." ".$customerArray->lastname;
					$email=$customerArray->email;
					$mo=$customerArray->mobile_legacy_no;
					}else{
					$fullname=NULL;	
					}
					
					
					 //$value->student_id;
					
				}
				else {
					$pt = "Other";
				}
				
				$com_list['student_id']=$student_id;
				$com_list['com_dis']=$com_dis;
				$com_list['posttype']=$pt;
				$com_list['fullname']=$fullname;
				$com_list['mo']=$mo;
				$com_list['email']=$email;
				$com_list['status']=$status;
				$com_list['com_id']=$comid;				
				$commentlist[]=$com_list;
			}	
	
			
			$this->data['commentlist']=$commentlist;
            $this->load->view('common/template',$this->data);
        }
        
}