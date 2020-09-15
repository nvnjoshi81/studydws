<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Admincontroller {

	public function __construct()
	{
		parent::__construct();
               
               $this->load->model('settings_db');
              
               $this->load->helper(array('form', 'url'));
               
     }
	public function index()
	{  	
            redirect('/admin/dashboard');
	    $data['content']='dashboard/dashboard';
            $this->load->view('common/template',$data);
	}
        
	/*public function user()
	{ 
	//$data['content']='users/users';
        //$this->load->view('common/template',$data);
        }*/
	public function settings()
	{ 	
	  $data['settings_detail']=$this->settings_db->select_settings();
	  $data['content']='settings/settings';
          $this->load->view('common/template',$data);
       
	}
  public function update()
  {  
    
    $data['settings_detail']=$this->settings_db->select_settings();
    $data['content']='settings/update';
    $this->load->view('common/template',$data);
       
  }
  public function updatepass()
  {  
    $this->load->model('user_model');
    $userid=$this->input->post('userid');
    $data=array('password'=>sha1($this->input->post('cpassword')));
    $this->user_model->update_adminpass($data,$userid);
    $_SESSION['msg']='Password Changed Successfully.';
    redirect('/admin/update');
       
  }
    function do_upload()
 {
       // $config['upload_path'] = 'assets/uploads/';
          $config['upload_path']=$_SERVER['DOCUMENT_ROOT'].'/assets/images/'; 
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '1000';
		$config['max_width']  = '10241';
		$config['max_height']  = '7681';
		$config['encrypt_name']  = 'true';
        
		$this->load->library('upload', $config);
		$logoimage='';
		if ( ! $this->upload->do_upload('site_logo'))
		{
		$error = array('error' => $this->upload->display_errors());
	
		}
		else
		{
                                    $uploadresponse = array('upload_data' => $this->upload->data('site_logo'));
                                    $logoimage=$uploadresponse['upload_data']['file_name'];
                                }
                    $data = array(
                            'site_name' => $this->input->post('site_name'),
                            'site_url' => $this->input->post('site_url'),
                            'site_description' => $this->input->post('site_description')
                            );
              if(!empty($logoimage)){
        	$data['site_logo']=$logoimage;
        }
                                 
           $result = $this->settings_db->insert($data);
           $this->settings();
      }
      function getListingsFromFeed(){
      	 $this->load->library('rssparser');
      	 $itemarray=array();
      	 $feed_url=$this->input->get('feed_url');

      	 $items=$this->rssparser->set_feed_url($feed_url)->set_cache_life(30)->getFeed(10);
      	 echo '<form name="submitrsslist" id="submitrsslist" method="post" action="'.base_url().'admin/listings/add_rsslist" onsubmit="getCategoryId();">';
      	  foreach ($items as $item){
      	  	$content = $item['description'];
            preg_match('/(<img[^>]+>)/i', $content, $matches);
            if(count($matches) > 0){
              $img_url=$matches[0];
            }else{
              $img_url='';
            }
            $valuearray=array('title'=>$item['title'],'external_url'=>$img_url,'external_link'=>$item['link']);
      	  	
            ?>
      	  	<div class="input-group" >
  				<div class="input-group">
  					<input type="checkbox"  name="chkid[]" value="<?php echo urlencode(serialize($valuearray))?>" class="input-control">
  				</div>
  				<?php echo '<p>'.$item['title'].'</p>'; ?>
   				<?php  echo count($matches) > 0 ?'<p>'.preg_replace( '/(width|height)="\d*"\s/', "", $matches[0]).'</p>':'';?>
   				<?php echo '<p>'.$item['link'].'</p>';?>
   				<?php echo '<p>'.$item['pubDate'].'</p>';?>
   			
   			</div>
   			<hr>
      	  	<?php
      	  }
		?>
		<input type="hidden" name="rssfeeditems" value="rssfeeditems">
		<input type="hidden" name="rsscatgeory_id" id="rsscatgeory_id" value="">
		 <button type="submit" class="btn btn-primary">New Listing</button></form><?php
      }
  }
?>
