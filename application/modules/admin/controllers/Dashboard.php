<?php
class Dashboard extends MY_Admincontroller{
    public function __construct(){
        parent::__construct();
        
        $this->load->model('Customer_model');   
        $this->load->model('Orders_model');   
               
    }
    public function index(){
        //$logs=$this->user_model->getlog();
        //$this->data['logs']=$logs;
        $orders_count=$this->Orders_model->orderbydate();
        $this->data['orders']=$orders_count;
        $earnings=$this->Orders_model->total_earnings();
        $this->data['earnings']=$earnings->order_price;
        $customers_count=$this->Customer_model->newusers();
        $this->data['customers']=$customers_count;
        $whistory=$this->Customer_model->watch_history();
        $this->data['whistory']=$whistory;
        $downloads=$this->Customer_model->download_history();
        $this->data['downloads']=$downloads;
        $this->data['content']='dashboard/dashboard';
        $this->load->view('common/template',$this->data);
    }
    public function checkFileExist($filename,$filepath,$file_ext='pdf'){
    $document_root=$_SERVER['DOCUMENT_ROOT'];
    $filepath_de=str_replace('-', '/', $filepath);
    $source=$filepath_de.$filename.'.'.$file_ext;
     $source = urldecode($source) ;
    $source_custom=$document_root.'/upload/pdfs/'.$filename.'.'.$file_ext; 
    $source_custom = urldecode($source_custom) ;
    
    if($filename!=null){
    if(file_exists($source))
    {
        $return_filepath=$source;
    }elseif(file_exists($source_custom)){
        $return_filepath=$source_custom;
     }else{
        $return_filepath=NULL;
     }   
    }
$response['result'] = $return_filepath;
$response['count'] = count($return_filepath);
//Either you can print value or you can send value to database
echo json_encode($response);
    }
    
  
    

}
?>