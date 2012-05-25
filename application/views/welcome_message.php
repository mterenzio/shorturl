<?php
$this->load->view('header');
?>
<div class="container">
<!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>dig1st!</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a class="btn primary large">Learn more &raquo;</a></p>
      </div>
      <!-- Example row of columns -->
      <div class="row">
        <div class="span8">
          <h2>Heading</h2>
           <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>	  
<?php
$attributes = array('class' => 'shorturlform', 'id' => 'secure');
if (validation_errors() != '') {
	echo "<div class=\"formerror\">There were errors. Details below.</div>";
}
echo form_open_multipart('/create', $attributes);
echo "<p class=\"warning\">You must javascript enabled to use this form!</p>";

$data = array(
              'name'        => 'longurl',
              'id'          => 'longurl'
            );
echo "<div class=\"formelement\">".form_error('longurl').form_label('Enter a URL to shorten:', 'longurl').form_input($data)."</div>";

//submit button and close form
echo "<div class=\"formelement\">".form_submit('mysubmit', 'Get My ShortURL!', 'class="submit"')."</div>";
echo form_close();

?>
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