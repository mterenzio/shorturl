<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Create extends CI_Controller {

	public function index()
	{
		$proceed = false;
		$seconds = 60*10;
		//echo '<h1>Testing:</h1><p>Cookie: '.$_COOKIE['token'].'<br />Timestamp: '. $_POST['ts'].'</p>';
		if(isset($_POST['ts']) && isset($_COOKIE['token']) && $_COOKIE['token'] == md5('makemeamillionbucks'.$_POST['ts'])) $proceed = true;

		if(!$proceed) { 
		echo 'Form processing halted for suspicious activity';
		exit;
		}

		if(((int)$_POST['ts'] + $seconds) < time()) {
		echo 'Too much time elapsed';
		exit;
		}
		if (isset($_POST['url'])) {
			$this->load->model('shorturl');
			$shorturl = new ShortUrl();
			if ($surl = $shorturl->createShortUrl($_POST['url'])) {
		    	echo $surl;
			} else {
		    	echo 'error creating short url. . .try again';
			}
		} else {
			echo 'No long url provided.';
			exit;			
		}
	}
}

