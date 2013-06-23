<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FreshCMS</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.qtip.js"></script>
<script type="text/javascript" src="js/jquery.example.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.markitup.js"></script>
<script type="text/javascript" src="js/jquery.superbox.js"></script>
<script type="text/javascript" src="js/styleswitch.js"></script>
<script type="text/javascript" src="js/supersleight.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<link href="css/basicblack.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
 
<div id="container">
    <div id="inner-container">
        <div id="header">
          <div id="user-info">
           	<p>Welcome <b>Administrator</b>, <a href="#">Logout?</a></p>
            </div>  
            <div id="logo"><a href="index.html" title=""></a></div>
            <div id="toggle-btn-header">
            	<a href="#" title="" id="toggle-open-btn"></a>
                <a href="#" title="" id="toggle-close-btn" style="display: none;"></a>
            </div>
            
            <div style="display: \;" id="toggle-box-1">
            
               <div id="hiddenmenu">
                    <div class="icon-no-spacer">
                    	<p><a id="active-icon" href="index.html" title=""><img src="images/icons/44/home.png" alt="">Dashboard</a></p>
                    </div>
                    <div class="icon-spacer">
                    	<p><a href="pages.html" title=""><img src="images/icons/44/comments.png" alt="">Pages</a></p>
                    </div>
                    <div class="icon-spacer">
                        <p><a href="#" title=""><img src="images/icons/44/calendar.png" alt="">Articles</a></p>
                    </div>            
                    <div class="icon-spacer">
                        <p><a href="#" title=""><img src="images/icons/44/chart.png" alt="">Email</a></p>
                    </div>
                    <div class="icon-spacer">
                    	<p><a href="#" title=""><img src="images/icons/44/database.png" alt="">Search</a></p>
                    </div>
                    <div class="icon-spacer">
                        <p><a href="#" title=""><img src="images/icons/44/folder.png" alt="">Media</a></p>
                    </div>
                  <!-- next row -->
                    <div class="icon-no-spacer">
                  		<p><a href="#" title=""><img src="images/icons/44/process.png" alt="">Statistics</a></p>
                    </div>
                    <div class="icon-spacer">
                    	<p><a href="#" title=""><img src="images/icons/44/rss.png" alt="">Settings</a></p>
                    </div>
                    <div class="icon-spacer">
                    	<p><a href="#" title=""><img src="images/icons/44/user.png" alt="">Comments</a></p>
                    </div>            
                    <div class="icon-spacer">
                    	<p><a href="#" title=""><img src="images/icons/44/mail.png" alt="">Users</a></p>
                    </div>
                    <div class="icon-spacer">
                    	<p><a href="#" title=""><img src="images/icons/44/users.png" alt="">Backup</a></p>
                    </div>                    
                    <div class="icon-spacer">
                    	<p><a href="#" title=""><img src="images/icons/44/help.png" alt="">Information</a></p>
                    </div>
               </div>
           
            </div>
            
            <div id="topmenu">
            
                <ul>
                    <li class="active-link"><a href="index.html">Dashboard</a></li>
                    <li><a href="pages.html">Pages</a></li>
                    <li><a href="comments.html">Comments</a></li>
                    <li><a href="#">Articles</a></li>
                    <li><a href="settings.html">Settings</a></li>
                    <li><a href="statistics.html">Statistics</a></li>
                </ul>

            </div>
            <div id="toggle-btn-header2">
            	<a href="javascript:void(null);" title="" id="toggle-open-btn2"></a>
                <a href="javascript:void(null);" title="" id="toggle-close-btn2" style="display: none;"></a>
            </div>  
            <div id="toggle-box-2">
                <a href="index.html?style=skyblue" rel="styles4" class="styleswitch " title="SkyBlue">
					<img src="images/skyblue-style-btn.jpg" alt="">
                </a>              
                <a href="index.html?style=babyblue" rel="styles2" class="styleswitch " title="BabyBlue">
                	<img src="images/babyblue-style-btn.jpg" alt="">
                </a>               
                <a href="index.html?style=basicgrey" rel="styles3" class="styleswitch " title="BasicGrey">
					<img src="images/basicgrey-style-btn.jpg" alt="">
                </a>
                <a href="index.html?style=doubleblue" rel="styles1" class="styleswitch " title="DoubleBlue">
					<img src="images/doubleblue-style-btn.jpg" alt="">
                </a>
                <a href="index.html?style=basicblack" rel="styles5" class="styleswitch " title="BasicBlack">
					<img src="images/basicblack-style-btn.jpg" alt="">
                </a>
                <a href="index.html?style=orangetaste" rel="styles6" class="styleswitch " title="OrangeTaste">
					<img src="images/orangetaste-style-btn.jpg" alt="">
                </a>                                                                    
            </div>           
        </div><!-- end header -->
        
        
        <div id="content">
 
           <ul id="sort-box" class="sorts ui-sortable">
            <li>
              <div class="content-header">
                  <div class="content-header-left">
                    <h2>Dashboard</h2>
                </div>
                  <div class="content-header-right">
                       <a href="javascript:void(null);" title="" class="toggle-open-btn" style="display: none;"></a>
                       <a href="javascript:void(null);" title="" class="toggle-close-btn"></a>
                  </div>
              </div>
              <div class="content-in">This is the content<br />
                <form id="form1" method="post" action="">
                <div class="user-make-row">
                  <label for="textfield">Username</label>
                  <input type="text" name="textfield" id="textfield" />
                  </div>
                </form>
              </div>
            </li>
           
           </ul>
                                   
        </div><!-- end content --> 
        
  </div><!-- end inner-container -->
    
    <div id="bottom">&nbsp;</div>
    
  <div id="footer"><p>Copyright 2009</p></div>
    
</div><!-- end container -->




<div style="display: none;" id="superbox-overlay"></div><div style="display: none;" id="superbox-wrapper"><div id="superbox-container"><div id="superbox"><p class="close"><a><strong><span>Close</span></strong></a></p><div id="superbox-innerbox"></div><p style="display: none;" class="nextprev"><a class="prev"><strong><span>Previous</span></strong></a><a class="next"><strong><span>Next</span></strong></a></p></div><p style="display: none;" class="loading">Loading</p></div></div>
</body>
</html>