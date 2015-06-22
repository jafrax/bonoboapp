<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER INDEX WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
. 1. Create 12 Juni 2015 by Heri Siswanto, Create controller
. 2. Change 22 Juni 2015 by Dinar Wahyu Wibowo, Change Index
*/

class Index extends CI_Controller {

	function __construct(){
        parent::__construct();
    }
	
	public function index(){

		$this->load->view("login/bg_login");		
	}

	public function signup(){
		$this->load->view("login/bg_signup");
	}
}

