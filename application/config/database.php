<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$active_group 			= 'default';
$active_record 			= TRUE;
$active_online 			= FALSE;
$active_production		= FALSE;

if($active_online){
	if($hosted){
		$db['default']['hostname'] = 'localhost';
		$db['default']['username'] = 'bonobo_production';
		$db['default']['password'] = '[@v1510n3@]';
		$db['default']['database'] = 'bonobo_production';
	}else{
		$db['default']['hostname'] = 'localhost';
		$db['default']['username'] = 'bonoboxa_trial';
		$db['default']['password'] = '[@v1510n3@]';
		$db['default']['database'] = 'bonoboxa_trial';
	}
}else{
	$db['default']['hostname'] = '192.168.0.253';
	$db['default']['username'] = 'admin';
	$db['default']['password'] = 'admin';
	$db['default']['database'] = 'visione_bonobo';
}

$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = APPPATH . 'cache';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */