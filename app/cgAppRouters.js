//Controller
var cgAppRouter = Backbone.Router.extend({
	initialize: function(options) {

  		// Matches #page/10, passing "10"
  		//this.route("page/:number", "page", function(number){ ... });

  		// Matches /117-a/b/c/open, passing "117-a/b/c"
  	//	this.route(/^(.*?)\/open/, "open", function(id){ ... });

	},
  routes: {
    "help":                 "help",    // #help
    "search/:query":        "search",  // #search/kiwis
    "search/:query/p:page": "search"   // #search/kiwis/p7
  },
openPage: function(pageNumber) {
  this.document.pages.at(pageNumber).open();
  this.navigate("page/" + pageNumber);
},




  help: function() {
    //...
	alert("Help");
  },

  search: function(query, page) {
    //...
	alert("Search");
  },

	databases: function(name){
		alert("Show Databases");		
	},
	tables: function(db){
		alert("Show Tables");
	}
	
});