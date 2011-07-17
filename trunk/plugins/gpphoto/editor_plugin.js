/**
 * editor_plugin_src.js
 *
 * Copyright 2010, Gracepoint: Brian Wang
 *
 */

(function() {
	tinymce.create('tinymce.plugins.GPPhotoPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceGPPhotoPlugin', function() {
				ed.windowManager.open({
					file : url + '/photo.htm',
					width : 480 + parseInt(ed.getLang('advimage.delta_width', 0)),
					height : 385 + parseInt(ed.getLang('advimage.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('gpphoto', {
				title : 'Gracepoint Photo',
				cmd : 'mceGPPhotoPlugin',
				image : '../wp-content/plugins/gpphoto/img/photo.gif'
			});
		},

		getInfo : function() {
			return {
				longname : 'Gracepoint Photo',
				author : 'Brian Wang',
				authorurl : 'http://www.acts2fellowship.org/riverside',
				infourl : 'http://www.acts2fellowship.org/riverside',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('gpphoto', tinymce.plugins.GPPhotoPlugin);
})();