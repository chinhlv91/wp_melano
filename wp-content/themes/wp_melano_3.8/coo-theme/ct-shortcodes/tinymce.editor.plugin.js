(function() {

	tinymce.create('tinymce.plugins.cootheme_shortcodes', {
		init : function(ed, url) {

			ed.addCommand('cootheme_shortcodes', function() {
				ed.windowManager.open({
					file : url + '/interface.php',
					width : 500 + ed.getLang('cootheme_shortcodes.delta_width', 0),
					height : 600 + ed.getLang('cootheme_shortcodes.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url
				});
			});
			
			ed.addButton('cootheme_shortcodes', {
				title : 'Cootheme Shortcodes',
				cmd : 'cootheme_shortcodes',
				image : url + '/ct-shortcodes-button.png'
			});
			
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('cootheme_shortcodes', n.nodeName == 'IMG');
			});
			
		},
		
		createControl : function(n, cm) {
			return null;
		},
		
		getInfo : function() {
			return {
					longname  : 'cootheme_shortcodes',
					author 	  : 'Cootheme',
					version   : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('cootheme_shortcodes', tinymce.plugins.cootheme_shortcodes);

})();