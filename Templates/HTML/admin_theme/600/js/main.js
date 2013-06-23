$(document).ready(function(){
						   
	// hide or show the top menu
	var showTop = $.cookie('showTop');

	if ($.cookie('showTop') == 'hide') {
		   $('#toggle-open-btn').show();
		   $('#toggle-close-btn').hide();
		   $("#toggle-box-1").hide();
		   $("#topmenu").show();
	}
	else if ($.cookie('showTop') == 'show')
	{
		   $('#toggle-close-btn').show();
		   $('#toggle-open-btn').hide();
		   $("#toggle-box-1").show();
		   $("#topmenu").hide();
	}
	else
	{
		   $('#toggle-open-btn').show();
		   $('#toggle-close-btn').hide();
		   $("#toggle-box-1").hide();
		   $("#topmenu").show();
	};
	
	// toggle topmenu
	$("a#toggle-open-btn, a#toggle-close-btn").click(function () {
		if ($("#toggle-box-1").is(":hidden")) {
			   $('#toggle-close-btn').show();
			   $('#toggle-open-btn').hide();
			   $("#toggle-box-1").slideDown("slow");
			   $("#topmenu").slideToggle("slow");
			   $.cookie('showTop', 'show');
		} else {
			   $('#toggle-open-btn').show();
			   $('#toggle-close-btn').hide();
			   $("#toggle-box-1").slideUp("slow");
			   $("#topmenu").slideToggle("slow");   
			   $.cookie('showTop', 'hide');
		}
		return false;
	
	});	
		
    // toggle styles
    $("a#toggle-open-btn2, a#toggle-close-btn2").click(function () {
         
		 $('#toggle-box-2').toggle('slide');
		 
		 	 if ($('#toggle-close-btn2').is(":hidden")){
				 $('#toggle-close-btn2').show();
				 $('#toggle-open-btn2').hide();
			  } else {
				 $('#toggle-open-btn2').show();
				 $('#toggle-close-btn2').hide();
			  }
    });
	
    /* Remove and highlighting the dialog boxes */
	$(".del-x").click(function() {
				$(this).parents('.dialog-box').effect("highlight", {}, 100).animate({
					opacity: 0    
				},function () {
					$(this).remove();
				});
		return false;
	  });
	
    /* Code for the sortables more info @ http://jqueryui.com/demos/sortable/ */	
	$('#sort-box').sortable({ 
				handle:      '.content-header-left',
				placeholder: 'sortHelper',
				delay:        250,
				cursor:      'move',
				revert:       true, 
				opacity:      1.0,
				forcePlaceholderSize: true
	});
	
    /* toggle selected box */
	$(".content-header-right").click(function(){
		  $(this).parents(".content-header").next(".content-in").slideToggle("slow");
		  
			 if ($(this).find('a.toggle-close-btn').is(":hidden")){
				 $(this).find('a.toggle-close-btn').show();
				 $(this).find('a.toggle-open-btn').hide();
			  } else {
				 $(this).find('a.toggle-open-btn').show();
				 $(this).find('a.toggle-close-btn').hide();
			  }
	});

    /* Show and hide the dashboard recent comments actions */
	$(".recent-comments-box, .media-row, .theme-row, .theme-row-active").hover(function() {
           $(this).find('p.rc-actions, p.actions, p.theme-actions').show();
           },function () {
              $('p.rc-actions, p.actions, p.theme-actions').hide();
      });											
											
   // more info about this tooltip can befound here @ http://craigsworks.com/projects/qtip/
   $('div.content-settings-row a, div.user-make-row a').qtip({
	   content: { text: true},
	   position: {
		 corner: {
		   target: 'rightMiddle',
		   tooltip: 'leftMiddle'
		 }
       },
	   style:{  
		   name: 'light',
		   tip: 'leftMiddle',
		   textAlign: 'center',
		   border: {
			 width: 2,
			 radius: 5,
			 color: '#ccc'
		  }
	   }
    });

   // more info about this tooltip can befound here @ http://craigsworks.com/projects/qtip/
   $('.styleswitch').qtip({
	   content: { text: true},
	   show: { effect: 'fade' },
	   hide: { effect: 'fade' },
	   position: {
		 corner: {
         target: 'topMiddle',
         tooltip: 'bottomMiddle'
		 }
       },
	   style:{  
		   name: 'dark',
		   tip: true,
		   textAlign: 'center',
		   border: {
			 width: 2,
			 radius: 5,
			 color: '#222'
		  }
	   }
    });
   
	// searchfield value more info @ http://mucur.name/system/jquery_example/
	$('.search-bar').example('Search here');	
	
	// tabs
	$("#tab").tabs({
		selected: 0 // select the first tab
	});									
						
	// remove a row		
	$(".delete-row").click(function() {
		  $(this).parents('.recent-comments-box, .comments-box')
		  .effect("highlight", {}, 100).animate({
			  opacity: 0    
		  },function () {
			  $(this).remove();
		  });
		  $(this).next('.comments-toggle').remove();		
		return false;
	  });

	// remove a row		
	$(".delete-row").click(function() {
		  $(this).parents('.pages-row, .user-row, .media-row')
		  .effect("highlight", {}, 100).animate({
			  opacity: 0    
		  },function () {
			  $(this).remove();
		  });
		  $(this).parents(".pages-row, .user-row").next("div").remove();		
		return false;
	  });
	
	// remove a row		
	$(".delete-row").click(function() {
		  $(this).parents('.theme-row')
		  .effect("highlight", {}, 100).animate({
			  opacity: 0    
		  },function () {
			  $(this).remove();
		  });
		  $(this).next('.theme-toggle').remove();		
		return false;
	  });
	
    // Editor, more info about this jQuery plugin @ http://markitup.jaysalvat.com/home/
   // $('.editor-textarea, .editor-textarea-2').markItUp(mySettings);
	
    // And you can add/remove markItUp! whenever you want
	// $(textarea).markItUpRemove();
	$('.remove-editor').click(function() {
		if ($(".editor-textarea.markItUpEditor").length === 1) {
 			$(".editor-textarea").markItUpRemove();
			$("span", this).html("<img src='images/icons/16/image-resize.png' alt='' />");
		} else {
			$('.editor-textarea').markItUp(mySettings);
			$("span", this).html("<img src='images/icons/16/image-resize-actual.png' alt='' />");
		}
 		return false;
	});
	
    // extra remove for the editor on the pages.html (write a page)
	$('.remove-editor-2').click(function() {
		if ($(".editor-textarea-2.markItUpEditor").length === 1) {
 			$(".editor-textarea-2").markItUpRemove();
			$("span", this).html("<img src='images/icons/16/image-resize.png' alt='' />");
		} else {
			$('.editor-textarea-2').markItUp(mySettings);
			$("span", this).html("<img src='images/icons/16/image-resize-actual.png' alt='' />");
		}
 		return false;
	});	
	
	/* fade the theme images to */
	$("div.theme-row").fadeTo("slow", 0.5); 
	$("div.theme-row").hover(function(){
			$(this).fadeTo("fast", 1.0); 
		},function(){
			$(this).fadeTo("fast", 0.5);
		});
 
	/* pngfix, supersleight the jQuery version more info @ http://allinthehead.com/retro/338/supersleight-jquery-plugin */
	$('#toggle-btn-header, .icon-3').supersleight();
	
	// inline toggle(users and pages)
	$(".edit-pages, .edit-user").click(function () {
    	$(this).parents(".user-row, .pages-row").next().slideToggle("fast");
     });
	
	// inline toggle(recent comments, comments and media)
	$(".edit-comments").click(function () {
    	$(this).parents(".comments-right, .recent-comments-right, .media-content").next().slideToggle("fast");
     });
	
	// inline toggle themes
	$(".theme-toggle-link").click(function () {
    	$(".theme-toggle").slideToggle("fast");
     });
	
	// toggle all down
	//$(".collapsall").click(function () {
    //	$(".media-toggle, .comments-toggle, .page-toggle, .user-toggle").slideDown("fast");
    // });
	
	// toggle all up
	//$(".expandeall").click(function () {
    //	$(".media-toggle, .comments-toggle, .page-toggle, .user-toggle").slideUp("fast");
    // });
	
    /* When hover a row it will light up */
	$("div.pages-row").mouseover(function() {
		$(this).addClass("pages-row-over");}).mouseout(function() {
			$(this).removeClass("pages-row-over");
		});
	
	/* When hover a row it will light up */
	$("div.user-row").mouseover(function() {
		$(this).addClass("user-row-over");}).mouseout(function() {
			$(this).removeClass("user-row-over");
		});
	
 
	//make some charts
	// more info @ http://www.filamentgroup.com/lab/jquery_visualize_plugin_accessible_charts_graphs_from_tables_html5_canvas/
//	$('#stats-box table').visualize({type: 'pie', pieMargin: 10});	
//	$('#stats-box table').visualize({type: 'line'});
//	$('#stats-box table').visualize({type: 'area'});
//	$('#stats-box table').visualize();	 	

     // lightbox more info @ http://www.pierrebertet.net/projects/jquery_superbox/
	$.superbox.settings = {
		boxId: "superbox", // Id attribute of the "superbox" element
		boxClasses: "", // Class of the "superbox" element
		overlayOpacity: .8, // Background opaqueness
		//boxWidth: "600", // Default width of the box
		//boxHeight: "400", // Default height of the box
		loadTxt: "Loading", // Loading text
		closeTxt: "Close", // "Close" button text
		prevTxt: "Previous", // "Previous" button text
		nextTxt: "Next" // "Next" button text
	};
	$.superbox();

    // IE6 PNG fix more info @ // http://allinthehead.com/retro/338/supersleight-jquery-plugin
    $('#content, #bottom').supersleight();
	
	// jQuery table sorter more info @ http://tablesorter.com/docs/
	$("#tablesorter").tablesorter(); 
	
	// dialog
	$("#dialog").dialog({
		bgiframe: true,
		height: 140,
		width: 500,
		modal: true,
		buttons: {
			      Ok: function() {
					  $(this).dialog('close');
				      }
			     }
		});
	
});




	




