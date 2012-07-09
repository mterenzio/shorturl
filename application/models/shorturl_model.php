<?php

class Shorturl_model extends CI_Model {
    
    public function __construct() {
		$this->load->library('session');
		$this->load->library('aws');
		$this->dynamodb = new AmazonDynamoDB();         
    } 
    
    public function createShortUrl($longurl) {
		if ($nextid = $this->generateNewID()) {
			$timestamp = time();
			$guidconvert = base_convert($nextid, 10, 36);
			$shorturl = "http://".get_cfg_var('aws.param1').'/'.$guidconvert;
			if ($this->session->userdata('twitter_id')) {
				$twitterid = $this->session->userdata('twitter_id');
			} else {
				$twitterid = "null";
			}
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
			                    AmazonDynamoDB::TYPE_STRING => "$timestamp"
			                )
			            ),
			            'createdby' => array(
			                'Action' => AmazonDynamoDB::ACTION_PUT,
			                'Value' => array(
			                    AmazonDynamoDB::TYPE_STRING => "$twitterid"
			                )
			            )															
			        )
			));
			if ($put->isOK()) {
				return $shorturl;  
			} else {
				echo print_r($put);
				return false;
			}
		} else {
			return false;
		}
    }

    public function updateURLCount($shorturl) {
			$put = $this->dynamodb->update_item(array(
			    'TableName' => get_cfg_var('aws.param2'), 
			        'Key' => array(
			            'HashKeyElement' => array(
			                AmazonDynamoDB::TYPE_STRING => "$shorturl"
			            )
			        ),
					'Expected' => array(
					        'shorturl'   => array( 
					            'Value' => array( AmazonDynamoDB::TYPE_STRING => "$shorturl"  ),
								'Exists' => "true"
							)
					),										
			        'AttributeUpdates' => array(
			            'count' => array(
			                'Action' => AmazonDynamoDB::ACTION_ADD,
			                'Value' => array(
			                    AmazonDynamoDB::TYPE_NUMBER => "1"
			                )
			            )								
			        ),
					'ReturnValues' => "ALL_NEW"
			));
			if ($put->isOK()) {
				//echo print_r($put->body->longurl->{AmazonDynamoDB::TYPE_STRING}); 
				return (string) $put->body->Attributes->longurl->{AmazonDynamoDB::TYPE_STRING};
				//echo print_r($put->body);
			} else {  
				return false;
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

    public function getAllByUser($twitterid) {      
		$response = $this->dynamodb->scan(array(
		    'TableName'       => get_cfg_var('aws.param2'),
		    'AttributesToGet' => array('longurl', 'shorturl', 'created', 'count'),
		    'ScanFilter'      => array(
		        'createdby' => array(
		            'ComparisonOperator' => AmazonDynamoDB::CONDITION_EQUAL,
		            'AttributeValueList' => array(
		                array( AmazonDynamoDB::TYPE_STRING => "$twitterid" )
		            )
		        ),
		    )
		));
		if ($response->isOK())
		{
			//echo print_r($response);
		   return $response->body->Items;
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