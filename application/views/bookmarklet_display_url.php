<?php
$this->load->view('basicheader');
?>
	<style type="text/css">
		body { font-family:arial,sans-serif; font-size:9pt; }
		
		.my_clip_button { width:150px; text-align:center; border:1px solid black; background-color:#ccc; margin:10px; padding:10px; cursor:default; font-size:9pt; }
		.my_clip_button.hover { background-color:#eee; }
		.my_clip_button.active { background-color:#aaa; }
	</style>
<div>
<h1 id="shorty" style="text-align: center; width: 600px;"><?php echo $shorturl;?></h1>				<div id="d_clip_container" style="position:relative">
					<div id="d_clip_button" class="my_clip_button"><b>Copy To Clipboard...</b></div>
				</div>
</div>
<script>
var clip = null;
clip = new ZeroClipboard.Client();
clip.glue( 'd_clip_button', 'd_clip_container' );
clip.setText( "Copy me testeroni!" );
<script>
<?php
$this->load->view('basicfooter');
?>