$(function(){
	var CG_SETTINGS_COOKIE = 'cgSettingsCookie';
	var CG_HISTORY_COOKIE = 'cgHistoryCookie';
	var options = {
		path: '/',
		expires: 10
	};
	var CG_APP_COUNT = 0;
	var CG_APP_NAME = '';
	var CG_APP_URL = '';
	
	// set cookie by number of days
	$('.setCookie').click(function(){
	
		$.cookie(CG_SETTINGS_COOKIE, 'test', options);
		
		return false;
	});
	
	// get cookie
	$('.getCookie').click(function(){
	
		//alert($.cookie( CG_SETTINGS_COOKIE ) );
		
		$("#history").append('<li>' + +'</li>');
		return false;
	});
	
	// delete cookie
	$('.deleteCookie').click(function(){
		$.cookie(CG_SETTINGS_COOKIE, null, options);
		
		return false;
	});
	
	// set a second cookie
	$('.setHistoryCookie').click(function(){
		var historyData = [{
			appName: $("#appName").val(),
			appURL: $("#appURL").val()
		}]
		
		$.cookie(CG_HISTORY_COOKIE, historyData, options);
		
		return false;
	});
	
	// get second cookie
	$('.getHistoryCookie').click(function(){
	
		var history = $.cookie(CG_HISTORY_COOKIE);
		
		$("#debug").append(history[0].appName);
		
		return false;
	});
	
	// delete second cookie
	$('.deleteHistoryCookie').click(function(){
		$.cookie(CG_HISTORY_COOKIE, null);
		
		return false;
	});
	
});
