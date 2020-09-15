<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends Modulecontroller {

    public function __construct() {
        parent:: __construct();
        //$this->load->model('Products_model');
    }

    public function index() {
        $ncert_exam_array=array('7'=>'6th-class/37','6'=>'7th-class/38','5'=>'8th-class/31',
            '4'=>'9th-class/30','3'=>'10th-class/24','2'=>'11th-class/23','1'=>'12th-class/22');
        $ncert_examid_array=array('6th-class'=>'37','7th-class'=>'38','8th-class'=>'31',
            '9th-class'=>'30','10th-class'=>'24','11th-class'=>'23','12th-class'=>'22');
        $ncert_examname_array=array('6th-class'=>'6th-class/37','7th-class'=>'7th-class/38','8th-class'=>'8th-class/31','9th-class'=>'9th-class/30','10th-class'=>'10th-class/24','11th-class'=>'11th-class/23','12th-class'=>'12th-class/22');
        
        $sm_exam_array=array('7'=>'6th-class/37','6'=>'7th-class/38','5'=>'8th-class/31',
            '4'=>'9th-class/30','3'=>'10th-class/24','2'=>'11th-class/23','1'=>'jee-main-advanced/28');
        $sm_examid_array=array('6th-class'=>'37','7th-class'=>'38','8th-class'=>'31',
            '9th-class'=>'30','10th-class'=>'24','11th-class'=>'23','12th-class'=>'22');
        $sm_examname_array=array('6th-class'=>'6th-class/37','7th-class'=>'7th-class/38','8th-class'=>'8th-class/31','9th-class'=>'9th-class/30','10th-class'=>'10th-class/24','11th-class'=>'11th-class/23','12th-class'=>'12th-class/22');
        $segments=$this->uri->total_segments();
        if($this->uri->segment(1)=='studymaterial' || $this->uri->segment(1)=='study-material'){
             if($segments==1){
                redirect('study-packages', 'location', 301);
            }
            if($segments==3){
                redirect('study-packages/'.$sm_exam_array[$this->uri->segment(3)],'location',301);
                
            }
        }
        if($this->uri->segment(1)=='ncert-solutions'){
            if($segments==1){
                redirect('ncert-solution', 'location', 301);
            }
            if($segments==3){
                redirect('ncert-solution/'.$ncert_exam_array[$this->uri->segment(3)],'location',301);
                
            }
            if($segments==4){
                $subject_name=$this->uri->segment(3);
                $subject_segment=  explode('-',$subject_name);
                $rs=$this->db->query('select * from cmssubjects where name like "%'.$subject_segment[0].'%" ');
                $data=$rs->row();
                redirect('ncert-solution/'.$ncert_examname_array[$this->uri->segment(2)].'/'.url_title($data->name,'-',true).'/'.$data->id,'location',301);
            }
            if($segments==5){
                $this->load->model('Ncertsolutions_model');
                $subject_name=$this->uri->segment(3);
                $subject_segment=  explode('-',$subject_name);
                $rs=$this->db->query('select * from cmssubjects where name like "%'.$subject_segment[0].'%" ');
                $data=$rs->row();
                $chapter_name=$this->uri->segment(4);
                $chapter_segment=  explode('-',$chapter_name);
                //echo 'select * from cmschapters where replace(replace(replace(replace(name,",","")," : "," ")," - "," "),"\'"," ")  like "'.$chapter_segment[0].' '.$chapter_segment[1].'%" ';
                $rs1=$this->db->query('select * from cmschapters where replace(replace(replace(replace(name,",","")," : "," ")," - "," "),"\'"," ")  like "'.$chapter_segment[0].' '.$chapter_segment[1].'%" ');
                $data1=$rs1->row();
                $ncert_solution=$this->Ncertsolutions_model->getNcertSolutions($ncert_examid_array[$this->uri->segment(2)],$data->id,$data1->id);
                //print_r($ncert_solution);die();
                //echo 'ncert-solution/'.$this->uri->segment(2).'/'.url_title($data->name,'-',true).'/'.url_title($data1->name,'-',true);die();
                redirect('/ncert-solution/'.$this->uri->segment(2).'/'.url_title($data->name,'-',true).'/'.url_title($data1->name,'-',true).'/'.url_title($ncert_solution[0]->name,'-',true).'/'.$ncert_solution[0]->id,'location',301);
            }
             if($segments==7){
                $quid=$this->uri->segment(7);
                $rs=$this->db->query('select question_desc from ncert_solutions_qus_ans where qus_ans_id='.$quid);
                $ques=$rs->row();
                $result=$this->db->query('select * from cmsquestions where question ="'.addslashes($ques->question_desc).'"');
                $newques=$result->result();
                //print_r($newques);
                $newquestion_id=0;
                if(count($newques)==1){
                    $newquestion_id=$newques[0]->id;
                }else{
                    $newquestion_id=$newques[1]->id;
                }
                $q=$this->db->query('select nc.* from cmsncertsolutions nc,cmsncertsolutions_details ncd where nc.id=ncd.ncertsolutions_id and ncd.question_id='.$newquestion_id);
                $d=$q->row();
                
                redirect('ncert-solution/'.url_title($d->name,'-',true).'/'.$d->id.'/'.$newquestion_id);
             }
            $this->data['content'] = 'notfound';
            $this->load->view('template', $this->data);
        }
        $this->data['content'] = 'notfound';
        $this->load->view('template', $this->data);
    }

}
