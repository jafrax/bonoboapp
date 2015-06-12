<?php

class Facebook_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('facebook');
	}
	
	//* Only show on a tab page
	function getSignedRequest()
	{
		return $this->facebook->getSignedRequest();
	}
	
	function getAccessToken()
	{
		return $this->facebook->getAccessToken();	
	}
	
	function getUser()
	{
		return $this->facebook->getUser();
	}
	
	function userProfile()
	{
		$getUser = $this->getUser();
		$user_profile = NULL;
		
		if ($getUser) 
		{
		  try {
			// Proceed knowing you have a logged in user who's authenticated.
			$user_profile = (object) $this->facebook->api('/me');
		  } catch (FacebookApiException $e) {
			error_log($e);
			$getUser = NULL;
		  }
		}
		
		return $user_profile;
	}
	
	function getURL()
	{
		$getUser = $this->getUser();
		
		if ($getUser) 
		{
			$Url 	= $this->facebook->getLogoutUrl();
		} else {
			$Url 	= $this->facebook->getLoginUrl();
		}
		
		return $Url;
	}
}