<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER PRODUK WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Dinar Wahyu Wibowo, Create controller
*/

class Nota extends CI_Controller {

	function __construct(){
        parent::__construct();
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/signin/');
			return;
		}

		//$this->load->model("enduser/model_nota");		
    }
	
	public function index(){
		$data='';

		$this->template->bonobo('nota/bg_nota',$data);
	}
}

