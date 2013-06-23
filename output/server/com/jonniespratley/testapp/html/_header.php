<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TestApp</title>
    
 
    
    <script type="text/javascript" charset="utf-8" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="jquery.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $("#user_info a").click(function() {
            $("link").attr("href", $(this).attr('rel') );
    			$("#logo").attr('src', 'images/'+ $(this).attr('rel') + 'logo_green.jpg' );
            return false;
        });
    });

    </script>
    </head>
    <body>
     
    	<h1 id="logo">TestApp</h1>
  