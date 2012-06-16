<?php
require("cg_config.php");



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CodeGen - Version<?php echo CGManager::$CG_VERSION ?></title>

<!--CSS-->

<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="assets/js/libs/jqueryFileTree/jqueryFileTree.css" type="text/css" media="screen" />
 <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0rc1/jquery.mobile-1.0rc1.min.css" /

<!--jQuery Code-->
>
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0rc1/jquery.mobile-1.0rc1.min.js"></script>
 

<!--jQuery Plugins-->
<script src="assets/js/jquery.debug.js" type="text/javascript"></script>

<script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="assets/js/jquery.highlight.js" type="text/javascript"></script>
<script src="assets/js/libs/jqueryFileTree/jqueryFileTree.js" type="text/javascript"></script>

<script src="assets/js/jquery.tmpl.js" type="text/javascript"></script>
<script src="app/js/json2.js" type="text/javascript"></script>
<script src="assets/js/jquery.json.js" type="text/javascript"></script>
<script src="app/js/underscore-min.js" type="text/javascript"></script>
<script src="app/js/backbone-min.js" type="text/javascript"></script>



<!-- [App Models/Routers/View] -->
<script src="app/cgAppModels.js" type="text/javascript"></script>
<script src="app/cgAppModels.js" type="text/javascript"></script>
<script src="app/cgAppRouters.js" type="text/javascript"></script>
<script src="app/cgAppView.js" type="text/javascript"></script>

<!--CodeGen JS-->
<script src="assets/js/app.js" type="text/javascript"></script>
<script src="assets/js/CodeGen.js" type="text/javascript"></script>
<script src="assets/js/CodeGenUtilities.js" type="text/javascript"></script>


<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
		
