<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Category extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        
  
    }

    public function categories_get($id=0)
    {
        $p_categories=$this->Categories_model->getCategoryTree($id);

        

                  
            if ($p_categories)
            {
                // Set the response and exit
                $this->response([
                    'status' => 1,
                    'data' => $p_categories
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => 0,
                    'error' => 'No categories found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
              
    }

    

}
