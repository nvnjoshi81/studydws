<?php
class Products_model extends CI_Model
{
        
    public function getProductDetails($pricelist_id,$content_type)
    {
        $name='';
        $this->db->select('id,name,order,created_by,modified_by,dt_created,dt_modified');
        $this->db->from('content_type');
        $this->db->where('id',$content_type);
        $contentType=$this->db->get();
        $content=$contentType->row();
        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price,product_expiry_date,description,offline_status,image,thumb_image,app_image,created_by,dt_created,modified_by,dt_modified,modules_item_id,modules_item_name,no_of_dvds,subscription_expiry,no_of_lectures,lecture_duration,no_of_subscribers,status,order_arrange');
        $this->db->from('cmspricelist');
        $this->db->where('id',$pricelist_id);
        $this->db->where('type',$content_type);
        $query = $this->db->get();
        $data= $query->row();
        if($data->item_id > 0){
            $this->db->select('id,displayname,filename,filepath,filename_one,filepath_one,type,filetype,pagecount,is_deleted,created_by,dt_created,modified_by,dt_modified,view_count,like_count');
            $this->db->from('cmsfiles');
            $newquery=$this->db->get();
            $data1=$newquery->row();
            $name=$data1->filename;
        }
        if($data->modules_item_id > 0 ){
            if($content->name=='Question Bank'){
                $details=$this->Questionbank_model->detail($data->modules_item_id);
            }
            if($content->name=='Study Material'){
                $details=$this->Studymaterial_model->detail($data->modules_item_id);
            }
            if($content->name=='Sample Papers'){
                $details=$this->Samplepapers_model->detail($data->modules_item_id);
            }
            if($content->name=='Online Tests'){
                $details=$this->Onlinetest_model->detail($data->modules_item_id);
            }
            if($content->name=='Videos'){
                $details=$this->Videos_model->detail($data->modules_item_id);
            }
            $name=$details->name;
        }
        return array('id'=>$pricelist_id,'name'=>$name);
    }
    public function getProductType($pricelist_id){
        $this->db->select('p.type,c.name');
        $this->db->from('cmspricelist p');
        $this->db->join('content_type c','c.id=p.type');
        $this->db->where('p.id',$pricelist_id);
        $query=$this->db->get();
        return $query->row();
    }
    public function getVideos($exam_id=0,$subject_id=0){
        $this->db->select('P.*,P.id as productlist_id')->select('C.name as exam')->select('S.name as subject')->select('CH.name as chapter');
        $this->db->from('cmspricelist P');
        if($exam_id > 0){
             $this->db->where('P.exam_id',$exam_id);
        }
        if($subject_id > 0){
             $this->db->where('P.subject_id',$subject_id);
        }
        $this->db->join('categories C','C.id=P.exam_id');
        $this->db->join('cmssubjects S', 'P.subject_id=S.id', 'left');
        $this->db->join('cmschapters CH', 'P.chapter_id=CH.id', 'left');
        $this->db->where('P.type',2);
        $this->db->where('P.price > ',0);
        $this->db->where('P.discounted_price > ',0);
        $query=$this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    
    public function getVideosByLevel($exam_id = null, $subject_id = null, $chapter_id = null,$limit=null){
            $this->db->select('P.*,P.id as productlist_id')->select('C.name as exam')->select('S.name as subject')->select('CH.name as chapter');
        $this->db->from('cmspricelist P');
        if($exam_id > 0){
            $this->db->where('P.exam_id',$exam_id);
        }
        if($subject_id>0){
            $this->db->where('P.subject_id',$subject_id);
        }else{
            //$this->db->where('P.subject_id<',1);
        }
        if($chapter_id>0){
            $this->db->where('P.chapter_id',$chapter_id);
         }else{
            //$this->db->where('P.chapter_id<',1);
        }
        $this->db->join('categories C','C.id=P.exam_id');
        $this->db->join('cmssubjects S', 'P.subject_id=S.id', 'left');
        $this->db->join('cmschapters CH', 'P.chapter_id=CH.id', 'left');
        $this->db->where('P.type',2);
        $this->db->where('P.price > ',0);
        $this->db->where('P.discounted_price > ',0);
        $query=$this->db->get();
        return $query->result();
   
        
    }
    
    public function details($product_id){
        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price,product_expiry_date,description,offline_status,image,thumb_image,app_image,created_by,dt_created,modified_by,dt_modified,modules_item_id,modules_item_name,no_of_dvds,subscription_expiry,no_of_lectures,lecture_duration,no_of_subscribers,status,order_arrange');
        $this->db->where('id',$product_id);
        $this->db->from('cmspricelist');
        $query=$this->db->get();
        return $query->row();
    }
    public function all(){
        $this->db->select('C.*')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter')->select('D.name as type');
        $this->db->from('cmspricelist C');
        $this->db->join('categories', 'C.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'C.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'C.chapter_id=cmschapters.id', 'left');
        $this->db->join('content_type D', 'D.id=C.type', 'left');
        $this->db->where('C.price >', 0);
        $this->db->where('C.discounted_price >', 0);
        $query=$this->db->get();
        return $query->result();
    }

	
    
}