var appModel = new cgAppModel();
var appView = new cgAppView();
var appRouter = new cgAppRouter();
	
	
	$('.cg-gen-databases-btn').click(function(){
	 	//cg_loadDatabases();
	});
	
		
		Backbone.history.start({pushState: true});
		// Parsing the Url below results an object that is returned with the
		// following properties:
		//
		//  obj.href:         http://jblas:password@mycompany.com:8080/mail/inbox?msg=1234&type=unread#msg-content
		//  obj.hrefNoHash:   http://jblas:password@mycompany.com:8080/mail/inbox?msg=1234&type=unread
		//  obj.hrefNoSearch: http://jblas:password@mycompany.com:8080/mail/inbox
		//  obj.domain:       http://jblas:password@mycompany.com:8080
		//  obj.protocol:     http:
		//  obj.authority:    jblas:password@mycompany.com:8080
		//  obj.username:     jblas
		//  obj.password:     password
		//  obj.host:         mycompany.com:8080
		//  obj.hostname:     mycompany.com
		//  obj.port:         8080
		//  obj.pathname:     /mail/inbox
		//  obj.directory:    /mail/
		//  obj.filename:     inbox
		//  obj.search:       ?msg=1234&type=unread
		//  obj.hash:         #msg-content

	
		$(document).bind("mobileinit", function(){
		  $.extend(  $.mobile , {
		    foo: bar
		  });
			var obj = $.mobile.path.parseUrl("http://jblas:password@mycompany.com:8080/mail/inbox?msg=1234");
		});

	});
 
	/* ======================================================================
	 * Private variables for service management
	 * ====================================================================== */
	var baseURL = window.location.href;
	var service = "api.php";
	var cg_host;// Host
	var cg_user;// Username
	var cg_pass;// Password
	var cg_database;// Database
	var cg_app;// Application
	var cg_namespace;// Namespace
	var cg_endpoint;// Endpoint
	var cg_framework;// Framework
	var cg_copywrite;// Copywrite
	var cg_config;// Config
	var cg_schema;// Schema
	var resultData;
	var cg_demoURL = '';
	
	
	/**
	 *
	 */
	var cg_inspectClass = function(path){
		$.get(service, {
			m: 'inspectClass',
			f: path
		}, function result(resultObj){
	 		$.each(resultObj.classMethods, function(i, obj) {
					$('#cg_inspector_methods').html('<option>' + resultObj[i]['methodName'] + '</option>');
				});
		});
	};


	/**
	 * Gets all databases when password input is out of focus
	 */
	var cg_loadDatabases = function( host, user, pass ) {

		 host = $("#txt_settings_host").val();
		 user = $("#txt_settings_user").val();
		 pass = $("#txt_settings_pass ").val()

		if (host != '' && user != '' && pass != '') {
			$.get(service, {
				m: 'getDatabases',
				h: host,
				u: user,
				p: pass
			}, function(result) {
				var options = '';
				var dbArray = eval(result);

		
				for (i = 0; i < dbArray.length; i++) {
					$('#cg_database_list').append('<li>'+ dbArray[i]['label']+'<p class="ui-li-count">'+ dbArray[i]['size']['totalSize'] +'</p></li>');
					$("#txt_databases").append('<option value="' + dbArray[i]['label'] + '">' + dbArray[i]['label'] + '</option>');
				}
				
		 
				$('#cg_database_list').listview('refresh');
				$("#txt_databases").selectmenu("refresh");
				$("#txt_databases").selectmenu("update");
			});
		} else {
			return false;
		}
	};
	
	/**
	 * Gets all databases when password input is out of focus
	 */
	var cg_loadTables = function( host, user, pass, db ) {

		 host = $("#txt_settings_host").val();
		 user = $("#txt_settings_user").val();
		 pass = $("#txt_settings_pass ").val();
		if (host != '' && user != '' && pass != '') {
			$.get(service, {
				m: 'getTables',
				h: host,
				u: user,
				p: pass,
				d: db
			}, function(result) {
				var options = '';
				var dbArray = eval(result);
				
				
				for (i = 0; i < dbArray.length; i++) {
				//	$('#cg_tables_list').append('<li>'+ dbArray[i]['label']+'<p class="ui-li-count">'+ dbArray[i]['size']['totalSize'] +'</p></li>');
					$('#txt_tables').append('<option>'+ dbArray[i]['label']+'</option>');
					console.log(dbArray[i]);
				};
				
		 
			//	$('#cg_tables_list').listview('refresh');
				$("#txt_tables").selectmenu("refresh");
			});
		} else {
			return false;
		}
	};
	
	/**
	 *
	 */	
	var cg_createSchema = function() {

		$.post(service, {
			m: "generateSchema",
			c: $('#txt_configLocation').val(),
			d: $('#txt_database').val()
		}, function(resultObj) {
			resultObj = $.trim(resultObj).replace(/[\\]*[\\"]/g, '');
			cg_schema = resultObj;

	 		window.console.log(resultObj);
			//cg_createApplication();
		});
	};
	
	/**
	 *
	 */	
	var cg_createApplication = function() {
		$.post(service, {
			m: "generateApplication",
			d: $('#txt_database').val(),
			s: $('#txt_schemaLocation').val()
		}, function(resultObj) {
			cg_demoURL = 'http://' + window.location.hostname + window.location.pathname + '/' + resultObj
			//alert( cg_demoURL );

			 window.console.log(resultObj);
			//cg_saveApplication();
		});
	};
	
	/**
	 *
	 */
	var cg_saveApplication = function() {
		$.post(service, {
			m: 'saveApp',
			name: cg_app,
			url: cg_demoURL,
			config: cg_config,
			schema: cg_schema
		}, function(resultObj) {
			//
			 window.console.log(resultObj);
		});
	};
	
	
	/**
	 * Settings form that updates the sqlite database
	 */
	var cg_saveSettings = function() {

		$.post(service, {
			m: 'saveSettings',
			sdk_path: $('#txt_sdk_path').val(),
			sdk_meta_title: $('#txt_sdk_meta_title').val(),
			sdk_meta_description: $('#txt_sdk_meta_description').val(),
			sdk_meta_publisher: $('#txt_sdk_meta_publisher').val(),
			sdk_meta_creator: $('#txt_sdk_meta_creator').val(),
			host: $('#txt_settings_host').val(),
			user: $('#txt_settings_user').val(),
			pass: $('#txt_settings_pass').val(),
			issues_count: $('#txt_issues_count').val(),
			downloads_count: $('#txt_downloads_count').val(),
			updates_count: $('#txt_updates_count').val(),
			app_copywrite: $('#txt_app_copywrite').val(),
			app_namespace: $('#txt_app_namespace').val(),
			app_endpoint: $('#txt_app_endpoint').val(),
			app_name: $('#txt_app_name').val()

		}, function(resultObj) {
			//alert(result);
			$('#cg_message').fadeIn().html('<p class="cg_info">Settings updated. <span>x</span></p>');
			window.console.log(resultObj);
		});
	};
	/**
	 * Config Form
	 */
	var cg_generateConfig = function() {

		// Step 1
		cg_host = $("#txt_host").val();
		cg_user = $("#txt_user").val();
		cg_pass = $("#txt_pass").val();
		cg_database = $("#txt_database").val();

		// Step 2
		cg_app = $("#txt_application").val();
		cg_namespace = $("#txt_namespace").val();
		cg_endpoint = $("#txt_endpoint").val();
		cg_framework = $("#txt_framework").val();
		cg_copywrite = $("#txt_copywrite").val();

		//Cookies$.cookies.set('sidebar', 'Jonnie', null );
		//Array of cookies
		var cookieArray = {
			h: cg_host,
			u: cg_user,
			p: cg_pass,
			d: cg_database,
			a: cg_app,
			n: cg_namespace,
			e: cg_endpoint,
			f: cg_framework,
			c: cg_copywrite
		};

		// Send the call
		$.post(service, {
			m: "generateConfig",
			h: cg_host,
			u: cg_user,
			p: cg_pass,
			d: cg_database,
			a: cg_app,
			n: cg_namespace,
			e: cg_endpoint,
			f: cg_framework,
			c: cg_copywrite
		}, function(resultObj) {
			resultObj = $.trim(resultObj).replace(/[\\]*[\\"]/g, '');

			//@TODO: Hack to remove the .. from the url
			cg_config = resultObj;

			$("#txt_configLocation").val(resultObj);
			//$("#txt_configLocation").val(resultObj).highlightFade("yellow");
			window.console.log(resultObj);
			//createSchema();

		});
	};
	
	/**
	 *
	 */
	var cg_removeApp = function() {
		var item = $(this);
		$.post(service, {
			m: 'removeApp',
			id: $(this).attr('rel')
		}, function( resultObj ) {
			item.slideUp('slow');

		})
	};
	
	/**
	 *
	 */
	var cg_previewApp = function() {
		$('#cg_window_preview').attr('src', $(this).attr('href'));
		$('#cg_window').dialog('open');
		return false;
	};



	$('#txt_databases').live('change', function(){
		cg_loadTables('localhost', 'root', 'fred', $(this).val());
	
	});
</script>





</head>
<body>
	
	
	
	
	
	
	
	
<!-- ********* cg_page_index ********** -->	
<div data-role="page" data-id="cg_page_index" id="cg_page_index">
	<div data-role="header" data-id="cg_header" id="cg_header">
		<a href="#cg_page_index">Dashboard</a>
		<h1>cg_page_inspector</h1>
		<a href="#cg_page_settings" data-rel="dialog">Settings</a>
			<div id="cg_header_navbar" data-id="cg_header_navbar" data-role="navbar">
				<ul>

					<li><a href="#cg_page_generator">Generator</a></li>
					<li><a href="#cg_page_inspector">Inspector</a></li>
					<li><a href="#cg_page_manager">Manager</a></li>
					<li><a href="#cg_page_utilities">Utilities</a></li>

				</ul>
			</div><!--/navbar-->
	</div><!--/header-->
	<div data-role="content">
	
		<div id="app-view">
			<button id="add-friend">Add Friend</button>
			    <ul id="friends-list">
			    </ul>
		</div>
		<ul id="cg_database_list" data-role="listview">
			<li data-role="list-divider" data-theme="a">Databases</li>
			 
		</ul>

	</div>
 	<div id="cg_footer" data-role="footer" class="ui-bar" data-position="fixed">
		<a href="#" data-role="button" data-icon="refresh" class="cg-gen-databases-btn">Load Databases</a>
	 
	</div>
</div><!--/page-->
<!-- ********* cg_page_index ********** -->






<!-- ********* cg_page_generator ********** -->
<div data-role="page" id="cg_page_generator">
	<div data-role="header" data-id="cg_header" id="cg_header">
		<a href="#cg_page_index">Dashboard</a>
		<h1>cg_page_inspector</h1>
		<a href="#cg_page_settings" data-rel="dialog">Settings</a>
			<div id="cg_header_navbar" data-id="cg_header_navbar" data-role="navbar">
				<ul>

					<li><a href="#cg_page_generator">Generator</a></li>
					<li><a href="#cg_page_inspector">Inspector</a></li>
					<li><a href="#cg_page_manager">Manager</a></li>
					<li><a href="#cg_page_utilities">Utilities</a></li>

				</ul>
			</div><!--/navbar-->
	</div><!--/header-->
		<div data-role="content">
		
		<?php include 'cg_generate.php'; ?>
			
		</div>
	 
</div>
<!-- ********* cg_page_generator ********** -->





<!-- ********* cg_page_inspector ********** -->
<div data-role="page" id="cg_page_inspector">
	<div data-role="header" data-id="cg_header" id="cg_header">
		<a href="#cg_page_index">Dashboard</a>
		<h1>cg_page_inspector</h1>
		<a href="#cg_page_settings" data-rel="dialog">Settings</a>
			<div id="cg_header_navbar" data-id="cg_header_navbar" data-role="navbar">
				<ul>

					<li><a href="#cg_page_generator">Generator</a></li>
					<li><a href="#cg_page_inspector">Inspector</a></li>
					<li><a href="#cg_page_manager">Manager</a></li>
					<li><a href="#cg_page_utilities">Utilities</a></li>

				</ul>
			</div><!--/navbar-->
	</div><!--/header-->
		<div data-role="content">
		
		
			
		</div>
		<div data-role="footer">
				<h4>Footer</h4>
		</div>
</div>
<!-- ********* cg_page_inspector ********** -->



<!-- ********* cg_page_manager ********** -->
<div data-role="page" id="cg_page_manager">
	<div data-role="header" data-id="cg_header" id="cg_header">
		<h1>cg_page_manager</h1>
		<a href="#cg_page_settings">Settings</a>
			<div id="cg_header_navbar" data-id="cg_header_navbar" data-role="navbar">
				<ul>
				 
					<li><a href="#cg_page_generator">Generator</a></li>
					<li><a href="#cg_page_inspector">Inspector</a></li>
					<li><a href="#cg_page_manager">Manager</a></li>
					<li><a href="#cg_page_utilities">Utilities</a></li>

				</ul>
			</div><!--/navbar-->
	</div><!--/header-->
		<div data-role="content">
		
		
			
		</div>
		<div data-role="footer">
				<h4>Footer</h4>
		</div>
</div>
<!-- ********* cg_page_manager ********** -->





<!-- ********* cg_page_utilities ********** -->
<div data-role="page" id="cg_page_utilities">
	<div data-role="header" data-id="cg_header" id="cg_header">
		<a href="#cg_page_index">Dashboard</a>
		<h1>cg_page_inspector</h1>
		<a href="#cg_page_settings" data-rel="dialog">Settings</a>
			<div id="cg_header_navbar" data-id="cg_header_navbar" data-role="navbar">
				<ul>

					<li><a href="#cg_page_generator">Generator</a></li>
					<li><a href="#cg_page_inspector">Inspector</a></li>
					<li><a href="#cg_page_manager">Manager</a></li>
					<li><a href="#cg_page_utilities">Utilities</a></li>

				</ul>
			</div><!--/navbar-->
	</div><!--/header-->
		<div data-role="content">
		
		
			
		</div>
		<div data-role="footer">
				<h4>Footer</h4>
		</div>
</div>
<!-- ********* cg_page_utilities ********** -->




<!-- ********* cg_page_settings ********** -->
<div data-role="page" id="cg_page_settings">
	<div data-role="header" data-id="cg_header" id="cg_header">
		<h1>cg_page_settings</h1>
		 
	</div><!--/header-->
		<div data-role="content">
		
	 
				<h3 class="cg_box_header">Database Settings</h3>
				<div class="cg_box_content">
					<p>This is going to be the settings for the application. </p>
					<ul data-role="listview">
						<li>
							<div data-role="fieldcontain">
								<label for="txt_settings_host">Host: </label>
								<input type="text" value="<?php echo $codegen->getSetting('host'); ?>" id="txt_settings_host"/>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="txt_settings_user">User: </label>
								<input type="text" value="<?php echo $codegen->getSetting('user'); ?>" id="txt_settings_user"/>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="txt_settings_pass">Password: </label>
								<input type="password" value="<?php echo $codegen->getSetting('pass'); ?>" id="txt_settings_pass"/>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
							 
								<input type="button" value="Save" class="btn_settings_save"/>
							</div>
						</li>
					</ul>
				</div>
				<!--/cg_box_content--> 
 
			
		</div>
	 
</div>
<!-- ********* cg_page_settings ********** -->






</body>
</html>