<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metrics extends CI_Controller {

	public function index()
	{		
		$this->load->model('auth_model');
		if ($this->auth_model->checkAuth()) {
			echo "latest stats";
			$this->load->model('shorturl_model');
			$items = $this->shorturl_model->getAllByUser($this->session->userdata('twitter_id'));
			echo print_r($items);			
		} else {
			echo "must be signed in to see metrics";
		}
	}
			
}
