<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redirect extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');
		echo current_url();
	}
}

