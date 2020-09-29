<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pricelist_model extends CI_Model {

    public function add($data) {
        $this->db->insert('cmspricelist', $data);
        //echo $this->db->last_query();
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->update('cmspricelist', $data, array('id' => $id));
    }
	
    public function pkgupdate($id, $data) {
        $this->db->update('cmspackages_counter', $data, array('id' => $id));
    }
	
   
    public function update_packageCount($pricelistid, $data) {
        $this->db->update('cmspricelist', $data, array('id' => $pricelistid));
    }
        
    public function update_viewcount($id, $tablename) {
        /* $sql=  "update ".$tablename." set view_count=view_count+1 where id=".$id;
           $this->db->query($sql); 
        */
           return true;
    }
    
  
    public function get($type, $exam_id, $subject_id = 0, $chapter_id = 0) {
        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price,description,offline_status,app_image,modules_item_id,modules_item_name,no_of_dvds,subscription_expiry,no_of_lectures,lecture_duration,no_of_subscribers');
        $this->db->from('cmspricelist');
        $this->db->where('type', $type);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $chapter_id);
        $this->db->where('item_id',0);
        //$this->db->where('price >', 0);
        $query = $this->db->get();
        
        //echo $this->db->last_query();
        if ($this->db->count_all_results() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
       public function getOrderInfo($productid,$customerid,$ordStatus=NULL){
     $this->db->select('O.id,O.order_no,O.user_id,O.order_items,O.created_dt,O.status,O.validity_dt,OD.end_date,OD.product_id');
        $this->db->from('cmsorders O');  //cmsorder_details
        $this->db->where('OD.product_id',$productid);
		if(isset($ordStatus)&&$ordStatus>=0){
		//We only need order status success.
		$this->db->where('O.status',1);	
		}
        $this->db->where('O.user_id',$customerid);
        $this->db->join('cmsorder_details OD', 'O.id=OD.order_id');   
        $this->db->order_by('O.id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($this->db->count_all_results() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    
     public function getsubject_product($type, $exam_id, $subject_id = 0, $chapter_id = 0) {
        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price,description,offline_status,image,app_image,modules_item_id,modules_item_name,no_of_dvds,subscription_expiry,no_of_lectures,lecture_duration,no_of_subscribers');
        $this->db->from('cmspricelist');
        $this->db->where('type', $type);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $chapter_id);
        $this->db->where('item_id',0);
        //$this->db->where('price >', 0);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($this->db->count_all_results() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
      public function getSum_outer($type, $exam_id, $subject_id = 0, $chapter_id = 0) {
           $this->db->select('F.displayname,F.filename,F.filepath,'
                . 'F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted,F.id,P.price,P.discounted_price,D.file_id,F.filename as question,A.name as modules_item_name,P.id as productlist_id,A.name')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsfiles F');
        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');        
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmsstudymaterial_relations ', 'A.id=cmsstudymaterial_relations.studymaterial_id');
         $this->db->join('categories', 'cmsstudymaterial_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsstudymaterial_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsstudymaterial_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        //$this->db->where('P.type',1);
        //if($limit > 0){
            //$this->db->limit($limit);
        //}
        
        $this->db->order_by('F.id','desc');
         $query = $this->db->get();
       //echo $this->db->last_query();
        $total = $query->row();
        return $total;
      }
            
        public function getSum($type, $exam_id, $subject_id = 0, $chapter_id = 0) {
         $this->db->select('P.discounted_price as total');
        
        $this->db->from('cmsfiles F');
        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }        
        $this->db->where('P.type', $type);
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');        
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmsstudymaterial_relations ', 'A.id=cmsstudymaterial_relations.studymaterial_id');
         $this->db->join('categories', 'cmsstudymaterial_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsstudymaterial_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsstudymaterial_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        $this->db->order_by('F.id','desc');
        $this->db->group_by('P.item_id');
         $query = $this->db->get();
         //echo $this->db->last_query();
        if ($this->db->count_all_results() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
     public function getSum_mainprice($type, $exam_id, $subject_id = 0, $chapter_id = 0) {
        $this->db->select('P.price as total');
        $this->db->from('cmsfiles F');
        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }        
        $this->db->where('P.type', $type);
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');        
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmsstudymaterial_relations ', 'A.id=cmsstudymaterial_relations.studymaterial_id');
         $this->db->join('categories', 'cmsstudymaterial_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsstudymaterial_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsstudymaterial_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        $this->db->order_by('F.id','desc');
        $this->db->group_by('P.item_id');
         $query = $this->db->get();
         //echo $this->db->last_query();
         
        if ($this->db->count_all_results() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
      public function getSum_outer2($type, $exam_id, $subject_id = 0, $chapter_id = 0) {
     $this->db->select('sum(cmspricelist.discounted_price) as total');
        $this->db->from('cmspricelist');
        $this->db->where('cmspricelist.type', $type);
        $this->db->join('cmsstudymaterial_details','cmsstudymaterial_details.file_id=cmspricelist.item_id');
        $this->db->join('cmsstudymaterial_relations','cmsstudymaterial_details.id=cmsstudymaterial_relations.studymaterial_id');
       
        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }
        //$this->db->where('cmspricelist.item_id > 0');
        $this->db->group_by('cmspricelist.id');
        //$this->db->where('price >', 0);        
        $query = $this->db->get();
       //echo $this->db->last_query();
        $total = $query->row();
        return $total;                     
    }
    
	
	
	 public function complemtry_order($type, $exam_id, $subject_id = 0, $chapter_id = 0) {
     $this->db->select('cmspricelist.id as pid');
        $this->db->from('cmspricelist');
        $this->db->where('cmspricelist.type', $type);
     
     
       
        if ($exam_id > 0) {
            $this->db->where('cmspricelist.exam_id', $exam_id);
        }
            $this->db->where('cmspricelist.subject_id', $subject_id);
          $this->db->where('cmspricelist.chapter_id', $chapter_id);
               
        $query = $this->db->get();
       //echo $this->db->last_query();
	   
        return  $query->row();                 
    }
    public function getDetails_bymoduleID($mid) {
        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price,description,offline_status,image,app_image,modules_item_id,modules_item_name');
        $this->db->where('modules_item_id', $mid);
        $this->db->from('cmspricelist');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    public function getDetails(int $id) {
		if( $id>0){
        $this->db->select('P.id,P.exam_id,P.subject_id,P.chapter_id,P.item_id,P.type,P.price,P.discounted_price,P.description,P.offline_status,P.image,P.modules_item_id,P.modules_item_name')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmspricelist P');
        $this->db->where('P.id', $id);
        $this->db->join('categories', 'P.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'P.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'P.chapter_id=cmschapters.id', 'left');
        $query = $this->db->get();
        //$this->db->save_queries = TRUE;
        //echo  $this->db->last_query();
        return $query->row();
		}else{
		
		return NULL;
		}
    }

    public function getAllPrices($exam_id, $subject_id = 0, $chapter_id = 0, $item_id = 0) {
        $this->db->select('A.id,A.exam_id,A.subject_id,A.chapter_id,A.item_id,A.type,A.price,A.discounted_price,A.description,A.offline_status,A.image,A.app_image,A.modules_item_id,A.modules_item_name,CC.name exam,B.name subject,C.name as chapter,D.name as type');
        $this->db->from('cmspricelist A');
        $this->db->join('cmssubjects B', 'B.id=A.subject_id', 'left');
        $this->db->join('cmschapters C', 'C.id=A.chapter_id', 'left');
        $this->db->join('categories CC', 'CC.id=A.exam_id', 'left');
        if ($subject_id > 0) {
            $this->db->where('A.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('A.chapter_id', $chapter_id);
        }
        if ($item_id > 0) {
            $this->db->where('A.item_id', $item_id);
        }
        $this->db->join('content_type D', 'D.id=A.type', 'left');
        $this->db->where('A.exam_id', $exam_id);
        $this->db->where('A.price > ',0);

        $query = $this->db->get();

        if ($this->db->count_all_results() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }    
 
    public function getcontentprice($relation, $type, $id) {

        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price,description,offline_status,image,app_image,modules_item_id,modules_item_name');
        $this->db->from('cmspricelist');
        /*if ($relation->exam_id > 0) {
            $this->db->where('exam_id', $relation->exam_id);
        }
        if ($relation->subject_id > 0) {
            $this->db->where('subject_id', $relation->subject_id);
        }
        if ($relation->chapter_id > 0) {
            $this->db->where('chapter_id', $relation->chapter_id);
        }
         */
        $this->db->where('type', $type);
        $this->db->where('modules_item_id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }
    
  function getiemid_std($module_item_id){
      $this->db->select('file_id');
        $this->db->from('cmsstudymaterial_details');
        $this->db->where('id', $module_item_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
  }  

    function getProducts($type) {
        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price,description,offline_status,image,app_image,modules_item_id,modules_item_name');
        $this->db->from('cmspricelist');
        $this->db->where('type', $type);        
        $this->db->where('status', 'show');
        $query = $this->db->get();
        return $query->result();
    }
    function getProducts_byid($id) {
        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price,description,offline_status,image,app_image,modules_item_id,modules_item_name');
        $this->db->from('cmspricelist');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getAllProducts($exam_id, $subject_id, $chapter_id, $type=0,$limit=0,$product_id=0) {

        $this->db->select('cmspricelist.id as productlist_id,cmspricelist.exam_id,cmspricelist.subject_id,cmspricelist.chapter_id,cmspricelist.item_id,cmspricelist.type,cmspricelist.price,cmspricelist.discounted_price,cmspricelist.description,cmspricelist.offline_status,cmspricelist.image,cmspricelist.modules_item_id,cmspricelist.modules_item_name,cmsfiles.displayname,cmsfiles.filename')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmspricelist');
        if($type > 0){
        $this->db->where('cmspricelist.type', $type);
        }
        $this->db->where('cmspricelist.price > ',0);
        if ($exam_id > 0) {
            $this->db->where('exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'cmspricelist.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmspricelist.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmspricelist.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmspricelist.item_id', 'left');
        $this->db->group_by('cmspricelist.id');
        $this->db->order_by('cmspricelist.price','desc');
        if($limit > 0){
            $this->db->limit($limit);
        }
        if($product_id > 0){
            $this->db->where('cmspricelist.id !=', $product_id);
        }
        $this->db->order_by('cmspricelist.id','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
        public function getFiles_withallproducts($smid) {
        $this->db->select('F.id,F.exam_id,F.subject_id,F.chapter_id,F.item_id,F.type,F.price,F.discounted_price'
                . ',F.description,F.offline_status,F.image,F.modules_item_id,F.modules_item_name,P.price,P.discounted_price,P.modules_item_id,P.modules_item_name,P.item_id,D.file_id,F.filename as question,A.name')->select('ca.name as exam,ca.id as exam_id')->select('su.name as subject,su.id as subject_id')->select('ch.name as chapter, ch.id as chapter_id');
        $this->db->from('cmsfiles F');
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        $this->db->join('categories ca', 'P.exam_id=ca.id', 'left');
        $this->db->join('cmssubjects su', 'P.subject_id=su.id', 'left');
        $this->db->join('cmschapters ch', 'P.chapter_id=ch.id', 'left');
        //$this->db->where('P.type',1);
        $this->db->where('D.studymaterial_id', $smid);
        $query = $this->db->get();
        return $query->result();
    }

    function getProductPrice($relation, $type) {
        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price'
                . ',description,offline_status,image,app_image,modules_item_id,modules_item_name');
        $this->db->from('cmspricelist');
        if ($relation->exam_id > 0) {
            $this->db->where('exam_id', $relation->exam_id);
        }
        if ($relation->subject_id > 0) {
            $this->db->where('subject_id', $relation->subject_id);
        }
        if ($relation->chapter_id > 0) {
            $this->db->where('chapter_id', $relation->chapter_id);
        }
        $this->db->where('type', $type);
        $query = $this->db->get();
        return $query->row();
    }

    function getProduct($exam_id, $subject_id, $chapter_id, $type) {
        $this->db->select('C.id,C.exam_id,C.subject_id,C.chapter_id,C.item_id,C.type,C.price,C.discounted_price'
                . ',C.description,C.offline_status,C.image,C.app_image,C.modules_item_id,C.modules_item_name,C.no_of_dvds,C.subscription_expiry,C.no_of_lectures,C.lecture_duration,C.no_of_subscribers')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmspricelist C');
        $this->db->where('type', $type);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('chapter_id', $chapter_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->join('categories', 'C.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'C.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'C.chapter_id=cmschapters.id', 'left');
        $this->db->where('item_id', 0);
        $this->db->group_by('C.id');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }
    
    function getProduct_id($exam_id, $subject_id, $chapter_id, $type) {

        $this->db->select('C.id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmspricelist C');
        $this->db->where('type', $type);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('chapter_id', $chapter_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->join('categories', 'C.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'C.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'C.chapter_id=cmschapters.id', 'left');
        $this->db->where('item_id', 0);
        $this->db->group_by('C.id');
        $query = $this->db->get();
        return $query->row();
    }

    function getTopLevelProducts($exam_id, $type) {
        $this->db->select('C.id,C.exam_id,C.subject_id,C.chapter_id,C.item_id,C.type,C.price,C.discounted_price'. ',C.description,C.offline_status,C.image,C.modules_item_id,C.modules_item_name')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmspricelist C');
        $this->db->where('type', $type);
        $this->db->where('exam_id', $exam_id);
        $this->db->join('categories', 'C.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'C.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'C.chapter_id=cmschapters.id', 'left');

        $this->db->where('C.price >', 0);
        $this->db->where('C.discounted_price >', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getModuleItemPrice($id, $type) {
        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price,description,offline_status,image,app_image,modules_item_id,modules_item_name');
        $this->db->from('cmspricelist');
        $this->db->where('modules_item_id', $id);
        $this->db->where('type', $type);
        $query = $this->db->get();
        return $query->row();
    }

    public function getItemPrice($id, $type) {
        $this->db->select('id,exam_id,subject_id,chapter_id,item_id,type,price,discounted_price,description,offline_status,image,app_image,modules_item_id,modules_item_name');
        $this->db->from('cmspricelist');
        $this->db->where('item_id', $id);
        $this->db->where('type', $type);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function checkExamProduct($exam_id){
        $this->db->select('id');
        $this->db->from('cmspricelist');
        $this->db->where('exam_id', $exam_id);
         $this->db->where('subject_id', 0);
          $this->db->where('chapter_id', 0);
           $this->db->where('item_id', 0);
           $this->db->where('type',1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->row();
        
        if(isset($result->id)&&$result->id>0){
        return $result->id; 
        }else{
            return 0;
        }
    }
    
    
    public function checkExamProduct_detail($exam_id){
        $this->db->select('id,exam_id,subject_id,chapter_id');
        $this->db->from('cmspricelist');
        $this->db->where('exam_id', $exam_id);
         $this->db->where('subject_id', 0);
          $this->db->where('chapter_id', 0);
           $this->db->where('item_id', 0);
           $this->db->where('type',1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
        
    }
    
    public function checkSubjectProduct($exam_id,$subject_id){
       $this->db->select('id');
        $this->db->from('cmspricelist');
        $this->db->where('exam_id', $exam_id);
         $this->db->where('subject_id', $subject_id);
          $this->db->where('chapter_id', 0);
           $this->db->where('item_id', 0);
           $this->db->where('type',1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->row();
        
        if(isset($result->id)&&$result->id>0){
        return $result->id; 
        }else{
            return 0;
        }  
    }  
   
    public function checkSubjectProduct_detail($exam_id,$subject_id){
       $this->db->select('id,exam_id,subject_id,chapter_id');
        $this->db->from('cmspricelist');
        $this->db->where('exam_id', $exam_id);
         $this->db->where('subject_id', $subject_id);
          $this->db->where('chapter_id', 0);
           $this->db->where('item_id', 0);
           $this->db->where('type',1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();          
    }  
	
    public function pkgCount_byExam($exam_id='0') {
	     $this->db->select('id,exam_id,exam_name , subject_name,subject_id ,total_package ,total_question ,custom_total_package ,custom_total_question ,module_type');
        $this->db->from('cmspackages_counter');
        $this->db->where('exam_id', $exam_id);
		
        $this->db->where('subject_id','');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->result();
        return $result;
	}
	
	
     public function allproduct_by_content($contentType='all') {
		$this->db->select('cmspricelist.image,cmspricelist.app_image,cmspricelist.modules_item_id,cmspricelist.id,cmspricelist.exam_id,cmspricelist.subject_id,cmspricelist.chapter_id,cmspricelist.item_id,cmspricelist.type,cmspricelist.price,cmspricelist.discounted_price,cmspricelist.description,cmspricelist.modules_item_name');
        $this->db->from('cmspricelist');
        $this->db->join('categories', 'cmspricelist.exam_id=categories.id','left');
        $this->db->join('cmssubjects', 'cmspricelist.subject_id=cmssubjects.id','left');
        $this->db->join('cmschapters', 'cmspricelist.chapter_id=cmschapters.id','left');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmspricelist.item_id','left');   
if(isset($contentType)&&($contentType=='1'||$contentType=='2'||$contentType=='3')){        
	$this->db->where('cmspricelist.type', $contentType);
}else{
	$type_array = array('1', '2','3');
    $this->db->where_in('cmspricelist.type', $type_array);
}  		
        $this->db->where('cmspricelist.price>', 0);   
		$this->db->where('subject_id', 0);
		$this->db->where('exam_id >', 0);
		$this->db->where('cmspricelist.item_id',0);      
        $this->db->order_by('cmspricelist.price','desc');
        $this->db->order_by('cmspricelist.id','desc');
        $this->db->group_by('cmspricelist.id','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($this->db->count_all_results() > 0) {
            return $query->result();
        } else {
            return false;
        }
	 }
    
public function allproduct_by_exam($examid,$contentType='all') {
if($contentType=='1'||$contentType=='2'||$contentType=='3'){        
	$type_array = array($contentType);
}else{
	$type_array = array('1', '2','3');
}   
		$this->db->select('cmspricelist.image,cmspricelist.app_image,cmspricelist.modules_item_id,cmspricelist.id,cmspricelist.exam_id,cmspricelist.subject_id,cmspricelist.chapter_id,cmspricelist.item_id,cmspricelist.type,cmspricelist.price,cmspricelist.discounted_price,cmspricelist.description,cmspricelist.modules_item_name');
        $this->db->from('cmspricelist');
        $this->db->join('categories', 'cmspricelist.exam_id=categories.id','left');
        $this->db->join('cmssubjects', 'cmspricelist.subject_id=cmssubjects.id','left');
        $this->db->join('cmschapters', 'cmspricelist.chapter_id=cmschapters.id','left');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmspricelist.item_id','left');        
        $this->db->where_in('cmspricelist.type', $type_array);
        $this->db->where('cmspricelist.exam_id', $examid);
        $this->db->where('cmspricelist.price>', 0);
        $this->db->where('cmspricelist.item_id',0);      
        $this->db->order_by('cmspricelist.price','desc');
        $this->db->order_by('cmspricelist.id','desc');
        $this->db->group_by('cmspricelist.id','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($this->db->count_all_results() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}
