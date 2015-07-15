<?php
/*
 * Author : dinarwahyu13@gmail.com
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Code extends CI_Controller {
    function __construct(){
        parent::__construct();

        //$this->load->model("enduser/model_code");
    }
    
	public function index(){
        $data['toko'] = $this->db->get('tb_activation_code');
        $this->load->view('admin/index.php',$data);
	}

    public function generator(){
        $data['toko'] = $this->db->get('tb_toko');
        $this->load->view('admin/generator.php',$data);
    }

}
