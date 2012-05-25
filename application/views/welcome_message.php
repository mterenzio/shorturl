<?php
$this->load->view('header');
if (!isset($shorturl)) {
	$shorturl = "http://dig1.st/shorturl";
}
?>
<div class="container">
<!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1><?php echo $shorturl;?></h1><br />
<?php
$attributes = array('class' => 'shorturlform', 'id' => 'secure');
echo form_open_multipart('/create', $attributes);
echo "<p class=\"warning\">You must javascript enabled to use this form!</p>";
$longurl = set_value('longurl');
$data = array(
              'name'        => 'longurl',
              'id'          => 'longurl',
			  'maxlength'   => '250',
			  'size'        => '100',
			  'value' 		=> $longurl,
			  'class' 		=> 'xxlarge',
            );
echo "<div class=\"formelement\">".form_error('longurl')."</div>";
echo "<div class=\"formelement\">".form_input($data);

//submit button and close form
echo " ".form_submit('mysubmit', 'Shorten!', 'class="btn primary medium"')."</div>";
echo form_close();

?>
      </div>
      <!-- Example row of columns -->
      <div class="row">
        <div class="span16">
          <h2>Install the bookmarklet for easy short url creation . . .</h2>
           <p>Simply drag the button below to the bookmarks bar on your browser and click it when you are on a web page that you'd like to share.</p>
          <p><a class="btn" href="#">dig1.st</a></p>
        </div>
      </div>	  
<script type="text/javascript">
$(document).ready(function(){
    $('.warning').remove();
    $.get("token.php",function(txt){
      $(".shorturlform").append('<input type="hidden" name="ts" value="'+txt+'" />');
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
<?php
$this->load->view('footer');
?>	