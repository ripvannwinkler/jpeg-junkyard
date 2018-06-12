<?php
//This init class is used to add the extension to the extensions list while you are developing them.
//When the extension is added to the supported list of extensions, this file is no longer needed.

if ( !class_exists( 'JPEG_Junkyard_Template_FooGallery_Extension_Init' ) ) {
	class JPEG_Junkyard_Template_FooGallery_Extension_Init {

		function __construct() {
			add_filter( 'foogallery_available_extensions', array( $this, 'add_to_extensions_list' ) );
		}

		function add_to_extensions_list( $extensions ) {
			$extensions[] = array(
				'slug'=> 'jpeg-junkyard',
				'class'=> 'JPEG_Junkyard_Template_FooGallery_Extension',
				'title'=> __('JPEG Junkyard', 'foogallery-jpeg-junkyard'),
				'file'=> 'foogallery-jpeg-junkyard-extension.php',
				'description'=> __('', 'foogallery-jpeg-junkyard'),
				'author'=> 'Chris Vann',
				'author_url'=> 'https://www.github.com/ripvannwinkler',
				'thumbnail'=> JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_URL . '/assets/extension_bg.png',
				'tags'=> array( __('template', 'foogallery') ),	//use foogallery translations
				'categories'=> array( __('Build Your Own', 'foogallery') ), //use foogallery translations
				'source'=> 'generated'
			);

			return $extensions;
		}
	}

	new JPEG_Junkyard_Template_FooGallery_Extension_Init();
}