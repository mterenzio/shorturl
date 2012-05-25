<?php
$this->load->view('header');
?>
<div class="container">
	<!-- Main hero unit for a primary marketing message or call to action -->
	<div class="hero-unit-home">
	<img src="/img/dig1st.png" alt="dig1st" id="logo"/>
        <p>Add a little clarity to your news world with personalized<br /> updates about the stories you love. </p><br />
        <p><a class="btn primary large" href="http://followth.is/getbookmarklet/">Get the Bookmarklet</a></p>
        <p><small><a href="http://about.followth.is"> Learn More . . . </a></small></p>
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
</div>
<?php
$this->load->view('footer');
?>	