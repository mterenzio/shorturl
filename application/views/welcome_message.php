<?php
$this->load->view('header');
?>
<div class="container">
<!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>dig1st!</h1>
<?php
$attributes = array('class' => 'shorturlform', 'id' => 'secure');
if (validation_errors() != '') {
	echo "<div class=\"formerror\">There were errors. Details below.</div>";
}
echo form_open_multipart('/create', $attributes);
echo "<p class=\"warning\">You must javascript enabled to use this form!</p>";

$data = array(
              'name'        => 'longurl',
              'id'          => 'longurl',
			  'maxlength'   => '250',
			  'size'        => '100',
			  'class' 		=> 'input-xlarge'
            );
echo "<div class=\"formelement\">".form_error('longurl')."</div>";
echo "<div class=\"formelement\">".form_input($data);

//submit button and close form
echo " ".form_submit('mysubmit', 'Shorten!', 'class="btn primary large"')."</div>";
echo form_close();

?>
      </div>
      <!-- Example row of columns -->
      <div class="row">
        <div class="span8">
          <h2>Install the bookmarklet for easy short url creation . . .</h2>
           <p>Simply drag the button below to the bookmarks bar on your browser and click it when you are on a web page that you'd like to share.</p>
          <p><a class="btn" href="#">dig1st! &raquo;</a></p>
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