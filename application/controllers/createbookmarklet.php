<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createbookmarklet extends CI_Controller {

	public function index()
	{
		public function bookmarklet($longurl)
		{
				$this->load->model('shorturl_model');
				$shorturl = new Shorturl_model();
				if ($surl = $shorturl->createShortUrl($longurl)) {
					echo $surl;
					//$data['shorturl'] = $surl;
			    	//$this->load->view('bookmarklet_display_shorturl', $data);
				} else {
			    	echo 'error creating short url. . .try again';
				}
		}
	}
			
}

