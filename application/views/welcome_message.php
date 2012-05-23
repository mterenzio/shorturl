<?php /*
	$this->load->library('aws');
// Instantiate the class
$dynamodb = new AmazonDynamoDB();

$response = $dynamodb->get_item(array(
    'TableName' => 'counters',
    'Key' => array(
        'HashKeyElement' => array( AmazonDynamoDB::TYPE_NUMBER => '1' )
    ),
	'AttributesToGet' => array('count'),
	'ConsistentRead' => 'true'
));

// Check for success...
if ($response->isOK())
{
    $current_count = (string) $response->body->Item->count->{AmazonDynamoDB::TYPE_NUMBER};
	echo $current_count;
}
else
{
    print_r($response);
}
$next = $current_count + 1;
echo $next;
$update_response = $dynamodb->update_item(array(
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
    //$current_count = (string) $response->body->Item->count->{AmazonDynamoDB::TYPE_NUMBER};
	echo "shoulda";
}
else
{
    print_r($update_response);
}

$shorturl = "shorty";
$longurl = "longy";
			$put = $dynamodb->update_item(array(
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
			            )
			        )
			));
			if ($put->isOK()) {
				echo "put";  
			} else {
				print_r($put);
			}

*/	?>
<?php
$title = "url shortener";
$this->load->view('header');
?>
<script type="text/javascript">
$(document).ready(function(){
  $('.warning').remove();
  $.get("token.php",function(txt){
    $(".secure").append('<input type="hidden" name="ts" value="'+txt+'" />');
  });
  $("#create").validate({
    rules: {
      url: "required",// simple rule, converted to {required:true}
      url: {
        url: true
      }
    }
  });
});
</script>
<div id="main">
<form action="create" id="create" method="post" class="secure">
  <p class="warning">You must javascript enabled to use this form</p>
  <p><b>Enter your long url here:</b></p>
    <input type="text" class="text" name="url" />
    <input type="submit" class="submit" name="Submit" value="Shorten" />
</form>
</div>
<?php
$this->load->view('footer');
?>
	