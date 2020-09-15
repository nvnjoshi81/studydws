<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Reporterrors_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $this->db->insert('cms_reporterrors', $data);
        $id = $this->db->insert_id();
        return $id;
    }

}
