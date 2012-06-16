//View
var cgAppView = Backbone.View.extend({
	tagName: "body",
	className: "cg-app",

	events: {
		//Define all events for this view
		"click .cg-gen-databases-btn" 	: "cg_getDatabases", 
		"click .cg-gen-tables-btn" 		: "cg_getTables",
		"click .cg-gen-backbone-btn" 	: "cg_generateBBCode",
		"click .cg-gen-html-btn" 		: "cg_generateHTMLCode",
		"click .cg-gen-php-btn" 		: "cg_generatePHPCode",
		"click .cg-gen-jqm-btn" 		: "cg_generateJQMCode"
		
	},
	
	
	initialize: function() {
		//anytime view is updated, render view
		_.bindAll( this, "render" );
	},
	
	render: function() {
		//Load icanhaz template
		
	}, 
	
	
	cg_getDatabases: function(){
		alert('cg_getDatabases');
	},
	cg_getTables: function(){
		
	},
	cg_generateBBCode: function(){
		
	},
	cg_generateHTMLCode: function(){
		
	},
	cg_generatePHPCode: function(){
		
	},
	cg_generateJQMCode: function(){
		
	},

});