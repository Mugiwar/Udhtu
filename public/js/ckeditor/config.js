/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	//  config.skin = 'office2013';
	 /* config.removePlugins    = 'resize,about,save';


config.toolbar_Full = [
	{ name: 'document', items : [ 'Undo','Redo'] },
	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Subscript','Superscript','Format' ] },
	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
	{ name: 'links', items : [ 'Link','Unlink' ] },
	{ name: 'insert', items : [ 'Image','Table','SpecialChar' ] },
	{ name: 'tools', items : [ 'Maximize','Source'] }
];

	  */


//config.extraPlugins = 'colorbutton';
config.extraPlugins = 'colorbutton';
config.extraAllowedContent = 'a[data-lightbox,data-title]';

config.filebrowserBrowseUrl = 'http://udhtu.edu.ua/public/js/ckeditor/plugins/kcfinder/browse.php?opener=ckeditor&type=1';
   config.filebrowserImageBrowseUrl = 'http://udhtu.edu.ua/public/js/ckeditor/plugins/kcfinder/browse.php?opener=ckeditor&type=1';
   config.filebrowserFlashBrowseUrl = 'http://udhtu.edu.ua/public/js/ckeditor/plugins/kcfinder/browse.php?opener=ckeditor&type=1';
   config.filebrowserUploadUrl = 'http://udhtu.edu.ua/public/js/ckeditor/plugins/kcfinder/upload.php?opener=ckeditor&type=1';
   config.filebrowserImageUploadUrl = 'http://udhtu.edu.ua/public/js/ckeditor/plugins/kcfinder/upload.php?opener=ckeditor&type=1';
   config.filebrowserFlashUploadUrl = 'http://udhtu.edu.ua/public/js/ckeditor/plugins/kcfinder/upload.php?opener=ckeditor&type=1';


config.toolbar = 'budda'; 
	config.toolbar_budda =
	[
		{ name: 'document', items 	: [ 'Source','Preview' ] },
		{ name: 'clipboard', items 	: [ 'Undo','Redo' ] },
		{ name: 'editing', items 	: [ 'Find','Replace'] },
		{ name: 'insert', items 	: [ 'Image','Table','HorizontalRule','Iframe' ] }, //'/',
		{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },		
		//{ name: 'basicstyles', items : [ 'Bold','Italic','-','RemoveFormat' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Subscript','Superscript','-','RemoveFormat','-', 'TextColor' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		//{ name: 'colors', items: [ 'TextColor','BGColor' ] },
		//{ name: 'colors', items: [ 'TextColor' ] },
	];



config.toolbar = 'test'; 
	config.toolbar_test =
	[
		//{ name: 'document', items 	: [ 'Preview' ] },
		{ name: 'clipboard', items 	: [ 'Undo','Redo' ] },
		{ name: 'editing', items 	: [ 'Find','Replace'] },
		{ name: 'insert', items 	: [ 'Image','Table','HorizontalRule','Iframe' ] }, //'/',		
		//{ name: 'basicstyles', items : [ 'Bold','Italic','-','RemoveFormat' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Subscript','Superscript','-','RemoveFormat','-', 'TextColor' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		{ name: 'links', items : [ 'Link','Unlink' ] },
		//{ name: 'colors', items: [ 'TextColor','BGColor' ] },
		//{ name: 'colors', items: [ 'TextColor' ] },
	];





config.toolbar = 'moderator'; 
	config.toolbar_moderator =
	[
	//	{ name: 'document', items 	: [ 'Preview' ] },
		{ name: 'clipboard', items 	: [ 'Undo','Redo' ] },
		{ name: 'editing', items 	: [ 'Find','Replace'] },
		{ name: 'insert', items 	: [ 'Image','Table','HorizontalRule','Iframe' ] }, //'/',		
		//{ name: 'basicstyles', items : [ 'Bold','Italic','-','RemoveFormat' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Subscript','Superscript','-','RemoveFormat','-', 'TextColor' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
			{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		//{ name: 'colors', items: [ 'TextColor','BGColor' ] },
	//	{ name: 'colors', items: [ 'TextColor' ] },
	];










config.colorButton_colors = '000080,F00';
config.colorButton_enableMore = false;








};



