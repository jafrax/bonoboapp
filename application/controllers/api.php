<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER API BONOBO
* This Api system for tranfers data using external apps, support for android, ios, windows mobile
*
* Log Activity : ~ Create your log if change this controller ~
. 1. Create 12 Juni 2015 by Heri Siswanto, Create controller
*/



class Api extends CI_Controller {

	function __construct(){
        parent::__construct();
    }
	
	private function isValidApi($api_key){
		if($api_key == "BONOBO-APP-01"){
			return true;
		}else{
			return false;
		}
	}
	
	public function index(){
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			$this->response->send(array("result"=>0,"message"=>"Applikasi anda tidak terdaftar.","messageCode"=>01), true);
			return;
		}
	
		$this->response->send(array("result"=>1,"products"=>array(1,2,3),"carts"=>array(1,2,3),"messages"=>array(1,2,3)), true);
	}
	
}

