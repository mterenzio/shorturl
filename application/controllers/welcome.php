<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		require_once(APPPATH.'classes/epicenter/EpiCurl.php');
		require_once(APPPATH.'classes/epicenter/EpiOAuth.php');
		require_once(APPPATH.'classes/epicenter/EpiTwitter.php');
		$toauthkey = get_cfg_var('aws.param4');
		$toauthksecret = get_cfg_var('aws.param5');
		$twitterObj = new EpiTwitter($toauthkey, $toauthksecret);	
		if ($this->session->userdata('twitter_id')) {
				echo $this->session->userdata('oauth_secret');	
		    try {
		    	$twitterObj->setToken($this->session->userdata('oauth_token'), $this->session->userdata('oauth_secret'));
		    	$twitterInfo = $twitterObj->get_accountVerify_credentials();
		    	$twitterInfo->response;
		    }catch(EpiTwitterServiceUnavailableException $e){
		         echo 'Twitter is unavaiable. That stinks but there is nothing we can do.';
		         exit;
		     }catch(Exception $e){
				 echo $e;
		         echo "Something unknown is wrong with our connection with twitter. Please try back later.";
		         exit;
		    }    
		    $logon = "Welcome, ".$twitterInfo->name."<br/>";
		} else {
			try {
				$url = $twitterObj->getAuthorizeUrl();
				//header("Location: ".$url);
				$logon = "<a href=\"".$url."\">Sign in</a><br/>";
	    	 }catch(Exception $e){
	         	echo $e;
	         	exit;
	    	}  
		}
		$data['logon'] = $logon;
		$this->load->view('welcome_message', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */