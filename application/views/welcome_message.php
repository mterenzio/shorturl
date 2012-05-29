<?php
$this->load->view('header');
if (!isset($shorturl)) {
	$shorturl = "http://".get_cfg_var('aws.param1')."/shorturl";
}
?>
<div class="container">
<!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1 id="shorty"><?php echo $shorturl;?></h1><br />
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
          <p><a class="btn" href="javascript:(function(e,a,g,h,f,c,b,d){if(!(f=e.jQuery)||g>f.fn.jquery||h(f)){c=a.createElement('script');c.type='text/javascript';c.src='http://ajax.googleapis.com/ajax/libs/jquery/'+g+'/jquery.min.js';c.onload=c.onreadystatechange=function(){if(!b&&(!(d=this.readyState)||d=='loaded'||d=='complete')){h((f=e.jQuery).noConflict(1),b=1);f(c).remove()}};a.documentElement.childNodes[0].appendChild(c)}})(window,document,'1.3.2',function($,L){dig1st_script=document.createElement('SCRIPT');dig1st_script.type='text/javascript';dig1st_script.src='http://cdn.dig1.st/js/dig1stbookmarklet.js?x='+(Math.random());document.getElementsByTagName('head')[0].appendChild(dig1st_script);});">dig1.st</a></p>
        </div>
      </div>	  
<script type="text/javascript">
$(document).ready(function(){
    $('.warning').remove();
    $.get("token.php",function(txt){
      $(".shorturlform").append('<input type="hidden" name="ts" value="'+txt+'" />');
    });
    $("#secure").validate({
      rules: {
        longurl: "required",// simple rule, converted to {required:true}
        longurl: {
          url: true
        }
      }
    });
	$("#shorty").fadeOut("slow").css("background-color", "#FFFF99");
	$("#shorty").show().css("background-color", "#FFF");
});
</script>	  
<?php
$this->load->view('footer');
?>	