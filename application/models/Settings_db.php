<?php
class Settings_db extends CI_Model
{
function __construct()
    {
        parent::__construct();
       $this->load->database();
        
    }
function select_settings()
{
  $query = $this->db->query("select * from settings");  // table settings not exist.
  return $query->row();

}
function insert($data){    
 $query = $this->db->query("select * from settings");
    if ($query->num_rows()==0)
     {
   $this->db->insert('settings', $data);
     } 
    else
        {
    $this->db->where('id',135);
    $this->db->update('settings',$data);
        } 

}
 
 /*public function update()  
          {  
             //data is retrive from this query  
             $query = $this->db->get('settings');  
             return $query;  
          } */
 

}

?>