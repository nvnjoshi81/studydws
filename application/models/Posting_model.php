<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Posting_Model extends CI_Model {
    function __construct() {
        $this->load->database();
    }
    public function add_post($post_data) {
        $this->load->model('posting_model');
        $query = $this->db->insert('postings', $post_data);
        return;
    }
    /*     * ***  Function to get listings count  for all categories **** */
    /*     * *** To-Do
     * Add category id to this  function to get count of listings for given category and subcategories
     * count_all_post($category_id=0)
     * ******* */
   public function getQuestionCount($exam_id = null, $subject_id = null, $chapter_id = null) {
       $this->db->select('id');
       $this->db->where('published', 1); 
       if($exam_id>0){
           $this->db->where('category_id',$exam_id);
       }
       $this->db->from('postings');
       $query = $this->db->get();
       //echo $this->db->last_query();
       if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
    
     public function getCronQuestionCount($exam_id = null, $subject_id = null, $chapter_id = null) {
       $this->db->select('count(id) as q_count');
       $this->db->where('published', 1); 
       if($exam_id>0){
           $this->db->where('category_id',$exam_id);
       }
       $this->db->from('postings');
       $query = $this->db->get();
       //echo $this->db->last_query();
       if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
    public function count_all_post() {
        $this->db->where('published', 1);
        return $this->db->count_all_results("postings");
    }
    public function count_search_post($search) {
        //SELECT * FROM articles WHERE MATCH (title,body) AGAINST ('comparison database' IN BOOLEAN MODE);
        $this->db->where('published', 1);
        //$this->db->where('title like', '%'.$search.'%');
        //$this->db->or_where('description like', '%'.$search.'%');
        $this->db->where('MATCH (title,description) AGAINST (\'' . urldecode($search) . '\')', NULL, FALSE);
        return $this->db->count_all_results("postings");
    }

    public function count_category_post($category_id = 0, $published = 1) {
        $this->db->select('id');
        if ($category_id > 0) {
            $this->db->where('category_id', $category_id);
        }
        if ($published == 1) {
            $this->db->where('published', $published);
        }
        $this->db->from('postings');
        return $this->db->count_all_results();
    }

    public function count_post_by_parent($category_id = 0, $published = 1, $year = null, $month = null) {
        $this->db->select('id');
        if ($month && $year) {
            $first_minute = mktime(0, 0, 0, $month, 1, $year);
            $last_minute = mktime(23, 59, 0, $month, date("t", $first_minute), $year);
            $this->db->where("dt_created BETWEEN $first_minute AND $last_minute");
        }
        if ($category_id > 0) {
            $this->db->where('top_category_id', $category_id);
        }
        if ($published == 1) {
            $this->db->where('published', $published);
        }
        $this->db->from('postings');
        return $this->db->count_all_results();
    }

    public function count_unpublish_post($category_id = 0, $published = 0) {
        $this->db->select('id');

        if ($category_id > 0) {
            $this->db->where('category_id', $category_id);
        }
        if ($published == 0) {
            $this->db->where('published', $published);
        }

        $this->db->from('postings');
        return $this->db->count_all_results();
    }

    /*     * ***  Function to get listings from all categories **** */

    /** To-Do **
      Add limit to this function getPostings($limit=10,$start=0)
     *      */
    public function getPostings($category_id = 0, $limit = 10, $start = 0) {

        $this->db->select('p.id,p.title,p.description,p.user_id,p.adtype,'
                . 'p.meta_keywords,p.meta_description,p.external_url,p.external_link,p.category_id,p.top_category_id,p.subject_id,'
                . 'p.chapter_id,p.published,p.views,p.hits,p.is_featured,c.id as category_id,c.name,c.parent_id');
        $this->db->from('postings p');
        $this->db->join('categories c', 'c.id = p.category_id');
        if ($category_id > 0) {
            $this->db->where('p.category_id', $category_id);
        }
        $this->db->where('p.published', 1);
        //$this->db->where('c.parent_id', 12);
        $this->db->limit($limit, $start);
        $this->db->order_by('p.dt_created', 'desc');
        $query = $this->db->get();
       // echo $this->db->last_query();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getSearchPostings($search, $limit = 10, $start = 0) {

        $this->db->select('*');
        $this->db->from('postings');
        $this->db->where('published', 1);
        //$this->db->where('title like', '%'.$search.'%');
        //$this->db->or_where('description like', '%'.$search.'%');
        $this->db->where('MATCH (title,description) AGAINST (\'' . urldecode($search) . '\')', NULL, FALSE);
        $this->db->limit($limit, $start);
        $this->db->order_by('dt_created', 'desc');
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getPostingby($id) {
        $this->db->select('*');
        $this->db->from('postings');
        $this->db->where('category_id', $id);
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getPostingbyUser($id, $limit = 0, $start = 0) {
        $this->db->select('postings.id,title,postings.description,adtype,external_url,external_link,dt_created,dt_modified,name');
        $this->db->from('postings,categories');
        $this->db->where('`categories`.`id`=`postings`.`category_id`');
        $this->db->where('postings.user_id', $id);
        $this->db->limit($limit, $start);
        $this->db->order_by('dt_created', 'desc');
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getPostinginfo($id) {
        $this->db->select('*');
        $this->db->from('postings');
        $this->db->where('id', $id);
        $query = $this->db->get();
		//echo $this->db->last_query();
       if($query->num_rows()>0){
        return $query->row();
        }else{
        return array();
        }
    }

    public function getPostingList($id = 0, $limit = 0, $start = 0, $status = NULL) {

        $this->db->limit($limit, $start);
        $this->db->select('postings.id,title,postings.description,adtype,external_url,external_link,hits,published,dt_created,dt_modified,name');
        $this->db->from('postings,categories');
        if ($id > 0) {
            $this->db->where('categories.id', $id);
        }
        $this->db->where('`categories`.`id`=`postings`.`category_id`');
        if ($status === 0) {
            $this->db->where('postings.published', 0);
        }
        $this->db->order_by('dt_created', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    
    
    public function getca_List($id = 0, $limit = 0, $start = 0, $status = NULL) {

        $this->db->limit($limit, $start);
        $this->db->select('postings.id,title,postings.description,adtype,external_url,external_link,hits,published,dt_created,dt_modified,name');
        $this->db->from('postings,categories');
        if ($id > 0) {
            $this->db->where('postings.top_category_id', $id);
        }
        $this->db->where('`categories`.`id`=`postings`.`category_id`');
        if ($status === 0) {
            $this->db->where('postings.published', 0);
        }
        $this->db->order_by('dt_created', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    function update_posting($id, $update_data) {
        $this->db->where('id', $id);
        $this->db->from('postings');
        $this->db->update('postings', $update_data);
        return;
    }

    public function delete_posting($id) {
        $this->db->select('external_url');
        $this->db->from('postings');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $this->db->delete('postings', array('id' => $id));
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function countHits($id, $hits) {

        $this->db->where('id', $id);
        $this->db->from('postings');
        $this->db->update('postings', array('hits' => $hits));
        return;
    }

    public function get_filter_Posting($limit = 0, $start = 0, $id) {



        $this->db->limit($limit, $start);
        $this->db->select('postings.id,title,postings.description,adtype,external_url,external_link,hits,published,dt_created,dt_modified,name');
        $this->db->from('postings,categories');
        $this->db->where('`categories`.`id`=`postings`.`category_id`');
        // if($id!=NULL){
        $this->db->where('category_id', $id);
        //}
        $this->db->order_by('dt_created', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getListingsByParent($top_category_id = 12, $limit = 25, $start = 0, $year = null, $month = null) {
        $this->db->select('p.id,p.title,p.description,p.user_id,p.adtype,'
                . 'p.meta_keywords,p.meta_description,p.external_url,p.external_link,p.category_id,p.top_category_id,p.subject_id,'
                . 'p.chapter_id,p.published,p.views,p.hits,p.is_featured,c.id as category_id,c.name,c.parent_id');
        $this->db->from('postings p');
        $this->db->join('categories c', 'c.id = p.category_id');
        $this->db->where('p.published', 1);
        $this->db->where('p.top_category_id', $top_category_id);
        if ($month && $year) {
            $first_minute = mktime(0, 0, 0, $month, 1, $year);
            $last_minute = mktime(23, 59, 0, $month, date("t", $first_minute), $year);
            $this->db->where("p.dt_created BETWEEN $first_minute AND $last_minute");
        }
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('CAST(p.dt_created AS SIGNED)', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getNextPost($current_post_id, $category_id,$subject_id=0,$chapter_id=0) {
        $this->db->select('p.id,p.title,p.description,p.user_id,p.adtype,'
                . 'p.meta_keywords,p.meta_description,p.external_url,p.external_link,p.category_id,p.top_category_id,p.subject_id,'
                . 'p.chapter_id,p.published,p.views,p.hits,p.is_featured,c.name as exam,c.id as category_id,c.name,c.parent_id,ch.name as chapter,s.name as subject');
        $this->db->from('postings p');
        $this->db->join('categories c', 'c.id = p.category_id');
        $this->db->join('cmschapters ch', 'ch.id = p.chapter_id','left');
        $this->db->join('cmssubjects s', 's.id = p.subject_id','left');
        $this->db->where('p.id = (select min(id) from postings where id > '.$current_post_id.' and category_id ='.$category_id.' and is_deleted=1)',null,false );
        if($subject_id > 0){
            $this->db->where('p.subject_id', $subject_id);
        }
        if($chapter_id > 0){
            $this->db->where('p.chapter_id', $chapter_id);
        }
        $this->db->where('p.category_id', $category_id);
        $this->db->where('p.published', 1);
        //$this->db->where('c.parent_id', 12);
        $this->db->limit(1);
        
        $query = $this->db->get();
        
        if($query->num_rows()>0){
        return $query->row();
        }else{
        return array();
        }
    }

    public function getPreviousPost($current_post_id, $category_id,$subject_id=0,$chapter_id=0) {
        $this->db->select('p.id,p.title,p.description,p.user_id,p.adtype,'
                . 'p.meta_keywords,p.meta_description,p.external_url,p.external_link,p.category_id,p.top_category_id,p.subject_id,'
                . 'p.chapter_id,p.published,p.views,p.hits,p.is_featured,c.name as exam,c.id as category_id,c.name,c.parent_id,ch.name as chapter,s.name as subject');
        $this->db->from('postings p');
        $this->db->join('categories c', 'c.id = p.category_id');
        $this->db->join('cmschapters ch', 'ch.id = p.chapter_id','left');
        $this->db->join('cmssubjects s', 's.id = p.subject_id','left');
        $this->db->where('p.id = (select max(id) from postings where id < '.$current_post_id.' and category_id ='.$category_id.' and is_deleted=1)',null,false );
        if($subject_id > 0){
            $this->db->where('p.subject_id', $subject_id);
        }
        if($chapter_id > 0){
            $this->db->where('p.chapter_id', $chapter_id);
        }
        $this->db->where('p.category_id', $category_id);
        $this->db->where('p.published', 1);
        //$this->db->where('c.parent_id', 12);
        $this->db->limit(1);

        $query = $this->db->get();
       
        if($query->num_rows()>0){
        return $query->row();
        }else{
        return array();
        }
    }

    public function getFeaturedPostings($top_category_id) {
        $this->db->select('p.id,p.title,p.description,p.user_id,p.adtype,'
                . 'p.meta_keywords,p.meta_description,p.external_url,p.external_link,p.category_id,p.top_category_id,p.subject_id,'
                . 'p.chapter_id,p.published,p.views,p.hits,p.is_featured,c.id as category_id,c.name,c.parent_id');
        $this->db->from('postings p');
        $this->db->join('categories c', 'c.id = p.category_id');
        $this->db->where('p.top_category_id', $top_category_id);
        $this->db->where('p.published', 1);
        $this->db->where('p.is_featured', 1);
        $this->db->limit(4);
        $this->db->order_by('p.id', 'desc');
        //$this->db->order_by('id', 'RANDOM');
        $this->db->where('top_category_id', $top_category_id);
        $query = $this->db->get();
       if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getRecentPostings($top_category_id) {
        $this->db->select('p.id,p.title,p.description,p.user_id,p.adtype,'
                . 'p.meta_keywords,p.meta_description,p.external_url,p.external_link,p.category_id,p.top_category_id,p.subject_id,'
                . 'p.chapter_id,p.published,p.views,p.hits,p.is_featured,c.id as category_id,c.name,c.parent_id');
        $this->db->from('postings p');
        $this->db->join('categories c', 'c.id = p.category_id');
        $this->db->where('p.top_category_id', $top_category_id);
        $this->db->where('p.published', 1);
        $this->db->order_by('CAST(p.dt_created AS SIGNED)', 'desc');
        $this->db->limit(10);
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getTrendingPostings($top_category_id) {
        $this->db->select('p.id,p.title,p.description,p.user_id,p.adtype,'
                . 'p.meta_keywords,p.meta_description,p.external_url,p.external_link,p.category_id,p.top_category_id,p.subject_id,'
                . 'p.chapter_id,p.published,p.views,p.hits,p.is_featured,c.id as category_id,c.name,c.parent_id');
        $this->db->from('postings p');
        $this->db->join('categories c', 'c.id = p.category_id');
        $this->db->where('p.top_category_id', $top_category_id);
        $this->db->where('p.published', 1);
        $this->db->order_by('p.views', 'desc');
        $this->db->limit(10);
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getRelatedPostings($category_id) {
        $this->db->select('p.id,p.title,p.description,p.user_id,p.adtype,'
                . 'p.meta_keywords,p.meta_description,p.external_url,p.external_link,p.category_id,p.top_category_id,p.subject_id,'
                . 'p.chapter_id,p.published,p.views,p.hits,p.is_featured,c.id as category_id,c.name,c.parent_id,sb.name as subject,ch.name as chapter');
        $this->db->from('postings p');
        $this->db->join('categories c', 'c.id = p.category_id');
        $this->db->join('cmssubjects sb', 'sb.id = p.subject_id');
        $this->db->join('cmschapters ch', 'ch.id = p.chapter_id');
        $this->db->where('p.published', 1);
        $this->db->limit(15);
        $this->db->order_by('p.id', 'desc');
        //$this->db->order_by('id', 'RANDOM');
        $this->db->where('p.category_id', $category_id);
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getRecentPostingsInCategory($category_id) {
        $this->db->select('p.id,p.title,p.description,p.user_id,p.adtype,'
                . 'p.meta_keywords,p.meta_description,p.external_url,p.external_link,p.category_id,p.top_category_id,p.subject_id,'
                . 'p.chapter_id,p.published,p.views,p.hits,p.is_featured,c.id as category_id,c.name,c.parent_id');
        $this->db->from('postings p');
        $this->db->join('categories c', 'c.id = p.category_id');
        $this->db->where('p.category_id', $category_id);
        $this->db->where('p.published', 1);
        $this->db->order_by('CAST(p.dt_created AS SIGNED)', 'desc');
        $this->db->limit(10);
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getArticle($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('id,title as name ,category_id,subject_id,chapter_id');
        $this->db->from('postings');
        if ($exam_id > 0) {
            $this->db->where('category_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('chapter_id', $chapter_id);
        }
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function getArticlesForExams($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('a.*,title as name ')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');

        if ($exam_id != null && $exam_id > 0) {
            $this->db->where('a.category_id', $exam_id);
        }
        if ($subject_id != null && $subject_id > 0) {
            $this->db->where('a.subject_id', $subject_id);
        }
        if ($chapter_id != null && $chapter_id > 0) {
            $this->db->where('a.chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'a.category_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'a.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'a.chapter_id=cmschapters.id', 'left');
        $this->db->from('postings a');
        $this->db->order_by('a.dt_created', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $numrows=$query->num_rows();
        if($numrows>0){
        return $query->result();
        }else{
        return array();
        }
        }
        
        
        public function getCronArForExams($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('count(a.id) as package_count')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');

        if ($exam_id != null && $exam_id > 0) {
            $this->db->where('a.category_id', $exam_id);
        }
        if ($subject_id != null && $subject_id > 0) {
            $this->db->where('a.subject_id', $subject_id);
        }
        if ($chapter_id != null && $chapter_id > 0) {
            $this->db->where('a.chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'a.category_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'a.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'a.chapter_id=cmschapters.id', 'left');
        $this->db->from('postings a');
        $this->db->order_by('a.dt_created', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $numrows=$query->num_rows();
        if($numrows>0){
        return $query->result();
        }else{
        return array();
        }
        }
        
        
     public function getMergeArticlesForExams($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('a.*,title as name ')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');

        if ($exam_id != null && $exam_id > 0) {
            $this->db->where('a.category_id', $exam_id);
        }
        if ($subject_id != null && $subject_id > 0) {
            $this->db->where('a.subject_id', $subject_id);
        }
        if ($chapter_id != null && $chapter_id > 0) {
            $this->db->where('a.chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'a.category_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'a.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'a.chapter_id=cmschapters.id', 'left');

        $this->db->from('postings a');
        $this->db->order_by('a.dt_created', 'desc');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }else{
        return array();
        }
    }
    
    public function getExamArticleInfo($article_id) {
        $this->db->select('a.*')
                ->select('categories.name as exam,categories.id as exam_id')
                ->select('cmssubjects.name as subject,cmssubjects.id as subject_id')
                ->select('cmschapters.name as chapter,cmschapters.id as chapter_id');
        $this->db->join('categories', 'a.category_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'a.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'a.chapter_id=cmschapters.id', 'left');
        $this->db->where('a.id', $article_id);
        $this->db->from('postings a');
        $this->db->order_by('a.dt_created', 'desc');
        $query = $this->db->get();
       if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function search($search, $limit = 0, $start = 0) {
        $this->db->select('A.id,A.title')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->where('top_category_id', '21');
        $this->db->from('postings A');
        $this->db->join('categories', 'categories.id=A.category_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=A.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=A.chapter_id', 'left');
        $this->db->like('A.title', urldecode($search));
        if ($limit > 0) {
            $this->db->limit($limit, $start);
        }
        $this->db->group_by('A.id');
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }

    public function search_count($search) {
        $this->db->select('A.id,A.title')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->where('top_category_id', '21');
        $this->db->from('postings A');
        $this->db->join('categories', 'categories.id=A.category_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=A.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=A.chapter_id', 'left');
        $this->db->like('A.title', urldecode($search));
        $this->db->group_by('A.id');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getNotesList($exam_id = 0, $subject_id = 0, $chapter_id = 0,$order='desc',$limit=null) {
        $this->db->select('postings.id as id,postings.title as title,postings.category_id,postings.subject_id,postings.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('postings');
        if ($exam_id > 0) {
            $this->db->where('category_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'categories.id=postings.category_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=postings.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=postings.chapter_id', 'left');
        //$this->db->where('chapter_id',0);
        $this->db->order_by('postings.id', $order);
        $this->db->where('top_category_id', '21');
        if($limit > 0){
        $this->db->limit($limit);
        }
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
	
	    
    public function getQuestionCount1($exam_id=null,$subject_id=null,$chapter_id=null){
            $this->db->select('postings.id as id,postings.title as title,relatedpostings.category_id,relatedpostings.subject_id,relatedpostings.chapter_id');
        $this->db->from('postings');
        if ($exam_id > 0) {
            $this->db->where('relatedpostings.category_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('relatedpostings.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('relatedpostings.chapter_id', $chapter_id);
        }
        $this->db->join('relatedpostings','relatedpostings.article_id=postings.id');
        if($limit > 0){
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        return $query->result();		
    }

    public function getNotesList2($exam_id = 0, $subject_id = 0, $chapter_id = 0,$order='desc',$limit=null) {
        $this->db->select('postings.id as id,postings.title as title,relatedpostings.category_id,relatedpostings.subject_id,relatedpostings.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('postings');
        if ($exam_id > 0) {
            $this->db->where('relatedpostings.category_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('relatedpostings.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('relatedpostings.chapter_id', $chapter_id);
        }
        $this->db->join('relatedpostings','relatedpostings.article_id=postings.id');
        $this->db->join('categories', 'categories.id=relatedpostings.category_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=relatedpostings.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=relatedpostings.chapter_id', 'left');
        //$this->db->where('chapter_id',0);
        $this->db->order_by('relatedpostings.id', $order);
        $this->db->where('relatedpostings.top_category_id', '21'); //echo $this->db->last_query();
        if($limit > 0){
            $this->db->limit($limit);
        }
        $query = $this->db->get();
         //echo $this->db->last_query();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }


	    public function getRelationDetail($relation_data_type) {
        $this->db->select('id,category_id as exam_id,top_category_id,subject_id,chapter_id');
        $this->db->from('relatedpostings');
        $this->db->where('article_id', $relation_data_type);
        $query = $this->db->get();
        // echo $this->db->last_query();


if($query->num_rows()>0){
        return $query->result();
        }else{
		$this->db->select('postings.id as id,postings.title as title,postings.category_id as exam_id,postings.subject_id,postings.chapter_id');
        $this->db->from('postings');
        $this->db->where('postings.id', $relation_data_type);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
		
		}

    }

    public function getNotesCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('*');
        $this->db->from('postings');

        if ($exam_id > 0) {
            $this->db->where('category_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('chapter_id', $chapter_id);
        }
        $this->db->where('top_category_id', '21');
        $query = $this->db->get(); 
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
    public function getNotesCount2($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('*');
        $this->db->from('relatedpostings');

        if ($exam_id > 0) {
            $this->db->where('category_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('chapter_id', $chapter_id);
        }
        $this->db->where('top_category_id', '21');
        $query = $this->db->get();
       if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
    //For site map Notes
     public function getPosting_sitemap($top_category_id) {
        $this->db->select('postings.id as id,postings.title as title,postings.category_id,postings.subject_id,postings.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('postings');
        $this->db->join('categories', 'categories.id=postings.category_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=postings.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=postings.chapter_id', 'left');
        //$this->db->where('chapter_id',0);
        $this->db->order_by('ABS(exam)', 'asc');
        $this->db->where('top_category_id', $top_category_id);
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
    
   


}
