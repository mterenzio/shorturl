<?php

class Auth_model extends CI_Model {
    
	private $twitterObject;
	private $twitterInfo;
	
    public function __construct() {
		$this->load->library('session');
		require_once(APPPATH.'classes/epicenter/EpiCurl.php');
		require_once(APPPATH.'classes/epicenter/EpiOAuth.php');
		require_once(APPPATH.'classes/epicenter/EpiTwitter.php');
		$toauthkey = get_cfg_var('aws.param4');
		$toauthksecret = get_cfg_var('aws.param5');
		$this->twitterObj = new EpiTwitter($toauthkey, $toauthksecret);				     
    } 
    
    public function checkAuth() {
		if ($this->session->userdata('twitter_id')) {
			return true;
		} else {
			return false;
		}
    }

    public function getLogon() {
		if ($this->checkAuth()) {
			$this->twitterObj->setToken($this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'));	
	    try {
	    	$this->twitterInfo = $this->twitterObj->get_accountVerify_credentials();
	    	$this->twitterInfo->response;
			$logon = "Signed in as , ".$this->twitterInfo->name."<br/>";
	    }catch(EpiTwitterServiceUnavailableException $e){
	         echo 'Twitter is unavaiable. That stinks but there is nothing we can do.';
	         exit;
	     }catch(Exception $e){
			 echo $e;
	         echo "Something unknown is wrong with our connection with twitter. Please try back later.";
	         exit;
	    }  			

		} else {
			try {
				$url = $this->twitterObj->getAuthorizeUrl();
				//header("Location: ".$url);
				$logon = "<a href=\"".$url."\">Sign in with your Twitter account</a><br/>";
	    	 }catch(Exception $e){
	         	echo $e;
	         	exit;
	    	} 
		}
		return $logon;
    }
 
}

?>
