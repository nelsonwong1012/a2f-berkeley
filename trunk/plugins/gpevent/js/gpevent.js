var GPEventDialog = {
	preInit : function() {
		var url;

		tinyMCEPopup.requireLangPack();

		if (url = tinyMCEPopup.getParam("external_image_list_url"))
			document.write('<script language="javascript" type="text/javascript" src="' + tinyMCEPopup.editor.documentBaseURI.toAbsolute(url) + '"></script>');
	},

	init : function(ed) {
		var f = document.forms[0], nl = f.elements, ed = tinyMCEPopup.editor, dom = ed.dom, n = ed.selection.getNode();

		tinyMCEPopup.resizeToInnerSize();
		this.fillClassList('class_list');
		this.fillFileList('src_list', 'tinyMCEImageList');
		this.fillFileList('over_list', 'tinyMCEImageList');
		this.fillFileList('out_list', 'tinyMCEImageList');
		TinyMCE_EditableSelects.init();
	},

	insert : function(file, title) {
		var ed = tinyMCEPopup.editor, t = this, f = document.forms[0];
		var shortcode = '[event ';
		
		if (f.gpdate.value != "")
			shortcode = shortcode + ' date="' + f.gpdate.value + '"';
		if (f.gptime.value != "")
			shortcode = shortcode + ' time="' + f.gptime.value + '"';
		if (f.gplocation.value != "")
			shortcode = shortcode + ' location="' + f.gplocation.value + '"';
		if (f.gpinfo.value != "")
			shortcode = shortcode + ' info="' + f.gpinfo.value + '"';
		if (f.gpname.value != "")
			shortcode = shortcode + "]" + f.gpname.value + "[/event]";
		else
			shortcode = shortcode + "] [/event]";
		
		ed.execCommand('mceInsertContent', false, shortcode, {skip_undo : 1});
		tinyMCEPopup.close();
	}
};

GPEventDialog.preInit();
tinyMCEPopup.onInit.add(GPEventDialog.init, GPEventDialog);