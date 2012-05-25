<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Create extends CI_Controller {

	public function index()
	{
		$this->load->helper(array('form', 'url'));	
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="formerror">', '</div>');
		$this->form_validation->set_rules('longurl', 'Longurl', 'trim|required|callback__valid_longurl|callback_nocaptcha');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('welcome_message');
		} else {
		//process form
			$this->load->model('shorturl_model');
			$shorturl = new Shorturl_model();
			if ($surl = $shorturl->createShortUrl($this->input->post('longurl'))) {
		    	echo $surl;
			} else {
		    	echo 'error creating short url. . .try again';
			}
		}
	}
	
	function _valid_longurl($longurl)
	{
		if($this->input->post('longurl'))
		{
			if(filter_var($longurl, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED) == FALSE) {
		    	$this->form_validation->set_message('_valid_longurl', 'This is not a valid url. Please include http:// if you have not.');			
				return false;
			}
		}
		return true;
	}	

	function _nocaptcha()
	{
		//no captch captcha			
						
	$proceed = false;
	$seconds = 60*10;
	//echo '<h1>Testing:</h1><p>Cookie: '.$_COOKIE['token'].'<br />Timestamp: '. $_POST['ts'].'</p>';
	if($this->input->post('ts') && $this->input->cookie('token') && $this->input->cookie('token') == md5(get_cfg_var('aws.param4').$this->input->post('ts'))) $proceed = true;

	if(!$proceed) { 
    	$this->form_validation->set_message('_nocaptcha', 'Form processing halted because of suspicious activity.');			
		return false;
	}

	if(((int)$this->input->post('ts') + $seconds) < time()) {
    	$this->form_validation->set_message('_nocaptcha', 'Too much time elapsed between loading of the form and submission. For security reasons we halted the processing try again');			
		return false;
	}
		return true;
	}	

	
}

