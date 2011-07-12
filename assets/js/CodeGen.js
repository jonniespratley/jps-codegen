/* ======================================================================
 * Private variables for service management
 * ====================================================================== */
var baseURL = window.location.href;
var service = "index.php";
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
var cg_loadDatabases = function() {
	var host = $("#txt_host").val();
	var user = $("#txt_user").val();
	var pass = $("#txt_pass").val()

	if (host != '' && user != '' && pass != '') {
		$.get(service, {
			m: 'getDatabases',
			h: host,
			u: user,
			p: pass
		}, function(result) {
			var options = '';
			var dbArray = eval(result);

			$.each(dbArray, function(i, obj) {
				options += '<option>' + dbArray[i]['label'] + '</option>';
			})
			for (i = 0; i < dbArray.length; i++) {

			}
			var myselect = $("select#txt_database");
				myselect.html(options);
				myselect.selectmenu("refresh");
		});
	} else {
		return false;
	}
};
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
var cg_generateApp = function() {

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
		$("#txt_configLocation").val(resultObj).highlightFade("yellow");
		window.console.log(resultObj);
		//createSchema();
		 
	});
};
var cg_removeApp = function() {
	var item = $(this);
	$.post(service, {
		m: 'removeApp',
		id: $(this).attr('rel')
	}, function( resultObj ) {
		item.slideUp('slow');
		 
	})
};
var cg_previewApp = function() {
	$('#cg_window_preview').attr('src', $(this).attr('href'));
	$('#cg_window').dialog('open');
	return false;
};


 
$(document).ready(function(){


 
	
	
	$("select").change(function(){
		//log( $(this).attr('id') + ' = ' + $(this).find("option:selected").text()+'' );

		window.console.log($(this).find("option:selected").text());
	});

	

  $('#cg_svc_filetree').fileTree({
        root: '/Applications/mamp/htdocs/jps-codegen/services/',
        script: 'assets/js/libs/jqueryFileTree/jqueryFileTree.php',
        expandSpeed: 1000,
        collapseSpeed: 1000,
        multiFolder: false
    }, function(file) {
        cg_inspectClass(file);
    });



	$("#cg_db_loader").hide();
	$("#cg_global_loader").hide();

	/**
	 * @deprecated - Not using this for database management
	 * Gets all databases and tables for management
	 */
	$('.db').blur( function() {
		var db = this.text;
		$.get(service, {
			m: 'getTables',
			h: $("#txt_host").val(),
			u: $("#txt_user").val(),
			p: $("#txt_pass").val(),
			d: db
		}, function(result) {
			var options = '';
			var dbArray = [];
			var dbArray = eval('(' + result + ')');

			for (i = 0; i < dbArray.length; i++) {
				options += '<li><b>' + dbArray[i]['label'] + '</b></li>';

				if ((dbArray[i]['aFields'])) {
					var fieldArray = dbArray[i]['aFields'];
					for (j = 0; j < fieldArray.length; j++) {
						options += '<ul><li>' + fieldArray[j]['Field'] + '</li></ul>';
					}

				}
				options += '</li>';
			}
			$("div#tables").html(options);
		});
		return false;
	});
	/* ======================================================================
	 * Ajax Requests, utility functions
	 * ====================================================================== */
	$("#svcMessage").ajaxSend( function(request, settings) {
		$(this).html('<p class="notice">Starting request at ' + settings.url + '</p>');
	});
	$("#svcMessage").ajaxSuccess( function(request, settings) {
		$(this).html('<p class="success">Successful Request!</p>');
	});
	$("#svcMessage").ajaxComplete( function(request, settings) {
		$(this).html('<p class="success">Request Complete.</p>');
	});
	$("#svcMessage").ajaxError( function(request, settings) {
		$(this).html('<p class="error">Error requesting page ' + settings.url + '</p>');
	});
	$("#cg_global_loader").ajaxStart( function() {
		$(this).show();
	});
	$("#cg_global_loader").ajaxStop( function() {
		$(this).hide();
	});
	$('.cg_info span, .cg_error span, .cg_notice span, .cg_success span').live('click', function() {
		$(this).parent().slideUp();
	});
	$('#cg_utilities').flash({
		src: 'flex/cg_utilities.swf',
		width: 940,
		height: 550
	});

	$('#cg_inspector').flash({
		src: 'flex/cg_service_browser.swf',
		width: 940,
		height: 550
	});
	$('#cg_data_manager').flash({
		src: 'flex/cg_data_manager.swf',
		width: 940,
		height: 550
	});

	$('#cg_window').dialog({
		autoOpen: false,
		modal: true,
		bigiframe: true,
		width: 800,
		height: 600,
		buttons: {
			'Save': function() {
				$.post(service, {
					m: 'saveApp',
					name: cg_app,
					url: cg_demoURL,
					config: cg_config,
					schema: cg_schema
				}, function(resultObj) {
					$('#cg_window').dialog('close');
				});
			},
			'Cancel': function() {
				$(this).dialog('close');
			}
		}
	});

	/**
	 * Show/Hides .cg_box divs when h3 is clicked.
	 * @depreciated - Now using jquery mobile.
	 $('.cg_box h3').bind('click', function(){
	 $(this).parents('.cg_box:first').find('.cg_box_content').slideToggle('fast');
	 });
	 */

});