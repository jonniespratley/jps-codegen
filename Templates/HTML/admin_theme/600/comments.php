<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
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
<body>
<div id="container">
  <div id="inner-container">
    <div id="header">
      <div id="user-info">
        <p>Welcome <b>Administrator</b>, <a href="dummyfiles/logout.html">Logout?</a></p>
        <a title="" href="dummyfiles/index.html"><img alt="" src="images/icons/16/globe--arrow.png"/></a> </div>
      <div id="logo"><a title="" href="index.html"/></div>
      <div id="toggle-btn-header"> <a id="toggle-open-btn" title="" href="javascript:void(null);"/> <a style="display: none;" id="toggle-close-btn" title="" href="javascript:void(null);"/> </div>
      <div id="toggle-box-1" style="display: none;">
        <div id="hiddenmenu">
          <div class="icon-no-spacer">
            <p><a title="" href="index.html"><img alt="" src="images/icons/48/display.png"/>Dashboard</a></p>
          </div>
          <div class="icon-spacer">
            <p><a title="" href="pages.html"><img alt="" src="images/icons/48/wordprocessing.png"/>Pages</a></p>
          </div>
          <div class="icon-spacer">
            <p><a title="" href="#"><img alt="" src="images/icons/48/text_rtf.png"/>Articles</a></p>
          </div>
          <div class="icon-spacer">
            <p><a title="" href="#"><img alt="" src="images/icons/48/evolution.png"/>Email</a></p>
          </div>
          <div class="icon-spacer">
            <p><a title="" href="#"><img alt="" src="images/icons/48/document_preview.png"/>Search</a></p>
          </div>
          <div class="icon-spacer">
            <p><a title="" href="media.html"><img alt="" src="images/icons/48/fileview_preview.png"/>Media</a></p>
          </div>
          <!-- next row -->
          <div class="icon-no-spacer">
            <p><a title="" href="statistics.html"><img alt="" src="images/icons/48/view_statistics.png"/>Statistics</a></p>
          </div>
          <div class="icon-spacer">
            <p><a title="" href="settings.html"><img alt="" src="images/icons/48/applications_systemg.png"/>Settings</a></p>
          </div>
          <div class="icon-spacer">
            <p><a title="" href="comments.html" id="active-icon"><img alt="" src="images/icons/48/spread.png"/>Comments</a></p>
          </div>
          <div class="icon-spacer">
            <p><a title="" href="users.html"><img alt="" src="images/icons/48/user.png"/>Users</a></p>
          </div>
          <div class="icon-spacer">
            <p><a title="" href="#"><img alt="" src="images/icons/48/kget.png"/>Backup</a></p>
          </div>
          <div class="icon-spacer">
            <p><a title="" href="information.html"><img alt="" src="images/icons/48/help_about.png"/>Information</a></p>
          </div>
        </div>
      </div>
      <div id="topmenu">
        <ul>
          <li><a href="index.html">Dashboard</a></li>
          <li><a href="pages.html">Pages</a></li>
          <li class="active-link"><a href="comments.html">Comments</a></li>
          <li><a href="#">Articles</a></li>
          <li><a href="settings.html">Settings</a></li>
          <li><a href="statistics.html">Statistics</a></li>
        </ul>
      </div>
      <div id="toggle-btn-header2"> <a id="toggle-open-btn2" title="" href="javascript:void(null);"/> <a style="display: none;" id="toggle-close-btn2" title="" href="javascript:void(null);"/> </div>
      <div id="toggle-box-2"> <a title="SkyBlue" class="styleswitch " rel="styles4" href="index.html?style=skyblue"> <img alt="" src="images/style-btn/skyblue-style-btn.jpg"/> </a> <a title="BabyBlue" class="styleswitch " rel="styles2" href="index.html?style=babyblue"> <img alt="" src="images/style-btn/babyblue-style-btn.jpg"/> </a> <a title="BasicGrey" class="styleswitch " rel="styles3" href="index.html?style=basicgrey"> <img alt="" src="images/style-btn/basicgrey-style-btn.jpg"/> </a> <a title="DoubleBlue" class="styleswitch " rel="styles1" href="index.html?style=doubleblue"> <img alt="" src="images/style-btn/doubleblue-style-btn.jpg"/> </a> <a title="BasicBlack" class="styleswitch " rel="styles5" href="index.html?style=basicblack"> <img alt="" src="images/style-btn/basicblack-style-btn.jpg"/> </a> <a title="OrangeTaste" class="styleswitch " rel="styles6" href="index.html?style=orangetaste"> <img alt="" src="images/style-btn/orangetaste-style-btn.jpg"/> </a> </div>
    </div>
    <!-- end header -->
    <div id="content">
      <form method="post" action="">
        <ul class="sorts ui-sortable" id="sort-box">
          <li>
            <div class="content-header">
              <div class="content-header-left"> <img alt="" src="images/icons/22/spread.png"/>
                <h2>Comments</h2>
              </div>
              <div class="content-header-right"> <a style="display: none;" class="toggle-open-btn" title="" href="javascript:void(null);"/> <a class="toggle-close-btn" title="" href="javascript:void(null);"/> </div>
            </div>
            <div id="tab" class="content-in ui-tabs ui-widget ui-widget-content ui-corner-all">
              <div id="search-bar">
                <input type="text" class="search-bar example"/>
                <select name="field3">
                  <option value="">All (3)</option>
                  <option value="">Approved (1)</option>
                  <option value="">Pending (2)</option>
                  <option value="">Spam (0)</option>
                </select>
                <input type="submit" class="btn-140" value="Search Comments"/>
              </div>
              <ul class="tabs-actions-2 ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#tabs-1">All</a>  |  </li>
                <li class="ui-state-default ui-corner-top"><a style="color: green;" href="#tabs-2">Approved (1)</a>  |  </li>
                <li class="ui-state-default ui-corner-top"><a style="color: orange;" href="#tabs-3">Pending (2)</a>  |  </li>
                <li class="ui-state-default ui-corner-top"><a style="color: red;" href="#tabs-4">Spam (0)</a></li>
                <li id="checkall-2">
                  <!--

                        <a href="javascript:void(null);" title="" class="collapsall"><img src="images/icons/16/view_sort_ascending.png" height="12" width="12" alt="" /></a>                         &nbsp;

                        <a href="javascript:void(null);" title="" class="expandeall"><img src="images/icons/16/view_sort_descending.png" height="12" width="12" alt="" /></a>

                       -->
                  <input type="checkbox" onclick="checkAll(this)" name="c0"/>
                </li>
              </ul>
              <div id="tabs-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                <div class="comments-box">
                  <div class="profile-comment-bg"> <img alt="" src="images/profile.jpg"/> </div>
                  <div class="comments-right">
                    <p class="com-name">From <a href="#"><b>John Smith</b></a> on <a href="#"><b>Lorem Ipsum the article</b></a></p>
                    <input type="checkbox" name="c1"/>
                    <p> Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. Nulla facilisi. Vivamus ornare pellentesque magna, at pulvinar ante ornare eu. Nam sapien metus, viverra eu feugiat eu, ultricies quis libero. </p>
                    <p class="com-actions"> <a href="#">Unapprove</a> | <a href="javascript:void(null);" class="edit-comments">Edit</a> | <a href="#">Reply</a> | <a href="#">Spam</a> | <a class="delete-row" href="javascript:void(null);">Delete</a> </p>
                    <p class="comments-date">2009/06/16 at 12:15pm</p>
                  </div>
                  <div class="comments-toggle">
                    <input type="text" class="input" value="John Smith"/>
                    <input type="text" class="input" value="johnsmith@freshcms.com"/>
                    <input type="text" class="input" value="http://www.johnsmith.com"/>
                    <textarea class="comment-msg" rows="" cols="">Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. Nulla facilisi. Vivamus ornare pellentesque magna, at pulvinar ante ornare eu. Nam sapien metus, viverra eu feugiat eu, ultricies quis libero.
                          </textarea>
                    <select class="comments-article-link" name="s1">
                      <option value="">Lorem Ipsum the article</option>
                      <option value="">Curabitur eget ipsum nec</option>
                      <option value="">Mauris vitae est erat, ac tincidunt lacus</option>
                      <option value="">Aliquam condimentum arcu the article</option>
                      <option value="">Aliquam et suscipit magna</option>
                    </select>
                    <input type="submit" value="" class="btn-70"/>
                  </div>
                </div>
                <!-- new row -->
                <div class="comments-box">
                  <div class="profile-comment-bg"> <img alt="" src="images/profile.jpg"/> </div>
                  <div class="comments-right">
                    <p class="com-name">From <a href="#"><b>Jane Doe</b></a> on <a href="#"><b>Aliquam condimentum arcu the article</b></a></p>
                    <input type="checkbox" name="c1"/>
                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et suscipit magna. Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. Nulla facilisi. Vivamus ornare pellentesque magna, at pulvinar ante ornare eu. Nam sapien metus, viverra eu feugiat eu, ultricies quis libero. </p>
                    <p class="com-actions"> <a href="#">Approve</a> | <a href="javascript:void(null);" class="edit-comments">Edit</a> | <a href="#">Reply</a> | <a href="#">Spam</a> | <a class="delete-row" href="javascript:void(null);">Delete</a> </p>
                    <p class="comments-date">2009/06/16 at 12:15pm</p>
                  </div>
                  <div class="comments-toggle">
                    <input type="text" class="input" value="Jane Doe"/>
                    <input type="text" class="input" value="janedoe@freshcms.com"/>
                    <input type="text" class="input" value="http://www.janedoe.com"/>
                    <textarea class="comment-msg" rows="" cols="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et suscipit magna. Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. Nulla facilisi. Vivamus ornare pellentesque magna, at pulvinar ante ornare eu. Nam sapien metus, viverra eu feugiat eu, ultricies quis libero.</textarea>
                    <select class="comments-article-link" name="s1">
                      <option value="">Aliquam condimentum arcu the article</option>
                      <option value="">Lorem Ipsum the article</option>
                      <option value="">Curabitur eget ipsum nec</option>
                      <option value="">Mauris vitae est erat, ac tincidunt lacus</option>
                      <option value="">Aliquam et suscipit magna</option>
                    </select>
                    <input type="submit" value="" class="btn-70"/>
                  </div>
                </div>
                <!-- new row -->
                <div class="comments-box">
                  <div class="profile-comment-bg"> <img alt="" src="images/profile.jpg"/> </div>
                  <div class="comments-right">
                    <p class="com-name">From <a href="#"><b>John Doe</b></a> on <a href="#"><b>Aliquam et suscipit magna</b></a></p>
                    <input type="checkbox" name="c1"/>
                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et suscipit magna. Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. </p>
                    <p class="com-actions"> <a href="#">Approve</a> | <a href="javascript:void(null);" class="edit-comments">Edit</a> | <a href="#">Reply</a> | <a href="#">Spam</a> | <a class="delete-row" href="javascript:void(null);">Delete</a> </p>
                    <p class="comments-date">2009/06/16 at 12:15pm</p>
                  </div>
                  <div class="comments-toggle">
                    <input type="text" class="input" value="John Doe"/>
                    <input type="text" class="input" value="johndoe@freshcms.com"/>
                    <input type="text" class="input" value="http://www.johndoe.com"/>
                    <textarea class="comment-msg" rows="" cols="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et suscipit magna. Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum.
                          </textarea>
                    <select class="comments-article-link" name="s1">
                      <option value="">Aliquam et suscipit magna</option>
                      <option value="">Lorem Ipsum the article</option>
                      <option value="">Curabitur eget ipsum nec</option>
                      <option value="">Mauris vitae est erat, ac tincidunt lacus</option>
                      <option value="">Aliquam condimentum arcu the article</option>
                    </select>
                    <input type="submit" value="" class="btn-70"/>
                  </div>
                </div>
              </div>
              <div id="tabs-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
                <div class="comments-box">
                  <div class="profile-comment-bg"> <img alt="" src="images/profile.jpg"/> </div>
                  <div class="comments-right">
                    <p class="com-name">From <a href="#"><b>John Smith</b></a> on <a href="#"><b>Lorem Ipsum the article</b></a></p>
                    <input type="checkbox" name="c1"/>
                    <p> Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. Nulla facilisi. Vivamus ornare pellentesque magna, at pulvinar ante ornare eu. Nam sapien metus, viverra eu feugiat eu, ultricies quis libero. </p>
                    <p class="com-actions"> <a href="#">Unapprove</a> | <a href="javascript:void(null);" class="edit-comments">Edit</a> | <a href="#">Reply</a> | <a href="#">Spam</a> | <a class="delete-row" href="javascript:void(null);">Delete</a> </p>
                    <p class="comments-date">2009/06/16 at 12:15pm</p>
                  </div>
                  <div class="comments-toggle">
                    <input type="text" class="input" value="John Smith"/>
                    <input type="text" class="input" value="johnsmith@freshcms.com"/>
                    <input type="text" class="input" value="http://www.johnsmith.com"/>
                    <textarea class="comment-msg" rows="" cols="">Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. Nulla facilisi. Vivamus ornare pellentesque magna, at pulvinar ante ornare eu. Nam sapien metus, viverra eu feugiat eu, ultricies quis libero.
                          </textarea>
                    <select class="comments-article-link" name="s1">
                      <option value="">Lorem Ipsum the article</option>
                      <option value="">Curabitur eget ipsum nec</option>
                      <option value="">Mauris vitae est erat, ac tincidunt lacus</option>
                      <option value="">Aliquam condimentum arcu the article</option>
                      <option value="">Aliquam et suscipit magna</option>
                    </select>
                    <input type="submit" value="" class="btn-70"/>
                  </div>
                </div>
              </div>
              <div id="tabs-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
                <div class="comments-box">
                  <div class="profile-comment-bg"> <img alt="" src="images/profile.jpg"/> </div>
                  <div class="comments-right">
                    <p class="com-name">From <a href="#"><b>Jane Doe</b></a> on <a href="#"><b>Aliquam condimentum arcu the article</b></a></p>
                    <input type="checkbox" name="c1"/>
                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et suscipit magna. Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. Nulla facilisi. Vivamus ornare pellentesque magna, at pulvinar ante ornare eu. Nam sapien metus, viverra eu feugiat eu, ultricies quis libero. </p>
                    <p class="com-actions"> <a href="#">Approve</a> | <a href="javascript:void(null);" class="edit-comments">Edit</a> | <a href="#">Reply</a> | <a href="#">Spam</a> | <a class="delete-row" href="javascript:void(null);">Delete</a> </p>
                    <p class="comments-date">2009/06/16 at 12:15pm</p>
                  </div>
                  <div class="comments-toggle">
                    <input type="text" class="input" value="Jane Doe"/>
                    <input type="text" class="input" value="janedoe@freshcms.com"/>
                    <input type="text" class="input" value="http://www.janedoe.com"/>
                    <textarea class="comment-msg" rows="" cols="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et suscipit magna. Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. Nulla facilisi. Vivamus ornare pellentesque magna, at pulvinar ante ornare eu. Nam sapien metus, viverra eu feugiat eu, ultricies quis libero.</textarea>
                    <select class="comments-article-link" name="s1">
                      <option value="">Aliquam condimentum arcu the article</option>
                      <option value="">Lorem Ipsum the article</option>
                      <option value="">Curabitur eget ipsum nec</option>
                      <option value="">Mauris vitae est erat, ac tincidunt lacus</option>
                      <option value="">Aliquam et suscipit magna</option>
                    </select>
                    <input type="submit" value="" class="btn-70"/>
                  </div>
                </div>
                <!-- new row -->
                <div class="comments-box">
                  <div class="profile-comment-bg"> <img alt="" src="images/profile.jpg"/> </div>
                  <div class="comments-right">
                    <p class="com-name">From <a href="#"><b>John Doe</b></a> on <a href="#"><b>Aliquam et suscipit magna</b></a></p>
                    <input type="checkbox" name="c1"/>
                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et suscipit magna. Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. </p>
                    <p class="com-actions"> <a href="#">Approve</a> | <a href="javascript:void(null);" class="edit-comments">Edit</a> | <a href="#">Reply</a> | <a href="#">Spam</a> | <a class="delete-row" href="javascript:void(null);">Delete</a> </p>
                    <p class="comments-date">2009/06/16 at 12:15pm</p>
                  </div>
                  <div class="comments-toggle">
                    <input type="text" class="input" value="John Doe"/>
                    <input type="text" class="input" value="johndoe@freshcms.com"/>
                    <input type="text" class="input" value="http://www.johndoe.com"/>
                    <textarea class="comment-msg" rows="" cols="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et suscipit magna. Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum.
                          </textarea>
                    <select class="comments-article-link" name="s1">
                      <option value="">Aliquam et suscipit magna</option>
                      <option value="">Lorem Ipsum the article</option>
                      <option value="">Curabitur eget ipsum nec</option>
                      <option value="">Mauris vitae est erat, ac tincidunt lacus</option>
                      <option value="">Aliquam condimentum arcu the article</option>
                    </select>
                    <input type="submit" value="" class="btn-70"/>
                  </div>
                </div>
              </div>
              <div class="nav-actions-bulk">
                <div id="page-nav">
                  <ul>
                    <li><a id="prev" href="#"/></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a class="currentpage" href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a id="next" href="#"/></li>
                  </ul>
                </div>
                <div class="actions">
                  <select name="field1">
                    <option value="">Bulk Actions</option>
                    <option value="">Approve</option>
                    <option value="">Unapprove</option>
                    <option value="">Mark as Spam</option>
                    <option value="">Delete</option>
                  </select>
                  <input type="submit" value="" class="btn-70"/>
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="content-header">
              <div class="content-header-left"> <img alt="" src="images/icons/22/view_pim_tasks.png"/>
                <h2>Write a Comment</h2>
              </div>
              <div class="content-header-right"> <a style="display: none;" class="toggle-open-btn" title="" href="javascript:void(null);"/> <a class="toggle-close-btn" title="" href="javascript:void(null);"/> </div>
            </div>
            <div class="content-in">
              <div>
                <div class="markItUp">
                  <div class="markItUpContainer">
                    <div class="markItUpHeader">
                      <ul>
                        <li class="markItUpButton markItUpButton1 "><a title="Heading 1 [Ctrl+1]" accesskey="1" href="">Heading 1</a></li>
                        <li class="markItUpButton markItUpButton2 "><a title="Heading 2 [Ctrl+2]" accesskey="2" href="">Heading 2</a></li>
                        <li class="markItUpButton markItUpButton3 "><a title="Heading 3 [Ctrl+3]" accesskey="3" href="">Heading 3</a></li>
                        <li class="markItUpButton markItUpButton4 "><a title="Heading 4 [Ctrl+4]" accesskey="4" href="">Heading 4</a></li>
                        <li class="markItUpButton markItUpButton5 "><a title="Heading 5 [Ctrl+5]" accesskey="5" href="">Heading 5</a></li>
                        <li class="markItUpButton markItUpButton6 "><a title="Heading 6 [Ctrl+6]" accesskey="6" href="">Heading 6</a></li>
                        <li class="markItUpButton markItUpButton7 "><a title="Paragraph" href="">Paragraph</a></li>
                        <li class="markItUpSeparator">---------------</li>
                        <li class="markItUpButton markItUpButton8 "><a title="Bold [Ctrl+B]" accesskey="B" href="">Bold</a></li>
                        <li class="markItUpButton markItUpButton9 "><a title="Italic [Ctrl+I]" accesskey="I" href="">Italic</a></li>
                        <li class="markItUpButton markItUpButton10 "><a title="Stroke through [Ctrl+S]" accesskey="S" href="">Stroke through</a></li>
                        <li class="markItUpSeparator">---------------</li>
                        <li class="markItUpButton markItUpButton11 "><a title="Ul" href="">Ul</a></li>
                        <li class="markItUpButton markItUpButton12 "><a title="Ol" href="">Ol</a></li>
                        <li class="markItUpButton markItUpButton13 "><a title="Li" href="">Li</a></li>
                        <li class="markItUpSeparator">---------------</li>
                        <li class="markItUpButton markItUpButton14 "><a title="Picture [Ctrl+P]" accesskey="P" href="">Picture</a></li>
                        <li class="markItUpButton markItUpButton15 "><a title="Link [Ctrl+L]" accesskey="L" href="">Link</a></li>
                        <li class="markItUpSeparator">---------------</li>
                        <li class="markItUpButton markItUpButton16 clean"><a title="Clean" href="">Clean</a></li>
                        <li class="markItUpButton markItUpButton17 preview"><a title="Preview" href="">Preview</a></li>
                      </ul>
                    </div>
                    <textarea cols="" rows="" class="editor-textarea markItUpEditor">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et suscipit magna. Aliquam facilisis odio venenatis dui pretium et elementum metus laoreet. Aliquam condimentum arcu eu lectus suscipit bibendum. Nulla facilisi. Vivamus ornare pellentesque magna, at pulvinar ante ornare eu. Nam sapien metus, viverra eu feugiat eu, ultricies quis libero.
                  </textarea>
                    <div class="markItUpFooter">
                      <div class="markItUpResizeHandle"/>
                    </div>
                  </div>
                </div>
              </div>
              <select class="comments-article-link" name="s1">
                <option value="">Select a article....</option>
                <option value="">Lorem Ipsum the article</option>
                <option value="">Curabitur eget ipsum nec</option>
                <option value="">Mauris vitae est erat, ac tincidunt lacus</option>
              </select>
              <a class="remove-editor" href="javascript:void(null);"><span><img alt="" src="images/icons/16/image-resize-actual.png"/></span></a>
              <input type="submit" value="" class="btn-70-3"/>
            </div>
          </li>
        </ul>
      </form>
    </div>
    <!-- end content -->
  </div>
  <!-- end inner-container -->
  <div id="bottom"/>
  <div id="footer">
    <p>Copyright 2009 - FreshCMS is designed and coded by Mark Dijkstra for ThemeForest.net</p>
  </div>
</div>
<!-- end container -->
<div id="superbox-overlay" style="display: none;"/>
<div id="superbox-wrapper" style="display: none;">
  <div id="superbox-container">
    <div id="superbox">
      <p class="close"><a><strong><span>Close</span></strong></a></p>
      <div id="superbox-innerbox"/>
      <p class="nextprev" style="display: none;"><a class="prev"><strong><span>Previous</span></strong></a><a class="next"><strong><span>Next</span></strong></a></p>
    </div>
    <p class="loading" style="display: none;">Loading</p>
  </div>
</div>
</body>
</body>
</html>