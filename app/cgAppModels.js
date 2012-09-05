/* 
 * Database Model
 */
var Database = Backbone.Model.extend({
	
	/* initialize - This is called everytime the model is created */
	initialize: function(){
		window.console.log("Model Database Working");
	},
	
	/* defaults - This is where default model properties go */
	defaults: {
		"name":  "value"
	},
	
	/* validate - This will validate fields before model is updated client side */
	validate: function(){
	
	}
});


/* 
 * Table Model
 */
var Table = Backbone.Model.extend({
	
	/* initialize - This is called everytime the model is created */
	initialize: function(){
		window.console.log("Model Table Working");
	},
	
	/* defaults - This is where default model properties go */
	defaults: {
		"name":  "value"
	},
	
	/* validate - This will validate fields before model is updated client side */
	validate: function(){
		
	}
});

/* 
 * Field Model
 */
var Field = Backbone.Model.extend({
	
	/* initialize - This is called everytime the model is created */
	initialize: function(){
		window.console.log("Model Field Working");
	},
	
	/* defaults - This is where default model properties go */
	defaults: {
		"name":  "value"
	},
	
	/* validate - This will validate fields before model is updated client side */
	validate: function(){
	
	}
});






/* 
 * App Model 
 */
var cgAppModel = Backbone.Model.extend({
	
	/* initialize - This is called everytime the model is created */
	initialize: function(){
		window.console.log("Model cgAppModel Working");
	},
	
	/* defaults - This is where default model properties go */
	defaults: {
		"version":  "1.9.3",
		"title" : "jps-codegen",
		"author" : "Jonnie Spratley",
		"host" : "localhost",
		"user" : "root",
		"pass" : "fred",
		"db" : "jps_codegen"
	
	},
	
	/* validate - This will validate fields before model is updated client side */
	validate: function(){
	
	}
});
