<?php

class ShortUrl_Model extends CI_Model {
    
    public function __construct() {
		$this->load->library('aws');
		$this->dynamodb = new AmazonDynamoDB();         
    } 
    
    public function createShortUrl($longurl) {
		$nextid = $this->generateNewID();
		$guidconvert = base_convert($nextid, 10, 36);
		$shorturl = "http://".get_cfg_var('aws.param1').'/'.$guidconvert;
		$fields = array('id' => $nextid, 'shorturl'=>$shorturl, 'longurl'=>$this->properties['url']);
		$put = $this->sdb->put_attributes(SDB_DOMAIN, $paddednextid, $fields);
		if ($put->isOK()) {
			return $shorturl;  
		} else {
			return false;
		}
    }

    public function generateNewID() {      
        $lastid = $this->getLastID();
        $nextid = $lastid + 1; 
        return $nextid;
    }
    
    public function shortExists($shorturl) {      
        $shortexists = $this->convertSelectToArray($this->getLongUrl($shorturl));
        if (isset($shortexists[0]['shorturl'])) {
            return true;
        } else {
            return false;
        }        
    }

    public function getLongUrl($shorturl) {      
        $select = $this->sdb->select("select * from ".SDB_DOMAIN." where shorturl = '$shorturl'");
        $results = $this->convertSelectToArray($select);
        if (isset($results[0]['longurl'])) {
            return $results[0]['longurl'];
        } else {
            return false;
        }        
    }

    public function getLastID() {      
        $select = $this->sdb->select("select * from ".SDB_DOMAIN." where id is not null order by id desc limit 1");
        $results = $this->convertSelectToArray($select);
        if (isset($results[0]['id'])) {
            return $results[0]['id'];
        } else {
            return false;
        }        
    }
    
    function __set($property_name, $val) {
        $this->properties[$property_name] = $val;
    }
   
    function __get($property_name) {
        if(isset($this->properties[$property_name])) {
            return($this->properties[$property_name]);
        } else {
            return(NULL);
        }
    } 
 
}

?>