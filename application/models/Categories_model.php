<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categories_model extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
        
    }
    
    public function getPostingCategories($parent_id = null)
    {
        $this->db->select('id,name,order');
        $this->db->from('categories');
        if ($parent_id) {
            $this->db->where('parent_id', $parent_id);
        }
        if(isset($_SESSION['loggedincatperms'])){
            $this->db->where_in('id',implode(',',$_SESSION['loggedincatperms']));
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getCategories($parent_id = null)
    {
        $this->db->select('id,name,order');
        $this->db->from('categories');
        //if($parent_id){
        $this->db->where('parent_id', 0);
        //}
        $query = $this->db->get();
        return $query->result();
    }
    
   
    
    public function getCategoriesbyname($name)
    {
        $this->db->select('id,name,order');
        $this->db->from('categories');
        $this->db->like('LOWER(name)',strtolower($name),'after');
        $query = $this->db->get();
		return $query->result();
    }
    
    public function getCategoryDetails($id)
    {
        $this->db->select('id,legacy_id,name,order,created,parent_id,description,keywords,tagline,link,status');
        $this->db->from('categories');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getCategoryid($category)
    {
        $this->db->select('id,parent_id');
        $this->db->from('categories');
        $this->db->where('name', $category);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function getPrentName($id)
    {
        $this->db->select('id,name,order');
        $this->db->from('categories');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function hasSubcategory($id)
    {
        $this->db->select('id');
        $this->db->from('categories');
        $this->db->where('parent_id', $id);
        $query = $this->db->get();
        return count($query->result());
    }
    
    public function getParentCategories()
    {
        $this->db->select('id,name,order');
        $this->db->from('categories');
        $this->db->where('parent_id', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getSubCategories($parent_id)
    {
        $this->db->select('id,name,order');
        $this->db->from('categories');
        $this->db->where('parent_id', $parent_id);
        //$this->db->limit($limit,$start);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getFilterCategories($limit = 0, $start = 0, $parent_id)
    {
        $this->db->select('id,name,order');
        $this->db->from('categories');
        $this->db->where('parent_id', $parent_id);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }
    public function getSearchCategories($limit = 0, $start = 0, $name)
    {
        $this->db->select('id,name,order');
        $this->db->from('categories');
       $this->db->like('name',$name,'after');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getPosting($limit = 20, $start = 0)
    {
        $this->db->select('id,name,order');
        $this->db->from('categories');
        $this->db->limit($limit, $start);
        $this->db->order_by('created', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getcategoriesCount($id = 0)
    {
        if ($id == 0) {
            return $this->db->count_all("categories");
        } else {
            $this->db->select('id,legacy_id,name,order,created,parent_id,description,keywords,tagline,link,status');
            $this->db->from('categories');
            $this->db->where('parent_id', $id);
            return $this->db->count_all_results();
        }
    }
    
    public function get_pageCategories($limit = 0, $start = 0)
    {
        $this->db->select('id,name,order,parent_id');
        $this->db->from('categories');
        if (!empty($status)) {
            $this->db->where('verified', $status);
        }
        if($_SESSION['usertype'] != 1 && isset($_SESSION['loggedincatperms'])){
            //foreach($_SESSION['loggedincatperms'] as $k=>$v){
               
                $this->db->where("id in ('".implode("','",$_SESSION['loggedincatperms'])."')");
            //}
            
        }
        $this->db->limit($limit, $start);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
        
    }
    public function add_categories($data)
    {
        
        $this->db->insert('categories', $data);
        return;
        
    }
    public function update_categories($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('categories', $data);
        return;
    }
    public function deleteCategory($id)
    {
        $this->db->delete('categories', array(
            'id' => $id
        ));
        return;
    }
    public function fetchCategoryTree($parent_id = 0, $spacing = '', $user_tree_array = '')
    {     
        if (!is_array($user_tree_array))
            $user_tree_array = array();
        
        $this->db->from('categories');
        $this->db->where('parent_id', $parent_id);
        $result = $this->db->get()->result();
   
        //if (mysql_num_rows($query) > 0) {
        foreach ($result as $mainCategory) {
             if($_SESSION['usertype'] == 1 || in_array($mainCategory->id, $_SESSION['loggedincatperms'])){
            $user_tree_array[] = array(
                "id" => $mainCategory->id,
                "name" => $spacing . $mainCategory->name
            );
             }
            $user_tree_array   = $this->fetchCategoryTree($mainCategory->id, $spacing . '&nbsp;&nbsp;', $user_tree_array);
            //}
        }
        return $user_tree_array;
    }
    
    
    
    public function getCategoryTree($parent_id = 0)
    {
        $categories = array();
        $this->db->from('categories');
        $this->db->where('parent_id', $parent_id);
        $result = $this->db->get()->result();
        foreach ($result as $mainCategory) {
            $category                      = array();
            $category['id']                = $mainCategory->id;
            $category['name']              = $mainCategory->name;
            $category['parent_id']         = $mainCategory->parent_id;
            $category['sub_categories']    = $this->getCategoryTree($category['id']);
            $categories[$mainCategory->id] = $category;
        }
        return $categories;
    }
    public function getAllSubCategories($parent_id = 0)
    {
        $categories = array();
        $this->db->from('categories');
        $this->db->where('parent_id', $parent_id);
        $result = $this->db->get()->result();
        foreach ($result as $mainCategory) {
            $categories[]                   = $mainCategory->id;
            $category                      = array();
            $category['id']                = $mainCategory->id;
            $category['name']              = $mainCategory->name;
            $category['parent_id']         = $mainCategory->parent_id;
            $category['sub_categories']    = $this->getCategoryTree($category['id']);
            //$categories[$mainCategory->id] = $category;
        }
        return $categories;
    }
    public function getCategoryDropDown($parent_id = 0, $pre = null)
    {
        $categories = array();
        $str        = '';
        $this->db->from('categories');
        $this->db->where('parent_id', $parent_id);
        $result = $this->db->get()->result();
        foreach ($result as $mainCategory) {
            if ($mainCategory->parent_id == 0) {
                $pre = '';
            }
            $str .= '<option value="' . $mainCategory->id . '">' . $pre . $mainCategory->name . '</option>';
            //$category = array();
            //$category['id'] = $mainCategory->id;
            //$category['name'] = $mainCategory->name;
            //$category['parent_id'] = $mainCategory->parent_id;
            $pre = '&nbsp';
            $str .= $this->getCategoryDropDown($mainCategory->id, $pre);
            //$categories[$mainCategory->id] = $category;
        }
        return $str;
    }
    
    public function fetchCategoryTreeList($parent_id = 0, $user_tree_array = '')
    {
        if (!is_array($user_tree_array))
            $user_tree_array = array();
        
        $this->db->from('categories');
        $this->db->where('parent_id', $parent_id);
        $result = $this->db->get()->result();
        
        $user_tree_array[] = "<ul>";
        foreach ($result as $mainCategory) {
            $user_tree_array[] = "<li>" . $mainCategory->name . "</li>";
            $user_tree_array   = $this->fetchCategoryTreeList($mainCategory->id, $user_tree_array);
        }
        $user_tree_array[] = "</ul>";
        return $user_tree_array;
        /*
        <ul>
        <?php
        $res = fetchCategoryTreeList();
        foreach ($res as $r) {
        echo  $r;
        }
        ?>
        </ul>
        */
    }
    public function getParents($id = NULL, $ids = array())
    {
        if($id == NULL) {
        return false;
        }
        $this->db->select("parent_id");
        $this->db->where("id", $id);
        $result = $this->db->get("categories");
        if ($result->num_rows() == 0) {
        return false;
        }
        $record = $result->first_row();
        $ids[]  = $id;
        if ($record->parent_id == 0) {
        }else{
        $ids = $this->getParents($record->parent_id, $ids);
        }
        return $ids;
    }
    
   public function getArticlesArchives(){
    $query=   $this->db->query('SELECT Year( FROM_UNIXTIME( `dt_created` ) ) as year, MONTHNAME( FROM_UNIXTIME( `dt_created` ) ) as month, Count( * ) as postcount
    FROM postings
    WHERE top_category_id=12 and FROM_UNIXTIME( `dt_created` ) <= CURDATE( )
    GROUP BY year, month order by year desc');
    return $query->result();
   }
   public function getCA_Archives(){
    $query=   $this->db->query('SELECT Year( FROM_UNIXTIME( `dt_created` ) ) as year, MONTHNAME( FROM_UNIXTIME( `dt_created` ) ) as month, Count( * ) as postcount FROM postings WHERE top_category_id='.CA_CATEGORY_ID.' and FROM_UNIXTIME( `dt_created` ) <= CURDATE( ) GROUP BY year, month order by year desc');
    return $query->result();
   }   
// GET ARCHIVES BY MONTH & YEAR
    /*SELECT Year( FROM_UNIXTIME( `dt_created` ) ) , MONTHNAME( FROM_UNIXTIME( `dt_created` ) ) , Count( * )
    FROM postings
    WHERE FROM_UNIXTIME( `dt_created` ) <= CURDATE( )
    GROUP BY Year( FROM_UNIXTIME( `dt_created` ) ) , Month( FROM_UNIXTIME( `dt_created` ) ) */
}