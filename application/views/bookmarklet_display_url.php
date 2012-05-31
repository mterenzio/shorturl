<?php
$this->load->view('basicheader');
?>
<style type="text/css">
                        #d_clip_button {
                                text-align:center; 
                                border:1px solid black; 
                                background-color:#ccc; 
                                margin:10px; padding:10px; 
                        }
                        #d_clip_button.hover { background-color:#eee; }
                        #d_clip_button.active { background-color:#aaa; }
                </style>

<div>
<h1 id="shorty" style="text-align: center; width: 600px;"><?php echo $shorturl;?></h1>
        
                <div id="d_clip_button">Copy To Clipboard</div>
</div>        
                <script language="JavaScript">
                        var clip = new ZeroClipboard.Client();
                        
                        clip.setText( '' ); // will be set later on mouseDown
                        clip.setHandCursor( true );
                        clip.setCSSEffects( true );

                        
                        clip.addEventListener( 'complete', function(client, text) {
                                alert("Copied text to clipboard: " + text );
                        } );
                        
                        clip.addEventListener( 'mouseDown', function(client) { 
                                // set text to copy here
                                clip.setText( document.getElementById('shorty').value );
                                
                                // alert("mouse down"); 
                        } );
                        
                        clip.glue( 'd_clip_button' );
                </script>

<?php
$this->load->view('basicfooter');
?>