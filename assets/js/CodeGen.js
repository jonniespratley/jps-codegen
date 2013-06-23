$(function(){

	$("#cg_db_loader").hide();
	$("#cg_global_loader").hide();
	
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
	
	
	/* ======================================================================
	 * File System Reader
	 
	 
	 $('#fileTree').fileTree(
	 {
	 root: '../../Templates/',
	 script: 'assets/js/jqueryFileTree.php',
	 loadMessage: 'Loading...'
	 
	 }, function( file ) {
	 
	 var newFile = file.replace(/^(..\/..\/)/gi, '');
	 
	 //TODO: Fix the path to the file
	 $.get( service, {
	 m: 'readFile',
	 f: '/Applications/MAMP/htdocs/CodeGen/' + newFile
	 }, function(data)
	 {
	 $("#code").html( data );
	 });
	 });
	 * ====================================================================== */
	/* ======================================================================
	 * Generated Files Reader
	 
	 $('#outputFileTree').fileTree(
	 {
	 root: '../../output/',
	 script: 'assets/js/jqueryFileTree.php',
	 
	 }, function( file ) {
	 
	 var newFile = file.replace(/^(..\/..\/)/gi, '');
	 
	 //TODO: Fix the path to the file
	 $.get( service, {
	 m: 'readFile',
	 f: '/Applications/MAMP/htdocs/CodeGen/' + newFile
	 }, function(data)
	 {
	 $("#outputCode").html( data ).chili();
	 });
	 });
	 * ====================================================================== */
	/**
	 * Gets all databases when password input is out of focus
	 */
	$("#txt_pass").blur(function(){
		var host = $("#txt_host").val();
		var user = $("#txt_user").val();
		var pass = $("#txt_pass").val()
		
		if (host != '' && user != '' && pass != '') {
		
			$("#cg_db_loader").show();
			$.get(service, {
				m: 'getDatabases',
				h: host,
				u: user,
				p: pass
			}, function(result){
				$("#cg_db_loader").hide();
				var options = '';
				var dbArray = eval(result);
				
				$.each(dbArray, function(i, obj){
					options += '<option>' + dbArray[i]['label'] + '</option>';
				})
				
				for (i = 0; i < dbArray.length; i++) {
				
								}
				$("select#txt_database").html(options).highlightFade('yellow');
			});
		} else {
			return false;
		}
	});
	
	
	/**
	 * Config Form
	 */
	$("#btn_generateConfig").click(function(){
	
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
		}, function(result){
			result = $.trim(result).replace(/[\\]*[\\"]/g, '');
			
			//@TODO: Hack to remove the .. from the url
			cg_config = result;
			
			$("#configLocation").html(result);
			$("#txt_configLocation").val(result).highlightFade("yellow");
		});
	});
	
	/**
	 * Schema Form
	 */
	$("#btn_generateSchema").click(function(){
		$.post(service, {
			m: "generateSchema",
			c: cg_config,
			d: cg_database
		}, function(result){
			result = $.trim(result).replace(/[\\]*[\\"]/g, '');
			cg_schema = result;
			
			$("#schemaLocation").html(result);
			$("#txt_schemaLocation").val(result).highlightFade("yellow");
			
		});
	});
	
	/**
	 * Application Info Form
	 */
	$("#btn_generateApp").click(function(){
	
		cg_config = $("#txt_configLocation").val();
		cg_database = $("#txt_database").val();
		
		$.post(service, {
			m: "generateApplication",
			d: cg_database,
			s: cg_schema
		}, function(result){
			cg_demoURL = 'http://' + window.location.hostname + window.location.pathname + '/' + result
			$('#cg_window_preview').attr('src', cg_demoURL);
    		$('#cg_window').dialog('open');
		});
	});
	
	/**
	 * Gets the url
	 */
	var getDemoURL = function(){
		$.get(service, {
			m: 'getHTMLDemo'
		}, function(result){
		
				// result = $.trim( result ).replace( /[\\]*[\\"]/g, '' );
			//$("#iframe_preview").attr("src", result);
		});
	}
	
	
	/**
	 * @deprecated - Not using this for database management
	 * Gets all databases and tables for management
	 */
	$('.db').blur(function(){
		var db = this.text;
		$.get(service, {
			m: 'getTables',
			h: $("#txt_host").val(),
			u: $("#txt_user").val(),
			p: $("#txt_pass").val(),
			d: db
		}, function(result){
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
	$("#svcMessage").ajaxSend(function(request, settings){
		$(this).html('<p class="notice">Starting request at ' + settings.url + '</p>');
	});
	
	$("#svcMessage").ajaxSuccess(function(request, settings){
		$(this).html('<p class="success">Successful Request!</p>');
	});
	
	$("#svcMessage").ajaxComplete(function(request, settings){
		$(this).html('<p class="success">Request Complete.</p>');
	});
	
	$("#svcMessage").ajaxError(function(request, settings){
		$(this).html('<p class="error">Error requesting page ' + settings.url + '</p>');
	});
	
	$("#cg_global_loader").ajaxStart(function(){
		$(this).show();
	});
	
	$("#cg_global_loader").ajaxStop(function(){
		$(this).hide();
	});
	
	
	$('.cg_info span, .cg_error span, .cg_notice span, .cg_success span').live('click', function(){
		$(this).parent().remove();
	});
	
	/**
	 * Settings form that updates the sqlite database
	 */
	$('#btn_settings_save').click(function(){
	
		$.post(service, {
			m: 'saveSettings',
			sdk_path: $('#txt_settings_sdk').val(),
			host: $('#txt_settings_host').val(),
			user: $('#txt_settings_user').val(),
			pass: $('#txt_settings_pass').val()
		
		}, function(result){
			//alert(result);
			$('#form_settings .cg_message').html('<p class="cg_info">Settings updated. <span>x</span></p>');
		});
		
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
		    'Save': function(){
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
		    'Cancel': function(){
		        $(this).dialog('close');
		    }
		}
	});
	
	$('.btn_app_remove').live('click', function(){
	    var item = $(this);
		$.post(service, {
			m: 'removeApp',
			id: $(this).attr('rel')
		}, function( result )
		{
			item.remove('slow');
		})
	});
    
	
	$('.cg_preview').click(function(){
	    $('#cg_window_preview').attr('src', $(this).attr('href'));
		$('#cg_window').dialog('open');
		return false;
	});
	
	
	
	
	
})
