<?php 
class Email_promotion extends MY_Admincontroller
{

public function __construct()
	 {
               parent::__construct();
               $this->load->library("pagination");
               $this->load->model('Customer_model');
               
    }
    public function index($page=0)
  {
                $totalEmail=$this->Customer_model->getAllEmailCount();
                $this->data['totalEmail']=$totalEmail;
                $this->data['content']='email_promotion/index';
                $this->load->view('common/template',$this->data);
  }
  
  public function sendMail(){
      
      $allEmails=$this->Customer_model->getAllEmails();
      //print_r($allEmails);
      
      /*$config = Array(       
            'protocol' => 'sendmail',
            'smtp_host' => 'your domain SMTP host',
            'smtp_port' => 25,
            'smtp_user' => 'SMTP Username',
            'smtp_pass' => 'SMTP Password',
            'smtp_timeout' => '4',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );*/
      
      $config = Array(       
            'protocol' => 'sendmail',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1' );
      
      $this->load->library('email',$config);
      $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
$this->email->set_header('Content-type', 'text/html');
$website_email=$this->config->item('text_admin_email_main');
$website_name=$this->config->item('text_website_name');

$this->email->from($website_email, $website_name);
      foreach($allEmails as $info){
        $toEmail=$info->email;
        if($toEmail=='naveen.synsoft@gmail.com'){
        $this->email->to($toEmail);
        //$this->email->cc('another@another-example.com');
        //$this->email->bcc('them@their-example.com');
        if($info->firstname!=''){
            $studentname=$info->firstname;
        }elseif($info->lastname!=''){
            $studentname=$info->lastname;
        }else{
            $studentname=$info->email;
        }       
        $this->email->subject('Up to 40% off on all Study Material and Video lectures-Studyadda.com');
        $emailText='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>A Simple Responsive HTML Email</title>
        <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;}  
        </style>
    </head>
    <body yahoo bgcolor="#f6f8f1">
        <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                                Hello <b>'.$studentname.'</b>!,<br>
                            </td>
                        </tr>
                         <tr>
                            <td>&nbsp;<br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Now get All videos and studymaterial at 40-50% discount.Please login to <a href="www.studyadda.com/login">'.$website_name.'</a> .Also '.$website_name.' offers free study packages for AIEEE, IIT-JEE, CAT, CBSE, CMAT, CTET and others. Get sample papers for all India entrance examsStudyAdda offers free study packages for AIEEE, IIT-JEE, CAT, CBSE, CMAT, CTET and others. Get sample papers for all India entrance exams.<br>
                                    Only portal providing FREE study material, Sample Papers, Solved Papers, Question bank, Online Tests, Blogs, News of more than 50 engineering, medical & management exams conducted in India.
                        </td>
                        </tr><br>                        
  <tr><td style="text-align:right;"><span>Thanks,<br>Team '.$website_name.'</span><td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>';
        /*
        $this->data['studentname']=$studentname;
        $this->data['website_name']=$website_name;
        $this->data['content']='email_promotion/email_body';
        $body=$this->load->view('common/template',$this->data,TRUE);
        */
        $this->email->message($emailText);
        $this->email->send();
        // sleep for 10 seconds
        sleep(10);      
      }
      }
       $this->session->set_flashdata('message',"Email Sent Successfully!");
       redirect('admin/email_promotion/index');
  }
  

}
?>
