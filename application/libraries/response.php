<?php
class response {
	public function send($response, $encript=FALSE){
		if($encript){
			echo base64_encode(json_encode($response));
		}else{
			echo json_encode($response);
		}
	}
	
	public function post($parameter,$clean=TRUE){
		if(empty($_POST[$parameter])){
			return "";
		}
		
		$input = $_POST[$parameter];
		if($clean){
			$input = $this->clean($input);
		}
		return $input;
	}
	
	public function postDecode($parameter,$clean=TRUE){
		if(empty($_POST[$parameter])){
			return "";
		}
		
		$input = $_POST[$parameter];
		if($clean){
			$input = $this->clean($input);
		}
		return base64_decode($input);
	}
	
	public function get($parameter,$clean=TRUE){
		if(empty($_GET[$parameter])){
			return "";
		}
		
		$input = $_GET[$parameter];
		if($clean){
			$input = $this->clean($input);
		}
		return $input;
	}
	
	public function getDecode($parameter,$clean=TRUE){
		if(empty($_GET[$parameter])){
			return "";
		}
		
		$input = $_GET[$parameter];
		if($clean){
			$input = $this->clean($input);
		}
		return base64_decode($input);
	}
	
	public function clean($string){
		$string = mysql_real_escape_string($string);
		$string = trim($string);
		$string = strip_tags($string);
		$string = trim($string);
		return $string;
	}
	
	public function str($string=""){
		//$string = iconv("UTF-8","latin1",mb_convert_encoding($string, "UTF-8", 'HTML-ENTITIES'));
		//$string = mb_convert_encoding($string, "latin1");
		return $string;
	}
}
?>