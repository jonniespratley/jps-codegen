var AppModel = Backbone.Model.extend({
	initialize: function () {

		// init and store our OptionsCollection in our app object
		this.options = new OptionCollection();
		this.modules = new ModuleCollection();
	},
	defaults: {
		'appName': 'Cloud Connect',
		'appUrl': 'c2.cumulous.biz',
		'appNs': 'cmlsc2_'
	}
});

var cmlsc2_options = {

};

var cmlsc2_opt_header = {
	cmlsc2_opt_header_id: 'cmlsc2_global_header',
	cmlsc2_opt_header_inline: true,
	cmlsc2_opt_header_position: 'fixed',
	cmlsc2_opt_header_showicons: false,
	cmlsc2_opt_header_shownav: false,
	cmlsc2_opt_header_theme: 'a',
	cmlsc2_opt_header_type: 'default'
};

var cmlsc2_opt_footer = {
	cmlsc2_opt_footer_id: 'cmlsc2_global_footer',
	cmlsc2_opt_footer_inline: true,
	cmlsc2_opt_footer_position: 'fixed',
	cmlsc2_opt_footer_showicons: false,
	cmlsc2_opt_footer_shownav: false,
	cmlsc2_opt_footer_theme: 'a',
	cmlsc2_opt_footer_type: 'default'
};

var cmlsc2_opt_module = {
	cmlsc2_opt_module_id: 'cmlsc2_default_module',
	cmlsc2_opt_module_theme: 'a',
	cmlsc2_opt_module_list_items: 5,
	cmlsc2_opt_module_list_type: 'a',
	cmlsc2_opt_module_list_title: 'Module'
};