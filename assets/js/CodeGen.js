
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
	
	
	
	/**
	 * Gets all databases when password input is out of focus
	 */
	$("#btn_load_databases").click(function(){
		var host = $("#txt_host").val();
		var user = $("#txt_user").val();
		var pass = $("#txt_pass").val()
		
		if (host != '' && user != '' && pass != '') {
			$.get(service, {
				m: 'getDatabases',
				h: host,
				u: user,
				p: pass
			}, function(result){
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
	$("#btn_generateApp").click(function(){
	
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
				createSchema();
        		
		});
	});
		 
	function createSchema(){
	    
	    $.post(service, {
			m: "generateSchema",
			c: cg_config,
			d: cg_database
		}, function(result){
			result = $.trim(result).replace(/[\\]*[\\"]/g, '');
			cg_schema = result;
			createApplication();
		});
	}
	
	function createApplication(){
		$.post(service, {
			m: "generateApplication",
			d: cg_database,
			s: cg_schema
		}, function(result){
			cg_demoURL = 'http://' + window.location.hostname + window.location.pathname + '/' + result
			alert( cg_demoURL );
			
			saveApplication();
		});
	}
	
	function saveApplication(){
         $.post(service, {
    			m: 'saveApp',
    			name: cg_app,
    			url: cg_demoURL,
    			config: cg_config,
    			schema: cg_schema
    		}, function(resultObj) {
			//
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
		$(this).parent().slideUp();
	});
	
	/**
	 * Settings form that updates the sqlite database
	 */
	$('.btn_settings_save').click(function(){
	
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
		
		}, function(result){
			//alert(result);
			$('#cg_message').fadeIn().html('<p class="cg_info">Settings updated. <span>x</span></p>');
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
			item.slideUp('slow');
		})
	});
    
	$('.cg_preview').click(function(){
	    $('#cg_window_preview').attr('src', $(this).attr('href'));
		$('#cg_window').dialog('open');
		return false;
	});
	
	/**
	 * Show/Hides .cg_box divs when h3 is clicked. 
	 * @depreciated - Now using jquery mobile.
	$('.cg_box h3').bind('click', function(){
		$(this).parents('.cg_box:first').find('.cg_box_content').slideToggle('fast');
	});
	 */
	
});