/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.language = 'ar';
       
	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.extraPlugins = 'doksoft_image,doksoft_preview,doksoft_resize';
	config.doksoft_uploader_url = 'http://www.afaq-n.com.sa/our_cp/assets/js/plugins/ckeditor/plugins/doksoft_uploader/uploader.php';

};
