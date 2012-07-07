<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Callback extends CI_Controller {

	public function index()
	{		
		$this->load->library('session');
		require_once(APPPATH.'classes/epicenter/EpiCurl.php');
		require_once(APPPATH.'classes/epicenter/EpiOAuth.php');
		require_once(APPPATH.'classes/epicenter/EpiTwitter.php');
		$toauthkey = get_cfg_var('aws.param4');
		$toauthksecret = get_cfg_var('aws.param5');
		$twitterObj = new EpiTwitter($toauthkey, $toauthksecret);	
		$twitterObj->setToken($_GET['oauth_token']);				
		try {
		    $token = $twitterObj->getAccessToken();
		    $twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
		}catch(EpiTwitterException $e){
		    echo 'We had a problem logging you in to Twitter. It\'s probably their fault. ;)';
		    $error = json_decode($e->getMessage());
		    echo $error;
		    exit;
		}catch(Exception $e){
		    echo "We had a unknown problem logging you in to Twitter. It's probably their fault. ;)";
		    $error = json_decode($e->getMessage());
		    echo $error;
		    exit;
		}
		$twitterInfo= $twitterObj->get_accountVerify_credentials();
		$twitterInfo->response;
		$this->session->set_userdata('twitter_id', $twitterInfo->id);
		$this->session->set_userdata('twitter_name', $twitterInfo->screen_name);
		$this->session->set_userdata('oauth_token', $token->oauth_token);
		$this->session->set_userdata('oauth_token_secret', $token->oauth_token_secret);
		//header("Location: ".$_COOKIE["return"]);
		redirect('/', 'location', 301);
	}
			
}





?>

