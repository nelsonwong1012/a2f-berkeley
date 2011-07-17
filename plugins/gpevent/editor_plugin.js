/**
 * editor_plugin_src.js
 *
 * Copyright 2010, Gracepoint: Brian Wang
 * 
 */

(function() {
	tinymce.create('tinymce.plugins.GPEventPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceGPEventPlugin', function() {
				ed.windowManager.open({
					file : url + '/event.htm',
					width : 480 + parseInt(ed.getLang('advimage.delta_width', 0)),
					height : 185 + parseInt(ed.getLang('advimage.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('gpevent', {
				title : 'Gracepoint Event',
				cmd : 'mceGPEventPlugin',
				image : '../wp-content/plugins/gpevent/img/event.gif'
			});
		},

		getInfo : function() {
			return {
				longname : 'Gracepoint Event',
				author : 'Brian Wang',
				authorurl : 'http://www.kairosfellowship.org/riverside',
				infourl : 'http://www.kairosfellowship.org/riverside',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('gpevent', tinymce.plugins.GPEventPlugin);
})();