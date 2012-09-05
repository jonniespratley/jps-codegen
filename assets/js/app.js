(function ($) {
window.AppView = Backbone.View.extend({
	el: $("#app-view"),
	events: {
	"click #add-friend":  "showPrompt",
	},
	showPrompt: function () {
		var friend_name = prompt("Who is your friend?");
	}
});
	var appview = new AppView;
	
})(jQuery);
