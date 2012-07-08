<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signoff extends CI_Controller {

	public function index()
	{		
		$this->load->library('session');
		$this->load->helper('url');
		$this->session->unset_userdata('twitter_id');
		$this->session->unset_userdata('twitter_name');
		$this->session->unset_userdata('oauth_token');
		$this->session->unset_userdata('oauth_token_secret');
		redirect('/', 'location', 301);
	}
			
}
