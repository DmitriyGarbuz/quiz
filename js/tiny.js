var protokol = window.location.protocol;
var hostname = window.location.hostname;
var theme = $('#defaultTheme').attr('data-theme');
tinymce.init({ 
    mode : "specific_textareas",
	editor_selector : "mceAdmin",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor textcolor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste responsivefilemanager colorpicker textpattern"
    ],
   
	rel_list: [
        {title: '', value: ''},{title: 'Lightbox', value: 'lightbox'},{ title: 'Lightbox gallery1', value: 'lightbox[1]'},{ title: 'Lightbox gallery2', value: 'lightbox[2]'},{ title: 'Lightbox gallery3', value: 'lightbox[3]'}
    ],
   
	toolbar1: "fontselect fontsizeselect | forecolor backcolor | bold italic underline",
	toolbar2: "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager | link unlink anchor | image media | print preview code",
  
	relative_urls : false,
	force_br_newlines : true, 
	forced_root_block : '',
	force_p_newlines : false,
	content_css : theme,
	image_advtab: true ,
	link_advtab: true,
   
	external_plugins: { "filemanager" : protokol+"//"+hostname+"/js/tinymce/plugins/responsivefilemanager/plugin.min.js"},
	
	filemanager_title:"Responsive Filemanager",
	external_filemanager_path:protokol+"//"+hostname+"/js/tinymce/plugins/responsivefilemanager/",
	file_picker_types: 'file image media',
	file_picker_callback: function(cb, value, meta) {
	var width = window.innerWidth-30;
	var height = window.innerHeight-60;
	if(width > 1800) width=1800;
	if(height > 1200) height=1200;
	if(width>600){
	var width_reduce = (width - 20) % 138;
	width = width - width_reduce + 10;
	}
	var urltype=2;
	if (meta.filetype=='image') { urltype=1; }
	if (meta.filetype=='media') { urltype=2; }
	var title="RESPONSIVE FileManager";
	if (typeof this.settings.filemanager_title !== "undefined" && this.settings.filemanager_title) {
	title=this.settings.filemanager_title;
	}
	var akey="key";
	if (typeof this.settings.filemanager_access_key !== "undefined" && this.settings.filemanager_access_key) {
	akey=this.settings.filemanager_access_key;
	}
	var sort_by="";
	if (typeof this.settings.filemanager_sort_by !== "undefined" && this.settings.filemanager_sort_by) {
	sort_by="&sort_by="+this.settings.filemanager_sort_by;
	}
	var descending="false";
	if (typeof this.settings.filemanager_descending !== "undefined" && this.settings.filemanager_descending) {
	descending=this.settings.filemanager_descending;
	}
	var fldr="";
	if (typeof this.settings.filemanager_subfolder !== "undefined" && this.settings.filemanager_subfolder) {
	fldr="&fldr="+this.settings.filemanager_subfolder;
	}
	var crossdomain="";
	if (typeof this.settings.filemanager_crossdomain !== "undefined" && this.settings.filemanager_crossdomain) {
	crossdomain="&crossdomain=1";
	// Add handler for a message from ResponsiveFilemanager
	if(window.addEventListener){
	window.addEventListener('message', filemanager_onMessage, false);
	} else {
	window.attachEvent('onmessage', filemanager_onMessage);
	}
	}
	tinymce.activeEditor.windowManager.open({
	title: title,
	file: this.settings.external_filemanager_path+'dialog.php?type='+urltype+'&descending='+descending+sort_by+fldr+crossdomain+'&lang='+this.settings.language+'&akey='+akey,
	width: width,
	height: height,
	resizable: true,
	maximizable: true,
	inline: 1
	}, {
	setUrl: function (url) {
	cb(url);
	}
	});
	},
	
});

tinymce.init({
    mode : "specific_textareas",
	editor_selector : "mceSubsc",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor textcolor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste responsivefilemanager colorpicker textpattern"
    ],
   
	rel_list: [
       {title: '', value: ''},{title: 'Lightbox', value: 'lightbox'},{ title: 'Lightbox gallery1', value: 'lightbox[1]'},{ title: 'Lightbox gallery2', value: 'lightbox[2]'},{ title: 'Lightbox gallery3', value: 'lightbox[3]'}
    ],
   
	toolbar1: "fontselect fontsizeselect | forecolor backcolor | bold italic underline",
	toolbar2: "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager | link unlink anchor | image media | print preview code",
  
	relative_urls: false,
    remove_script_host: false,
	force_br_newlines : true, 
	forced_root_block : '',
	force_p_newlines : false,
	content_css : theme,
	image_advtab: true ,
	link_advtab: true,
	
	external_plugins: { "filemanager" : protokol+"//"+hostname+"/js/tinymce/plugins/responsivefilemanager/plugin.min.js"},
	
	filemanager_title:"Responsive Filemanager",
	external_filemanager_path:protokol+"//"+hostname+"/js/tinymce/plugins/responsivefilemanager/",
	file_picker_types: 'file image media',
	file_picker_callback: function(cb, value, meta) {
	var width = window.innerWidth-30;
	var height = window.innerHeight-60;
	if(width > 1800) width=1800;
	if(height > 1200) height=1200;
	if(width>600){
	var width_reduce = (width - 20) % 138;
	width = width - width_reduce + 10;
	}
	var urltype=2;
	if (meta.filetype=='image') { urltype=1; }
	if (meta.filetype=='media') { urltype=2; }
	var title="RESPONSIVE FileManager";
	if (typeof this.settings.filemanager_title !== "undefined" && this.settings.filemanager_title) {
	title=this.settings.filemanager_title;
	}
	var akey="key";
	if (typeof this.settings.filemanager_access_key !== "undefined" && this.settings.filemanager_access_key) {
	akey=this.settings.filemanager_access_key;
	}
	var sort_by="";
	if (typeof this.settings.filemanager_sort_by !== "undefined" && this.settings.filemanager_sort_by) {
	sort_by="&sort_by="+this.settings.filemanager_sort_by;
	}
	var descending="false";
	if (typeof this.settings.filemanager_descending !== "undefined" && this.settings.filemanager_descending) {
	descending=this.settings.filemanager_descending;
	}
	var fldr="";
	if (typeof this.settings.filemanager_subfolder !== "undefined" && this.settings.filemanager_subfolder) {
	fldr="&fldr="+this.settings.filemanager_subfolder;
	}
	var crossdomain="";
	if (typeof this.settings.filemanager_crossdomain !== "undefined" && this.settings.filemanager_crossdomain) {
	crossdomain="&crossdomain=1";
	// Add handler for a message from ResponsiveFilemanager
	if(window.addEventListener){
	window.addEventListener('message', filemanager_onMessage, false);
	} else {
	window.attachEvent('onmessage', filemanager_onMessage);
	}
	}
	tinymce.activeEditor.windowManager.open({
	title: title,
	file: this.settings.external_filemanager_path+'dialog.php?type='+urltype+'&descending='+descending+sort_by+fldr+crossdomain+'&lang='+this.settings.language+'&akey='+akey,
	width: width,
	height: height,
	resizable: true,
	maximizable: true,
	inline: 1
	}, {
	setUrl: function (url) {
	cb(url);
	}
	});
	},
	
});