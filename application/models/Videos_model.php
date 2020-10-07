<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Videos_model extends CI_Model {    
    
    public function insert_modules_package($data,$tablename){    
        
        $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }
    
    public function update_modules_package($id,$data,$tablename){        
        $this->db->update($tablename, $data, array('id' => $id)); 
    }
   
    public function check_modules_package($exam_id='',$subject_id='',$module_type,$tablename,$level=''){
       $this->db->select('id,total_package,total_question,module_type'); 
        $this->db->from($tablename);      
        if($exam_id>0){
        $this->db->where('exam_id', $exam_id);
        }
        if($subject_id>0){
        $this->db->where('subject_id', $subject_id);
        }
        if($level!=''){
        $this->db->where('level', $level);
        }
        $this->db->where('module_type', $module_type);
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
    
    public function get_modules_package($exam_id=0,$subject_id=0){
        if($exam_id > 0 && $subject_id>0) {
        $this->db->select('id,exam_id,exam_name,subject_id,subject_name,total_package,total_question,custom_total_package,custom_total_question,module_type'); 
        $this->db->from('cmspackages_counter');
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id',$subject_id);
        $this->db->where('level','subject');
        }else if($exam_id > 0 && $subject_id==0) {
        $this->db->select('id,exam_id,exam_name,subject_id,subject_name,total_package,total_question,custom_total_package,custom_total_question,module_type'); 
        $this->db->from('cmspackages_counter');
        $this->db->where('exam_id', $exam_id);
        $this->db->where('level','exam');
        }else{
        $this->db->select('id,total_package,total_question,custom_total_package,custom_total_question,module_type'); 
        $this->db->where('level','root');
        $this->db->from('cmspackagesall_counter');
        }
        $query = $this->db->get();
        //echo '--->'.$this->db->last_query().'<----';       
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
    
    public function add($data) {
        $this->db->insert('cmsvideos', $data);
        return $this->db->insert_id();
    }

    public function getVideosduration($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('cmsvideolist_relations.id,cmsvideolist_relations.videolist_id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id,'
                . 'cmsvideolist_details.id,cmsvideolist_details.videolist_id,cmsvideolist_details.video_id,'
                . 'cmsvideos.id,cmsvideos.title,cmsvideos.video_source,cmsvideos.video_url_code,cmsvideos.video_file_name,cmsvideos.video_image'
                . ',cmsvideos.short_video,cmsvideos.is_featured,cmsvideos.description,cmsvideos.video_by,cmsvideos.status,cmsvideos.views'
                . ',cmsvideos.is_free,cmsvideos.video_duration,cmsvideos.custom_video_duration,cmsvideos.video_size,cmsvideos.androidapp_link,cmsvideos.amazonaws_link'
                . ',cmsvideos.amazon_cloudfront_domain');
        $this->db->from('cmsvideolist_relations');

        $this->db->join('cmsvideolist_details', 'cmsvideolist_details.videolist_id=cmsvideolist_relations.videolist_id');

        $this->db->join('cmsvideos', 'cmsvideos.id=cmsvideolist_details.video_id');

        if ($exam_id > 0) {
            $this->db->where('cmsvideolist_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsvideolist_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsvideolist_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
       
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    public function getVideos($exam_id = 0, $subject_id = 0, $chapter_id = 0,$limit=0) { 
        $this->db->select('cmsvideoslist.name,cmsvideoslist.display_image,cmsvideoslist.id,cmsvideolist_relations.id as v_relations_id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');

        if ($exam_id > 0) {
            $this->db->where('cmsvideolist_relations.exam_id', $exam_id, 'left');
        }
        if ($subject_id > 0) {
            $this->db->where('cmsvideolist_relations.subject_id', $subject_id, 'left');
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsvideolist_relations.chapter_id', $chapter_id, 'left');
        }
        $this->db->join('categories', 'cmsvideolist_relations.exam_id=categories.id');
        $this->db->join('cmssubjects', 'cmsvideolist_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsvideolist_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsvideoslist', 'cmsvideolist_relations.videolist_id=cmsvideoslist.id');
        $this->db->from('cmsvideolist_relations');
        $this->db->group_by('cmsvideolist_relations.videolist_id');
        if($limit>0){
        $this->db->limit($limit);
        $this->db->order_by('cmsvideoslist.id','random');
        }else{
        $this->db->order_by('cmsvideoslist.id','desc');
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    public function getPlaylistVideosCount($playlist_id) {
        $this->db->select('id');
        $this->db->from('cmsvideolist_details');
        $this->db->where('videolist_id', $playlist_id);
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->num_rows();
        }else{
        return 0;
        }
    }

    public function getVideosList($id) {
    $this->db->select('v.id,v.title,v.video_source,v.video_url_code,v.video_file_name,v.video_image,v.short_video,v.is_featured,v.description,v.video_image as display_image,d.videolist_id,d.video_id');        
    $this->db->from('cmsvideos v');
    $this->db->where('v.status',1);
        $this->db->where('v.video_tag!=','Career Point');
		   $this->db->where('v.video_source!=', 'youtube');
        $this->db->join('cmsvideolist_details d', 'd.video_id=v.id');
        $this->db->where("d.videolist_id = $id");
		$this->db->order_by("CAST(v.title AS UNSIGNED),v.title", "asc");
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    public function checkVideoList($exam_id, $subject_id, $chapter_id) {
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $chapter_id);
        $this->db->from('cmsvideoslist');
        $query = $this->db->get();
        
        if($query->num_rows()>0){ 
        return $query->row();
        }else{
        return array();
        }
    }

    public function addVideosList($data) {
        $this->db->insert('cmsvideoslist', $data);
        return $this->db->insert_id();
    }

    public function addVideolistDetails($data) {
        $this->db->insert('cmsvideolist_details', $data);
        return $this->db->insert_id();
    }

    public function getIdByLegacy($legacy_id) {
        $this->db->select('*');
        $this->db->from('cmsvideos');
        $this->db->where('legacy_id', $legacy_id);
        $query = $this->db->get();
        
        if($query->num_rows()>0){ 
        return $query->row();
        }else{
        return array();
        }
    }

    public function getVideoDetails($id,$vstatus=1) {
		
		if($vstatus==0){
			$vstatus=0;
		}elseif($vstatus==2){
		//2 for display all video		
        $vstatus=2;
		}else{
			
		$vstatus=1;

		}
        $this->db->select('V.id,V.title,V.video_source,V.video_url_code,V.video_file_name,V.video_image,V.short_video,V.is_featured,V.description,V.video_by,V.status,V.views'. ',V.is_free,V.video_duration,V.custom_video_duration,V.video_size,V.androidapp_link,V.amazonaws_link,V.amazon_cloudfront_domain,V.like_count')->select('cmsvideoslist.name,cmsvideoslist.display_image,cmsvideoslist.id as vid,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');;
        $this->db->from('cmsvideos V');
        $this->db->join('cmsvideolist_details','cmsvideolist_details.video_id=V.id');
        $this->db->join('cmsvideolist_relations','cmsvideolist_relations.videolist_id=cmsvideolist_details.videolist_id');
        $this->db->join('categories', 'cmsvideolist_relations.exam_id=categories.id');
        $this->db->join('cmssubjects', 'cmsvideolist_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsvideolist_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsvideoslist', 'cmsvideolist_relations.videolist_id=cmsvideoslist.id');
		if($vstatus==0||$vstatus==1){
		//$vstatus ==1 Show video and 0=hide
		$this->db->where('V.status',$vstatus);
        }
		
		$this->db->where('V.id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows()>0){ 
        return $query->row();
        }else{
        return array();
        }
    }
    
    function getVideoDetails_all($tempvar='youtube') {
         $this->db->select('V.id,V.video_tag,V.title,V.video_source,V.video_url_code,V.video_file_name,V.video_image,V.short_video,V.is_featured,V.description,V.video_by,V.status,V.views,V.is_free,V.video_duration,V.custom_video_duration,V.video_size,V.androidapp_link,V.amazonaws_link,V.amazon_cloudfront_domain,V.video_source')->select('cmsvideoslist.name,cmsvideoslist.display_image,cmsvideoslist.id as vid,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsvideos V');
        $this->db->join('cmsvideolist_details','cmsvideolist_details.video_id=V.id');
        $this->db->join('cmsvideolist_relations','cmsvideolist_relations.videolist_id=cmsvideolist_details.videolist_id');
        $this->db->join('categories', 'cmsvideolist_relations.exam_id=categories.id');
        $this->db->join('cmssubjects', 'cmsvideolist_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsvideolist_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsvideoslist', 'cmsvideolist_relations.videolist_id=cmsvideoslist.id');
        $this->db->where('V.status',1);
        $this->db->where('V.video_source', $tempvar);
		$this->db->order_by("V.title", "asc");
        $this->db->where('V.id!=', 0);
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    public function getfeaturedVideoDetails() {
        $this->db->select('V.id,V.title,V.video_duration,V.video_source,V.video_url_code,V.video_file_name')->select('cmsvideoslist.name,cmsvideoslist.display_image,cmsvideoslist.id as playlist_id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsvideos V');
        $this->db->join('cmsvideolist_details','cmsvideolist_details.video_id=V.id');
        $this->db->join('cmsvideolist_relations','cmsvideolist_relations.videolist_id=cmsvideolist_details.videolist_id');
        $this->db->join('categories', 'cmsvideolist_relations.exam_id=categories.id');
        $this->db->join('cmssubjects', 'cmsvideolist_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsvideolist_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsvideoslist', 'cmsvideolist_relations.videolist_id=cmsvideoslist.id');
        $this->db->where('V.is_featured',1);
        $this->db->where('V.video_url_code!=',' ');
        $this->db->where('V.status',1);
        $this->db->where('V.video_source', 'youtube'); 
        $this->db->where('V.video_tag!=','Career Point');
        $this->db->group_by('V.id');        
        //$this->db->order_by("v.dt_modified", "asc");
        $query = $this->db->get();
        
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    public function getVideosCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('cmsvideolist_relations.id,cmsvideolist_details.id');
        $this->db->from('cmsvideolist_relations');

        $this->db->join('cmsvideolist_details', 'cmsvideolist_details.videolist_id=cmsvideolist_relations.videolist_id');

        if ($exam_id > 0) {
            $this->db->where('cmsvideolist_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsvideolist_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsvideolist_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
         
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    function playlistdetails($id) {
        $this->db->select('cmsvideoslist.name,cmsvideoslist.id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->join('cmsvideolist_relations', 'cmsvideolist_relations.videolist_id=cmsvideoslist.id');
        $this->db->join('categories', 'cmsvideolist_relations.exam_id=categories.id');
        $this->db->join('cmssubjects', 'cmsvideolist_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsvideolist_relations.chapter_id=cmschapters.id', 'left');
        $this->db->where('cmsvideoslist.id', $id);
        $this->db->from('cmsvideoslist');
        $query = $this->db->get();
         
        if($query->num_rows()>0){ 
        return $query->row();
        }else{
        return array();
        }
    }
    
    function playlistdetails_byrelationid($id,$relation_id) { 
        $this->db->select('cmsvideoslist.name,cmsvideoslist.id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->join('cmsvideolist_relations', 'cmsvideolist_relations.videolist_id=cmsvideoslist.id');
        $this->db->join('categories', 'cmsvideolist_relations.exam_id=categories.id');
        $this->db->join('cmssubjects', 'cmsvideolist_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsvideolist_relations.chapter_id=cmschapters.id', 'left');
        $this->db->where('cmsvideoslist.id', $id);
         $this->db->where('cmsvideolist_relations.id', $relation_id);
        $this->db->from('cmsvideoslist');
        $query = $this->db->get();
         
        if($query->num_rows()>0){ 
        return $query->row();
        }else{
        return array();
        }
    }

    public function getRelatedVideos($id) {
        $this->db->select('d.videolist_id');
        $this->db->from('cmsvideolist_details d');
        $this->db->join('cmsvideos v', 'v.id=d.video_id');
        $this->db->where('v.id', $id);
        $query = $this->db->get();
        $row = $query->row();
        if($row->videolist_id>0){
        return $this->getVideosList($row->videolist_id);
        }else{
        return array();
        }
        
    }

    public function detail($id) {
        $this->db->select('*');
        $this->db->from('cmsvideoslist');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        if($query->num_rows()>0){ 
        return $query->row();
        }else{
        return array();
        }
    }

    public function playlist_detail($id) {
        $this->db->select('cmsvideoslist.name,cmsvideoslist.description,cmsvideoslist.id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->join('cmsvideolist_relations', 'cmsvideolist_relations.videolist_id=cmsvideoslist.id');
        $this->db->join('categories', 'cmsvideolist_relations.exam_id=categories.id');
        $this->db->join('cmssubjects', 'cmsvideolist_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsvideolist_relations.chapter_id=cmschapters.id', 'left');
        $this->db->where('cmsvideoslist.id', $id);
        $this->db->from('cmsvideoslist');
        $query = $this->db->get(); 
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    public function getVideosDetails($id,$vstatus=1) {
		
		if($vstatus==0){
			$vstatus=0;
		}elseif($vstatus==2){
		//2 for display all video		
        $vstatus=2;
		}else{
			
		$vstatus=1;

		}
     $this->db->select('V.id,title,V.video_source,V.video_url_code,V.video_file_name,V.video_image,V.short_video,V.is_featured,
V.description,V.video_by,V.status,V.views,V.is_free,V.video_duration
,V.custom_video_duration,V.video_size,V.androidapp_link,V.androidapp_link,V.amazonaws_link,V.amazon_cloudfront_domain
,d.videolist_id,d.video_id');
        $this->db->from('cmsvideos V');
        $this->db->join('cmsvideolist_details d', 'd.video_id=V.id');
        $this->db->where('d.videolist_id', $id);
		
		if($vstatus==0||$vstatus==1){
		//$vstatus ==1 Show video and 0=hide
        $this->db->where('V.status',$vstatus);
		}
        $this->db->order_by("V.title", "asc");
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
    public function getMergeVideosDetails($id) {
        $this->db->select('v.id,v.title as question,d.videolist_id,d.video_id');
        $this->db->from('cmsvideos v');
        $this->db->join('cmsvideolist_details d', 'd.video_id=v.id');
        $this->db->where('d.videolist_id', $id);
        $this->db->order_by("v.id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
    public function getDetails_bymoduleID_file($mid) {
        $this->db->select('*');
        $this->db->from('cmsvideolist_details');
        $this->db->join('cmsvideos', 'cmsvideos.id=cmsvideolist_details.video_id');
        $this->db->where('cmsvideolist_details.video_id>', 0);
        $this->db->where('cmsvideos.id', $mid);
        $this->db->order_by("cmsvideos.id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
   public function getRelByVid($vId,$vListId){
		//cmsvideolist_details;
        $this->db->select('R.id,R.videolist_id,R.exam_id,R.subject_id,R.chapter_id');
        $this->db->from('cmsvideolist_relations R');
		$this->db->join('cmsvideolist_details D', 'D.videolist_id=R.videolist_id');
        $this->db->where('R.videolist_id', $vListId);
		$this->db->where('D.video_id', $vId);
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
}
    public function getRelationDetail($relation_data_type) {
        $this->db->select('id,videolist_id,exam_id,subject_id,chapter_id');
        $this->db->from('cmsvideolist_relations');
        $this->db->where('videolist_id', $relation_data_type);
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    public function getRelatedPlayLists($video_id) {
        $this->db->select('id,videolist_id,video_id');
        $this->db->from('cmsvideolist_details');
        $this->db->where('video_id', $video_id);
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    public function getVideoParent($video_id) {
        $this->db->select('A.videolist_id,A.exam_id,A.subject_id,A.chapter_id,B.id,B.videolist_id,B.video_id');
        $this->db->from('cmsvideolist_relations A');
        $this->db->join('cmsvideolist_details B', 'A.videolist_id=B.videolist_id');
        $this->db->where('B.video_id', $video_id);
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    public function getRecentAmazonVideos() {
        $this->db->select('*');
        $this->db->from('cmsvideos');
        $this->db->where('video_image !=', '');
        $this->db->where('amazonaws_link !=', '');
        //$this->db->limit(8);
        $this->db->order_by('id', 'random');
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
	
    public function getAllVideos() {
        $this->db->select('*');
        $this->db->from('cmsvideos');
        $this->db->where('androidapp_link !=', '');
		$this->db->where('video_duration', '');	
        //$this->db->limit(200);
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

 public function getAllVideos1() {
        $this->db->select('*');
        $this->db->from('cmsvideos');
        $this->db->where('id', '7403');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
    public function search($search,$limit=0,$start=0) {        
        $this->db->select('V.id as videoid,V.title,V.video_url_code,V.video_image as image,R.videolist_id,R.exam_id,R.subject_id,R.chapter_id,R.created_by,L.name as playlist')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsvideos V');
        $this->db->join('cmsvideolist_details D', 'D.video_id=V.id');
        $this->db->join('cmsvideoslist L', 'D.videolist_id=L.id');
        $this->db->join('cmsvideolist_relations R', 'R.videolist_id=D.videolist_id');
        $this->db->join('categories', 'categories.id=R.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id','left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id','left');
        $this->db->like('V.title', urldecode($search));
        $this->db->where('V.status',1);
        if($limit>0){
        $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
public function search_count($search) {
        
        $this->db->select('V.id as videoid,V.title,V.video_url_code,V.video_image as image,R.*,L.name as playlist')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsvideos V');
        $this->db->join('cmsvideolist_details D', 'D.video_id=V.id');
        $this->db->join('cmsvideoslist L', 'D.videolist_id=L.id');
        $this->db->join('cmsvideolist_relations R', 'R.videolist_id=D.videolist_id');
        $this->db->join('categories', 'categories.id=R.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id','left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id','left');
        $this->db->like('V.title', urldecode($search));        
        $this->db->where('V.status',1);        
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->num_rows();
        }else{
            return 0;
        }
        
        }
    public function delete_video_byid($id) {
        //delete from cmsvideo table


        $file_check_array = $this->getDetails_bymoduleID_file($id);
        //delete file if exist
        if (count($file_check_array) > 0) {
            $file_id = $file_check_array[0]->id;

            $filename = $file_check_array[0]->video_image;
            $filepath = '/assets/videoimages/';

            $filename_one = $file_check_array[0]->video_file_name;
            $filepath_one = '/assets/videoimages/';

            $filename_two = $file_check_array[0]->short_video;
            $filepath_two = '/assets/videoimages/';
            unlink($_SERVER['DOCUMENT_ROOT'] . $filepath . $filename);
            unlink($_SERVER['DOCUMENT_ROOT'] . $filepath_one . $filename_one);
            unlink($_SERVER['DOCUMENT_ROOT'] . $filepath_two . $filename_two);


            $this->db->where('id', $file_id);
            $this->db->delete('cmsvideos');
        }
    }

    public function delete_module_videos($id) {

        //delete from cmspricelist table
        $this->db->where('modules_item_id', $id);
        $this->db->delete('cmspricelist');

        //delete from cmsncertsolutions_relations table
        $this->db->where('videolist_id', $id);
        $this->db->delete('cmsvideolist_relations');

        //delete from cmsncertsolutions_details table
        $this->db->where('videolist_id', $id);
        $this->db->delete('cmsvideolist_details');

        //delete from cmsncertsolutions table
        $this->db->where('id', $id);
        $this->db->delete('cmsvideoslist');
    }

    public function getRelations($video_id) {
        $this->db->select('*')->select('cmsvideoslist.name as playlist')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsvideolist_relations');
        $this->db->join('cmsvideolist_details', 'cmsvideolist_details.videolist_id=cmsvideolist_relations.videolist_id');
        $this->db->join('categories', 'cmsvideolist_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsvideolist_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsvideolist_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsvideoslist', 'cmsvideolist_details.videolist_id=cmsvideoslist.id', 'left');
        $this->db->where('cmsvideolist_details.video_id', $video_id);
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }

    public function getVideoList($exam_id = 0, $subject_id = 0) {
        $this->db->select('cmsvideolist_relations.id,cmsvideolist_relations.videolist_id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmsvideolist_relations');
        if ($exam_id > 0) {
            $this->db->where('exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        $this->db->join('categories', 'categories.id=cmsvideolist_relations.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=cmsvideolist_relations.subject_id');
        //$this->db->where('chapter_id',0);
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
    
 
public function getFreeVideos($palylist_id) {
$this->db->select('V.id,title,V.video_source,V.video_url_code,V.video_file_name,
V.video_image,V.short_video,V.is_featured,
V.description,V.video_by,V.status,V.views,V.is_free,V.video_duration
,V.video_size,V.custom_video_duration,V.video_size,V.amazonaws_link,V.amazon_cloudfront_domain
');
        $this->db->from('cmsvideolist_details VD');
        $this->db->where('V.video_source', 'youtube');
        $this->db->where('V.video_url_code !=', '');
        $this->db->where('V.status',1);
        $this->db->where('V.video_tag!=','Career Point');
        $this->db->join('cmsvideos V', 'V.id=VD.video_id');
        $this->db->where_in('VD.videolist_id', implode(',', $palylist_id));
        $query = $this->db->get();
        //echo $this->db->last_query()
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
    public function getExamFreeVideos($exam_id,$limit=0) {
    $this->db->select('V.id,title,V.video_source,V.video_url_code,V.video_file_name,
V.video_image,V.short_video,V.is_featured,
V.description,V.video_by,V.status,V.views,V.is_free,V.video_duration
,V.custom_video_duration,V.video_size,V.androidapp_link,V.amazonaws_link,V.amazon_cloudfront_domain
')->select('L.name as playlist,L.id as playlist_id')->select('C.name as exam')->select('S.name as subject')->select('CH.name as chapter');
        //$this->db->from('cmsvideolist_details VD');
        $this->db->from('cmsvideos V');
        $this->db->where('V.video_source', 'youtube');
        $this->db->where('V.video_url_code !=', '');
        $this->db->where('V.is_featured',1);
        $this->db->where('V.video_tag!=','Career Point');
        $this->db->join('cmsvideolist_details VD','V.id=VD.video_id');
        $this->db->join('cmsvideolist_relations R','R.videolist_id=VD.videolist_id');
        $this->db->join('categories C','C.id=R.exam_id');
        $this->db->join('cmssubjects S', 'R.subject_id=S.id', 'left');
        $this->db->join('cmschapters CH', 'R.chapter_id=CH.id', 'left');
        $this->db->join('cmsvideoslist L','L.id=VD.videolist_id');
        if($exam_id>0){
        $this->db->where('R.exam_id',$exam_id);
        }
        if($limit > 0){
        $this->db->limit($limit);
        $this->db->order_by('V.id','random');
        }
        $this->db->group_by('V.id');
        $query = $this->db->get();    
		//echo $this->db->last_query();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
    public function getAllFreeVideos($exam_id = 0, $subject_id = 0, $chapter_id = 0,$limit=0) {
$this->db->select('V.id,title,V.video_source,V.video_url_code,V.video_file_name,
V.video_image,V.short_video,V.is_featured,
V.description,V.video_by,V.status,V.views,V.is_free,V.video_duration
,V.custom_video_duration,V.video_size,V.androidapp_link,V.amazonaws_link,V.amazon_cloudfront_domain
')->select('L.name as playlist')->select('C.name as exam')->select('S.name as subject')->select('CH.name as chapter');
        //$this->db->from('cmsvideolist_details VD');
        $this->db->from('cmsvideos V');
        $this->db->where('V.video_source', 'youtube');
        $this->db->where('V.is_featured',1);
        $this->db->where('V.video_tag!=','Career Point');
        $this->db->where('V.video_url_code !=', '');
        $this->db->join('cmsvideolist_details VD', 'V.id=VD.video_id');
        $this->db->join('cmsvideolist_relations R','R.videolist_id=VD.videolist_id');
        $this->db->join('categories C','C.id=R.exam_id');
        $this->db->join('cmssubjects S', 'R.subject_id=S.id', 'left');
        $this->db->join('cmschapters CH', 'R.chapter_id=CH.id', 'left');
        $this->db->join('cmsvideoslist L','L.id=VD.videolist_id');
        if($exam_id>0){
        $this->db->where('R.exam_id',$exam_id);
        }
        if($subject_id>0){
        $this->db->where('R.subject_id',$subject_id);
        }
        if($chapter_id>0){
        $this->db->where('R.chapter_id',$chapter_id);
        }
        if($limit>0){
            $this->db->limit($limit);
            $this->db->order_by('V.id','random');
        }
        $this->db->group_by('V.id');
        $query = $this->db->get();   
		//echo $this->db->last_query();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
    public function getPlaylistDetailsByName($name){
        $this->db->select('*');
        $this->db->from('cmsvideoslist');
        $this->db->where('name',$name);
        $query=$this->db->get();
        if($query->num_rows()>0){ 
        return $query->row();
        }else{
        return array();
        }
    }    
    public function getClass_Videos(){
          $this->db->select('*')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmspricelist');
        $this->db->where('cmspricelist.type', 2);
        $this->db->join('categories', 'cmspricelist.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmspricelist.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmspricelist.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmspricelist.item_id', 'left');
        $this->db->group_by('cmspricelist.id');
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }     
      public function getChapter_Videos() {
        $this->db->select('cmsvideoslist.name,cmsvideoslist.id,cmsvideolist_relations.exam_id,cmsvideolist_relations.subject_id,cmsvideolist_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->join('categories', 'cmsvideolist_relations.exam_id=categories.id');
        $this->db->join('cmssubjects', 'cmsvideolist_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsvideolist_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsvideoslist', 'cmsvideolist_relations.videolist_id=cmsvideoslist.id');
        $this->db->from('cmsvideolist_relations');
        $this->db->order_by('cmsvideoslist.id','desc');
        $this->db->group_by('cmsvideolist_relations.videolist_id');
        $query = $this->db->get();
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
    
    public function getsitemap_Videos(){
        $this->db->select('v.title as video_name,v.id as video_id,d.videolist_id,d.video_id,vl.name,vl.id,cr.exam_id,cr.subject_id,cr.chapter_id')->select('cat.name as exam')->select('sub.name as subject')->select('chap.name as chapter');;
        $this->db->from('cmsvideos v');
        $this->db->join('cmsvideolist_details d', 'd.video_id=v.id','left');
        $this->db->join('cmsvideolist_relations cr','cr.videolist_id=d.videolist_id','left');
        $this->db->where('v.status',1);
        $this->db->join('cmsvideoslist vl', 'cr.videolist_id=vl.id','left');
         $this->db->join('categories cat', 'cr.exam_id=cat.id','left');
        $this->db->join('cmssubjects sub', 'cr.subject_id=sub.id', 'left');
        $this->db->join('cmschapters chap', 'cr.chapter_id=chap.id', 'left');        
        $this->db->where("(v.video_url_code != '' or v.amazonaws_link !='' )");
       //$this->db->group_by('cr.videolist_id');       
        $query = $this->db->get();
         //$webl = $this->db->last_query();
        //echo $webl; die;        
        if($query->num_rows()>0){ 
        return $query->result();
        }else{
        return array();
        }
    }
}
