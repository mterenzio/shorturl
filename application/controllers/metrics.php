<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metrics extends CI_Controller {

	public function index()
	{		
		$this->load->model('auth_model');
		if ($this->auth_model->checkAuth()) {
			echo "latest stats";
			
		} else {
			echo "must be signed in to see metrics";
		}
	}
			
}
