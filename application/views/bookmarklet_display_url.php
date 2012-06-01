<?php
$this->load->view('basicheader');
?>
<style type="text/css">
                        #d_clip_button {
                                text-align:center; 
                                border:2px solid red; 
                                background-color:#fff; 
                                margin:10px; padding:3px; 
								width: 100px;
                        }
                        #d_clip_button.hover { background-color:#eee; }
                        #d_clip_button.active { background-color:#aaa; }
                </style>

<div style="padding: 10px;">
<span id="shorty" style="text-align: center; width: 600px;font-size: 150%;"><?php echo $shorturl;?></span>
        
                <span id="d_clip_button">Copy</span>
</div>        
                <script language="JavaScript">
                        var clip = new ZeroClipboard.Client();
                        
                        clip.setText( '' ); // will be set later on mouseDown
                        clip.setHandCursor( true );
                        clip.setCSSEffects( true );

                        
                        clip.addEventListener( 'complete', function(client, text) {
                                //alert("Copied text to clipboard: " + text );
								d_clip_button.style.borderColor = "green";
                        } );
                        
                        clip.addEventListener( 'mouseDown', function(client) { 
                                // set text to copy here
                                clip.setText( document.getElementById('shorty').innerHTML );
                                
                                // alert("mouse down"); 
                        } );
                        
                        clip.glue( 'd_clip_button' );
                </script>

<?php
$this->load->view('basicfooter');
?>