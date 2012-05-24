<?php
$this->load->view('header');
?>
<h2>Create your shorturl!</h2>
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
<?php
$this->load->view('footer');
?>
	