<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createbookmarklet extends CI_Controller {

	public function index()
	{
		        $longurl = $this->input->get('url', TRUE);
				$this->load->model('shorturl_model');
				$shorturl = new Shorturl_model();
				if ($surl = $shorturl->createShortUrl($longurl)) {
					$data['shorturl'] = $surl;
			    	$this->load->view('bookmarklet_display_url', $data);
				} else {
			    	echo 'error creating short url. . .try again';
				}
	}
			
}

