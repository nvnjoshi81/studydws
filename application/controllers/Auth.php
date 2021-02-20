<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
public function __construct(){
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Cart_model');
		//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    }
    public function facebook(){
        require(APPPATH.'/third_party/fbsdk/Facebook/autoload.php');
	$this->config->load('facebook');
	$fb = new Facebook\Facebook([
	  'app_id'     => $this->config->item('appId'),
	  'app_secret' => $this->config->item('secret') ,
	  'default_graph_version' => 'v2.5',
	]);
	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['public_profile,email']; // optional
	$loginUrl = $helper->getLoginUrl(base_url().'auth/fbcallback', $permissions);
	redirect($loginUrl);
		
    }
    public function fbcallback(){
        require(APPPATH.'/third_party/fbsdk/Facebook/autoload.php');
	$this->config->load('facebook');
	$fb = new Facebook\Facebook([
	  'app_id'     => $this->config->item('appId'),
	  'app_secret' => $this->config->item('secret') ,
	  'default_graph_version' => 'v2.5',
	]);
	$helper = $fb->getRedirectLoginHelper();  
  	try {  
            $accessToken = $helper->getAccessToken();  
	} catch(Facebook\Exceptions\FacebookResponseException $e) {  
            // When Graph returns an error  
            echo 'Graph returned an error: ' . $e->getMessage();  
            exit;  
	} catch(Facebook\Exceptions\FacebookSDKException $e) {  
            // When validation fails or other local issues  
            echo 'Facebook SDK returned an error: ' . $e->getMessage();  
            exit;  
	}  
	if (! isset($accessToken)) {  
            if ($helper->getError()) {  
                header('HTTP/1.0 401 Unauthorized');  
		echo "Error: " . $helper->getError() . "\n";
		echo "Error Code: " . $helper->getErrorCode() . "\n";
		echo "Error Reason: " . $helper->getErrorReason() . "\n";
		echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {  
                header('HTTP/1.0 400 Bad Request');  
                echo 'Bad request';  
            }  
            exit;  
        }  
        $oAuth2Client = $fb->getOAuth2Client();  
        // Get the access token metadata from /debug_token  
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);  
	//echo '<h3>Metadata</h3>';  
	//var_dump($tokenMetadata);  
	// Validation (these will throw FacebookSDKException's when they fail)  
	$tokenMetadata->validateAppId($this->config->item('appId'));  
	// If you know the user ID this access token belongs to, you can validate it here  
	// $tokenMetadata->validateUserId('123');  
	//$tokenMetadata->validateExpiration();   
	if (! $accessToken->isLongLived()) {  
            // Exchanges a short-lived access token for a long-lived one  
            try {  
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);  
            } catch (Facebook\Exceptions\FacebookSDKException $e) {  
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>";  
                exit;  
            } 
            echo '<h3>Long-lived</h3>';  
            //var_dump($accessToken->getValue());  
	}
        $_SESSION['fb_access_token'] = (string) $accessToken;  
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me', $_SESSION['fb_access_token'] );
	
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
	}
        $user = $response->getGraphUser();
	
        if($user){
            $user_id=null;
            //  Check if user is already there and login else register and login
            $dbuser=$this->Customer_model->isFbUser($user['id']);
            if($dbuser){
                $this->loginuser($dbuser);
                
	}else{

 //If email already exist
 $account_email=array_key_exists('email',$user)?$user['email']:'';
                 if($account_email!=''){           
		         $account_email_status=$this->Customer_model->checkemail($account_email);
				 //false Email found and email not found = true 

				 }else{
				 $account_email_status=true;
				 //email not found
				 }
                          if($account_email_status==false){
                             //echo 'Email exist Update.Here $account_email_status=false means user exist and true means user no avilable.';
                            $data=array(
                'fbid'=>$user['id'],
		        'password'=>(string) $accessToken,
				'is_social'=>1,
				'status'=>1,
				'modified_dt'=>time());
                            $user_info=$this->Customer_model->updateByEmail($account_email,$data);
							$user_id=$user_info->id;
                          }else{

            $data=array('firstname'=>$user['name'],
                'email'=>array_key_exists('email',$user)?$user['email']:'',
		'fbid'=>$user['id'],
		'password'=>(string) $accessToken,
		'status'=>1,
		'is_social'=>1,
		'created_dt'=>time(),
            'mobile_verified'=>'1');
            $user_id=$this->Customer_model->register($data);
						  }
            $user=  $this->Customer_model->getCustomerDetails($user_id);
            logdata($user,'facebook');	
            $this->loginuser($user);
        }
        if($this->cart->total()>0){
                        redirect('/cart'); 
                        }else{
			redirect('/customer');
                        }
    }else{
                        redirect('/login');
    }		

    }
    public function twitter(){	
    $this->load->library(array('twconnect'));
	$ok = $this->twconnect->twredirect('auth/callback');
    }
    public function callback(){
    $this->load->library(array('twconnect'));
	$ok = $this->twconnect->twprocess_callback();
	if ( $ok ) {
            $this->twconnect->twaccount_verify_credentials();
            $user_profile = $this->twconnect->tw_user_info;
/*
            $authtoken=$this->input->get('oauth_token');
			if($authtoken){
			$authtoken=$this->input->get('oauth_token');
            }else{
			$authtoken=NULL;
			}

			$authverifier=$this->input->get('oauth_verifier');
            if(isset($authverifier)){
			$authverifier=$this->input->get('oauth_verifier');
			}else{
			$authverifier=NULL;
			}
			*/
			
			$authverifier=$this->input->get('oauth_verifier');
			$authtoken=$this->input->get('oauth_token');

            $dbuser=$this->Customer_model->isTwitterUser($user_profile->id);
            if($dbuser){
                $this->loginuser($dbuser);
            }else{
                $data=array('firstname'=>$user_profile->name,
                    'email'=>'',
                    'twitterid'=>$user_profile->id,
                    'password'=>'',
                    'is_social'=>1,
                    'status'=>1,
                    'created_dt'=>time(),
                    'mobile_verified'=>'1');
                $user_id=$this->Customer_model->register($data);
                $user=  $this->Customer_model->getCustomerDetails($user_id);
                $this->loginuser($user);
		logdata($user,'twitter');	
		}
			 if($this->cart->total()>0){
                           redirect('/cart'); 
                        }else{
			redirect('/customer');
                        }
		}else{
			redirect('/login');
		}
	}

	public function googleplus(){
        require_once APPPATH.'libraries/google-api-php-client/src/Google/autoload.php';        // or wherever autoload.php is located
  		
		$client = new Google_Client();
		$client->setAuthConfigFile('client_secret.json');
		$client->setScopes(array("https://www.googleapis.com/auth/plus.me",'https://www.googleapis.com/auth/userinfo.email'));
    		$client->setAccessType('offline');
                $client->setApprovalPrompt('force');
    		$client->setRedirectUri(base_url().'auth/googleplus');
    		if($this->input->get('code')){
			$client->authenticate($this->input->get('code'));
			$plus = new Google_Service_Plus($client);
			$uinfo=$plus->people->get("me");
			$uid=$uinfo->id;				
			$account_email=$uinfo->emails[0]->value;
			$account_name=$uinfo->displayName;
			$dbuser=$this->Customer_model->isGooglePlusUser($uid);
			if($dbuser){
                            logdata($dbuser,'googleplus');	
                            $this->loginuser($dbuser);	
			}else{
                            //If email already exist
                            
		         $account_email_status=$this->Customer_model->checkemail($account_email);
                          if($account_email_status==false){
                             //echo 'Email exist Update.Here $account_email_status=false means user exist and true means user no avilable.';
                            $data=array(
                                'googleplusid'=>$uid,
				'is_social'=>1,
				'status'=>1,
				'modified_dt'=>time());
                            $this->Customer_model->updateByEmail($account_email,$data);
                          }else{
                            //Create firstname if blank
                            if($account_name!=''){
                            $firstname=$account_name;
                            }else{
                            $email_array = explode("@",$account_email);
                            $firstname = $email_array[0];
                            }
                             $data=array('firstname'=>$firstname,
                                'email'=>$account_email,
                                'googleplusid'=>$uid,
				'password'=>'',
				'is_social'=>1,
				'status'=>1,
				'created_dt'=>time(),
                                'mobile_verified'=>'1');
                            $user_id=$this->Customer_model->register($data);
                        }
                        $dbuser=$this->Customer_model->isGooglePlusUser($uid);
			if($dbuser){
                            logdata($dbuser,'googleplus');	
                        $this->loginuser($dbuser);	
                        }
			}
                        
                        if($this->cart->total()>0){
                           redirect('/cart'); 
                        }else{
			redirect('/customer');
                        }
		 }else{
		  $auth_url = $client->createAuthUrl();
		  
  		  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
		}
		
	}
        public function loginuser($login){
            if($login){
                //if($login->status==0){
                //     $response=array('status'=>0,'error'=>'Email not verified');
                //}else{
                    if($login->mobile == ''){
                        $this->session->set_userdata('ask_mobile',1);
                    }
                    if($login->mobile_verified == 0){
                        $this->session->set_userdata('ask_mobile_verification',1);
                        $this->session->set_userdata('ask_mobile_no', $login->mobile);
                    }
                    $this->cart->product_name_rules = '\d\D';
                    $this->load->model('Questionbank_model');
                    $this->load->model('Samplepapers_model');
                    $this->load->model('Content_model');
                    $this->load->model('Pricelist_model');
                    $this->session->set_userdata('logged_in',1);
                    $this->session->set_userdata('customer_id',$login->id);
                    $this->session->set_userdata('customer_name',$login->firstname);
                    $this->session->set_userdata('customer_fullname',$login->firstname.' '.$login->lastname);
                    $customer_cart=$this->Cart_model->getCustomerCart($login->id);
                    $citems=array();
                    if($customer_cart){
                        $cartitems=$this->Cart_model->getCartItems($customer_cart->id);
                        if($cartitems){
                            foreach($cartitems as $item){
                                $product=$this->Pricelist_model->getDetails($item->product_id);
                                $name=null;

                                $citems[]=array('id'=>$item->product_id,'qty'=>$item->quantity,'price'=>$product->price,'name'=>$product->modules_item_name);
                            }
                        }

                        if(count($citems) > 0) $this->cart->insert($citems);
                    }

                    if($this->cart->total_items() > 0){
                        $this->Customer_model->emptyCart($login->id);

                        foreach ($this->cart->contents() as $citem){

                            $addtocart=$this->Customer_model->addToCart($login->id,$citem['id'],$citem['qty'],$citem['price']);   

                        }
                    }
                    // get purchased products 
                    $products=$this->Customer_model->getCustomerProucts($login->id);
                    $purchased=array();
                    if($products){
                       foreach($products as $key=>$product){

                               $purchased[$product->product_type][]=$product->product_id;

                       }
                    }
                    //print_r($purchased);
                    $this->session->set_userdata('purchases',$purchased);
                //}
            }
        }
	
}