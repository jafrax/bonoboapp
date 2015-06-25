<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER DASHBOARD WEBSITE
* This controler for screen dashboard
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 23 Juni 2015 by Heri Siswanto, Create function : index
*/

set_time_limit (99999999999);

class Toko extends CI_Controller {

	function __construct(){
        parent::__construct();
		
		$this->load->model("enduser/model_toko");
		
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/');
			return;
		}
    }
	
	public function index(){
		$this->template->bonobo_step("enduser/toko/bg_dashboard");
	}
	
	
}

