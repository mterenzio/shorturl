<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Dig 1st URL shortener</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Styles -->
    <link href="/css/bootstrap-1.1.1.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
 	<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jQuery.Validate/1.6/jQuery.Validate.min.js"></script> 
  </head>
  <body>
    <!-- The top navigation menu -->
   <div class="topbar">
    <div class="fill">
        <div class="container">
            <h3><a href="#"><?php echo get_cfg_var('aws.param1');?> shorturls</a></h3>
            <ul>
<?php
//set active nav bar
$home = "";
$getembed = "";
$getbookmarklet = "";
switch (uri_string()) {
    case "home":
        $home = "class=\"active\"";
        break;
    case "getembed":
        $getembed = "class=\"active\"";
        break;
    case "getbookmarklet":
        $getbookmarklet = "class=\"active\"";
        break;
}
?>
                <li><a href="http://dig1.st/about">About</a></li>                
                <li <?php echo $getbookmarklet;?>><a href="http://dig1.st">Get the bookmarklet</a></li>
                <li><a href="http://journalab.com">JournaLab Blog</a></li>
                <li><a href="http://dig1.st/contact/">Contact</a></li>
          </ul>
        </div>
    </div>
</div>




