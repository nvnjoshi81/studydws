<?php
/**
 * This is a very simple class whose purpose is to send SMS messages
 * through the Clickatell gateway, using their HTTP API. It's highly
 * recommended that you enable cUrl before using this class.
 * 
 * The class tries to load the clickatel configuration directly from
 * the application configuration. You can set the api_id, user and
 * password directly from a config file, like so (application/config/config.php):
 * 
 * $config['clickatel']['api_id'] 	= YOUR_ID;
 * $config['clickatel']['user']  	= YOUR_USER;
 * $config['clickatel']['password']	= YOUR_PASSWORD;
 * 
 * Alternativelly you can pass these parameters as an array to the class
 * constructor:
 * 
 * $this->load->library('clickatel', array('api_id' => 'YOUR_ID', 'user' => 'YOUR_USER', 'password' => 'YOUR_PASSWORD'));
 * 
 * --------------------------------------------------
 * 
 * Sample usage:
 * $this->load->library('clickatel', array('api_id' => 'YOUR_ID', 'user' => 'YOUR_USER', 'password' => 'YOUR_PASSWORD'));
 * $this->sms->send_sms('351223456789', 'This is a test message!');
 * echo $this->sms->last_reply();
 * 
 * ----------------------------------------------------
 * 
 * You can get the API ID, user and password by registering on clickatel:
 * http://www.clickatell.com/developers/clickatell_api.php
 * 
 * If you'd like for me to extend the class, send me an email with
 * the feature you'd like to see supported. :)
 * 
 * 
$url="https://bulkpush.mytoday.com/BulkSms/SingleMsgApi?feedid=347356&username=8476888678&password=wjatw&To=91".$CondidateContact."&Text=".$messtext."&time=200812110950&senderid=testSenderID";//
 * @author Diogo Osório <diogo.g.osorio@gmail.com>
 * @version 1.0
 * @package Clickatel
 */
class Sms
{
	/**
	 * Will hold the API parameters: api_id, user
	 * and password.
	 * 
	 * @var array
	 */
	private $sms;
	
	
	/**
	 * Flag to make the class aware if cUrl is
	 * enabled.
	 * 
	 * @var boolean 
	 */
	protected $curl;
	
	
	/**
	 * The Clickate API URL
	 * 
	 * @var string
	 */
	//protected $url	= 'https://bulkpush.mytoday.com/BulkSms/SingleMsgApi';
        //protected $url='http://smsworld.org/api/v1/sms/single.json';
        //'http://103.16.101.52:8080/bulksms/bulksms?username=SI12-studyadda&password=year2017&type=0&dlr=1&destination=919893020200&source=STDADA&message=sample ​'
        
	protected $url= 'http://103.16.101.52:8080/bulksms/bulksms';
	//      username=SI12-studyadda&password=year2017&type=0&dlr=1&destination=919893020200&source=STDADA&message=sample ​
                
	/**
	 * The CodeIgniter instance.
	 * 
	 * @var object
	 */
	protected $CI;
	
	
	/**
	 * The last reply received from the API.
	 * 
	 * @var string
	 */
	protected $last_reply;
	
	
	/**
	 * Loads the configuration parameters (both from the app
	 * configuration and from the passed arguments) and checks
	 * if cUrl is enabled.
	 * 
	 * If all the configuration parameters aren't found, a 
	 * 500 error will be triggered.
	 * 
	 * @param array $params			An array containing the clickatel parameters:
	 * 								api_id, user and password
	 */
	public function __construct($params = NULL)
	{
		// Get CI instance
		$this->CI =& get_instance();
		$sms = $this->CI->config->load('sms');
		// Try to get properties from the configuration
		$sms = $this->CI->config->item('sms');
        
		if($sms) $this->sms = $sms;
		
		// Override the configuration items, if an argument was passed 
		if(isset($this->sms, $params)){
			array_merge($this->sms, $params);
		} elseif(isset($params)){
			$this->sms = $params;
		}
		
		// Check if all the required options are set
		//if(!isset($this->sms['sender_id'], $this->sms['token'])){
			//show_error('You need to pass the sender_id,  token to the Clickatel library.');
		//}
		
		// cUrl is the preferred method, should it be available
		$this->curl = in_array('curl', get_loaded_extensions());
		
		// If cUrl is not enabled, warn the user
		if(!$this->curl) log_message('debug', 'It\'s highly recommended that you enable cUrl to use the sms library.');
	}
	
	
	/**
	 * Submits a message to the API.
	 * 
	 * @param mixed $to			Either a string with the number or 
	 * 							an array containing multiple numbers.
	 * 
	 * @param string $message	The message
	 * @return boolean
	 */
	public function send_sms($to, $message)
	{
		// Are there multiple receivers?
		if(is_array($to)) $to = implode(',', $to);
		
		// Prepare the message
		//$message = urlencode($message);
		
		// Build the request
		/*$request_old = array(
					'sender_id'	=> $this->sms['sender_id'],
					'token'         => $this->sms['token'],
					'msisdn'	=> $to,
					'text'		=> $message,
                                        'route'         => 'TRANS',
                                        'unicode'       =>'false',
                                        'flash'         =>'false'
                    //'time'      => 200812110950,//date('YmdHi'),
                    //'senderid'  => 'testSenderID'
				);
                */
                
               $request = array(	
					'username'      => $this->sms['username'],
                                        'password'      => $this->sms['password'],
					'type'	        => '0',
					'dlr'	        => '1',
					'destination'	=> $to,
                                        'source'	=> $this->sms['sender_id'],
					'message'	=> $message
                    );
             
                
		
		// cUrl is the preferred method to send the request
		if($this->curl){
			$ch = curl_init($this->url . '?' . http_build_query($request));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//curl_setopt($ch, CURLOPT_TIMEOUT, '5');
			//curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
			$result = trim(curl_exec($ch));
            
		} else {
			$request = $this->url . '?' . http_build_query($request);
			$result = file_get_contents($request);
		}
		
		$this->last_reply = $result;
		
		// If the reply wasn't empty, it shouldn't contain errors
		if(!empty($this->last_reply)){
			return !preg_match("/ERR/", $this->last_reply);
		}
		
		// The reply was empty
		return FALSE;
	}

	
	/**
	 * Returns the last reply received from the API.
	 * 
	 * @return mixed		Either a string with the message or FALSE if none is set.
	 */
	public function last_reply()
	{
		return isset($this->last_reply) ? $this->last_reply : FALSE;
	}

}