<?php

class Shorturl_model extends CI_Model {
    
    public function __construct() {
		$this->load->library('aws');
		$this->dynamodb = new AmazonDynamoDB();         
    } 
    
    public function createShortUrl($longurl) {
		if ($nextid = $this->generateNewID()) {
			$guidconvert = base_convert($nextid, 10, 36);
			$shorturl = "http://".get_cfg_var('aws.param1').'/'.$guidconvert;
			$put = $this->dynamodb->update_item(array(
			    'TableName' => get_cfg_var('aws.param2'), 
			        'Key' => array(
			            'HashKeyElement' => array(
			                AmazonDynamoDB::TYPE_STRING => "$shorturl"
			            )
			        ),
					'Expected' => array(
						'shorturl' => array(
						            "Exists" => "false"
					)),										
			        'AttributeUpdates' => array(
			            'longurl' => array(
			                'Action' => AmazonDynamoDB::ACTION_PUT,
			                'Value' => array(
			                    AmazonDynamoDB::TYPE_STRING => "$longurl"
			                )
			            ),
			            'created' => array(
			                'Action' => AmazonDynamoDB::ACTION_PUT,
			                'Value' => array(
			                    AmazonDynamoDB::TYPE_STRING => time()
			                )
			            )									
			        )
			));
			if ($put->isOK()) {
				return $shorturl;  
			} else {
				return false;
			}
		}
    }

    private function generateNewID() {      
        $current_count = $this->getLastID();
		$next = $current_count + 1;
		$update_response = $this->dynamodb->update_item(array(
		    'TableName' => get_cfg_var('aws.param3'), 
		        'Key' => array(
		            'HashKeyElement' => array(
		                AmazonDynamoDB::TYPE_NUMBER => '1'
		            )
		        ),
				'Expected' => array(
				        'count' => array( 'Value' => array (AmazonDynamoDB::TYPE_NUMBER => "$current_count" ) )
				),
		        'AttributeUpdates' => array(
		            'count' => array(
		                'Action' => AmazonDynamoDB::ACTION_PUT,
		                'Value' => array(
		                    AmazonDynamoDB::TYPE_NUMBER => "$next"
		                )
		            )
		        )
		));
		if ($update_response->isOK())
		{
			return $next;
		}
		else
		{
			return false;
		}							
    }
    
   /* public function shortExists($shorturl) {      
        $shortexists = $this->convertSelectToArray($this->getLongUrl($shorturl));
        if (isset($shortexists[0]['shorturl'])) {
            return true;
        } else {
            return false;
        }        
    }*/

    public function getLongUrl($shorturl) {      
		$response = $this->dynamodb->get_item(array(
		    'TableName' => get_cfg_var('aws.param2'),
		    'Key' => array(
		        'HashKeyElement' => array( AmazonDynamoDB::TYPE_STRING => "$shorturl" )
		    ),
			'AttributesToGet' => array('longurl'),
			'ConsistentRead' => 'true'
		));
		if ($response->isOK())
		{
		    return (string) $response->body->Item->longurl->{AmazonDynamoDB::TYPE_STRING};
		}
		else
		{
		    return false;
		}    
    }

    private function getLastID() {      
		$response = $this->dynamodb->get_item(array(
		    'TableName' => 'counters',
		    'Key' => array(
		        'HashKeyElement' => array( AmazonDynamoDB::TYPE_NUMBER => '1' )
		    ),
			'AttributesToGet' => array('count'),
			'ConsistentRead' => 'true'
		));
		if ($response->isOK())
		{
		    return (string) $response->body->Item->count->{AmazonDynamoDB::TYPE_NUMBER};
		}
		else
		{
		    return false;
		}     
    }
    
   /* function __set($property_name, $val) {
        $this->properties[$property_name] = $val;
    }
   
    function __get($property_name) {
        if(isset($this->properties[$property_name])) {
            return($this->properties[$property_name]);
        } else {
            return(NULL);
        }
    } */
 
}

?>