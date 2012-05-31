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
Copy to Clipboard: <input type="text" id="clip_text" size="40" value="Copy me!"/><br/><br/> 
        
                <div id="d_clip_button">Copy To Clipboard</div>
        
                <script language="JavaScript">
                        var clip = new ZeroClipboard.Client();
                        
                        clip.setText( '' ); // will be set later on mouseDown
                        clip.setHandCursor( true );
                        clip.setCSSEffects( true );
                        
                        clip.addEventListener( 'load', function(client) {
                                // alert( "movie is loaded" );
                        } );
                        
                        clip.addEventListener( 'complete', function(client, text) {
                                alert("Copied text to clipboard: " + text );
                        } );
                        
                        clip.addEventListener( 'mouseOver', function(client) {
                                // alert("mouse over"); 
                        } );
                        
                        clip.addEventListener( 'mouseOut', function(client) { 
                                // alert("mouse out"); 
                        } );
                        
                        clip.addEventListener( 'mouseDown', function(client) { 
                                // set text to copy here
                                clip.setText( document.getElementById('clip_text').value );
                                
                                // alert("mouse down"); 
                        } );
                        
                        clip.addEventListener( 'mouseUp', function(client) { 
                                // alert("mouse up"); 
                        } );
                        
                        clip.glue( 'd_clip_button' );
                </script>

<?php
$this->load->view('basicfooter');
?>