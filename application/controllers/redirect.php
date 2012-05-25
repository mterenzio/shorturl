<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redirect extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');
		$this->load->model('shorturl_model');
		$shorturl = new Shorturl_model();
		$result = $shorturl->updateURLCount(current_url());
		if ($result != false) {
		//store some metric here

		//301 redirect please
		header( "HTTP/1.1 301 Moved Permanently" ); 
		//header('Location: '.$result);
		} else {
		//404
		header ("HTTP/1.0 404 Not Found");
		print_r($result);
		echo $url;
		}

	}
}

