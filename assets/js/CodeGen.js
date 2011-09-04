

 
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
	/*
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
*/
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