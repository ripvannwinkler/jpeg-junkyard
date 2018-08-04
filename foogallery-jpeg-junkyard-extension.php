<?php
/**
 * FooGallery JPEG Junkyard Extension
 *
 * 
 *
 * @package   JPEG_Junkyard_Template_FooGallery_Extension
 * @author    Chris Vann
 * @license   GPL-2.0+
 * @link      https://www.github.com/ripvannwinkler
 * @copyright 2014 Chris Vann
 *
 * @wordpress-plugin
 * Plugin Name: FooGallery - JPEG Junkyard
 * Description: 
 * Version:     1.0.4
 * Author:      Chris Vann
 * Author URI:  https://www.github.com/ripvannwinkler
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( !class_exists( 'JPEG_Junkyard_Template_FooGallery_Extension' ) ) {

	define('JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_FILE', __FILE__ );
	define('JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_URL', plugin_dir_url( __FILE__ ));
	define('JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_VERSION', '1.0.4');
	define('JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_PATH', plugin_dir_path( __FILE__ ));
	define('JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_SLUG', 'foogallery-jpeg-junkyard');
	//define('JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_URL', 'http://fooplugins.com');
	//define('JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_ITEM_NAME', 'JPEG Junkyard');

	require_once( 'foogallery-jpeg-junkyard-init.php' );

	class JPEG_Junkyard_Template_FooGallery_Extension {
		/**
		 * Wire up everything we need to run the extension
		 */
		function __construct() {
			add_filter( 'foogallery_gallery_templates', array( $this, 'add_template' ) );
			add_filter( 'foogallery_gallery_templates_files', array( $this, 'register_myself' ) );
			add_filter( 'foogallery_located_template-jpeg-junkyard', array( $this, 'enqueue_dependencies' ) );
			add_filter( 'foogallery_template_js_ver-jpeg-junkyard', array( $this, 'override_version' ) );
			add_filter( 'foogallery_template_css_ver-jpeg-junkyard', array( $this, 'override_version' ) );

			//used for auto updates and licensing in premium extensions. Delete if not applicable
			//init licensing and update checking
			//require_once( JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_PATH . 'includes/EDD_SL_FooGallery.php' );

			//new EDD_SL_FooGallery_v1_1(
			//	JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_FILE,
			//	JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_SLUG,
			//	JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_VERSION,
			//	JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_URL,
			//	JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_ITEM_NAME,
			//	'JPEG Junkyard');
		}

		/**
		 * Register myself so that all associated JS and CSS files can be found and automatically included
		 * @param $extensions
		 *
		 * @return array
		 */
		function register_myself( $extensions ) {
			$extensions[] = __FILE__;
			return $extensions;
		}

		/**
		 * Override the asset version number when enqueueing extension assets
		 */
		function override_version( $version ) {
			return JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_VERSION;
		}

		/**
		 * Enqueue any script or stylesheet file dependencies that your gallery template relies on
		 */
		function enqueue_dependencies() {
			//$js = JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'js/jquery.jpeg-junkyard.js';
			//wp_enqueue_script( 'jpeg-junkyard', $js, array('jquery'), JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_VERSION );

			//$css = JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'css/jpeg-junkyard.css';
			//foogallery_enqueue_style( 'jpeg-junkyard', $css, array(), JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_VERSION );
		}

		/**
		 * Add our gallery template to the list of templates available for every gallery
		 * @param $gallery_templates
		 *
		 * @return array
		 */
		function add_template( $gallery_templates ) {

			$gallery_templates[] = array(
				'slug'        => 'jpeg-junkyard',
				'name'        => __( 'JPEG Junkyard', 'foogallery-jpeg-junkyard'),
				'preview_css' => JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'css/gallery-jpeg-junkyard.css',
				'admin_js'	  => JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'js/admin-gallery-jpeg-junkyard.js',
				'fields'	  => array(
					array(
						'id'      => 'thumbnail_size',
						'title'   => __('Thumbnail Size', 'foogallery-jpeg-junkyard'),
						'desc'    => __('Choose the size of your thumbs.', 'foogallery-jpeg-junkyard'),
						'type'    => 'thumb_size',
						'default' => array(
							'width' => get_option( 'thumbnail_size_w' ),
							'height' => get_option( 'thumbnail_size_h' ),
							'crop' => true
						)
					),
					array(
						'id'      => 'thumbnail_link',
						'title'   => __('Thumbnail Link', 'foogallery-jpeg-junkyard'),
						'default' => 'image' ,
						'type'    => 'thumb_link',
						'spacer'  => '<span class="spacer"></span>',
						'desc'	  => __('You can choose to either link each thumbnail to the full size image or to the image\'s attachment page.', 'foogallery-jpeg-junkyard')
					),
					array(
						'id'      => 'lightbox',
						'title'   => __('Lightbox', 'foogallery-jpeg-junkyard'),
						'desc'    => __('Choose which lightbox you want to use in the gallery.', 'foogallery-jpeg-junkyard'),
						'type'    => 'lightbox'
					),
					array(
						'id'      => 'alignment',
						'title'   => __('Gallery Alignment', 'foogallery-jpeg-junkyard'),
						'desc'    => __('The horizontal alignment of the thumbnails inside the gallery.', 'foogallery-jpeg-junkyard'),
						'default' => 'alignment-center',
						'type'    => 'select',
						'choices' => array(
							'alignment-left' => __( 'Left', 'foogallery-jpeg-junkyard' ),
							'alignment-center' => __( 'Center', 'foogallery-jpeg-junkyard' ),
							'alignment-right' => __( 'Right', 'foogallery-jpeg-junkyard' )
						)
					)
					//available field types available : html, checkbox, select, radio, textarea, text, checkboxlist, icon
					//an example of a icon field used in the default gallery template
					//array(
					//	'id'      => 'border-style',
					//	'title'   => __('Border Style', 'foogallery-jpeg-junkyard'),
					//	'desc'    => __('The border style for each thumbnail in the gallery.', 'foogallery-jpeg-junkyard'),
					//	'type'    => 'icon',
					//	'default' => 'border-style-square-white',
					//	'choices' => array(
					//		'border-style-square-white' => array('label' => 'Square white border with shadow', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-square-white.png'),
					//		'border-style-circle-white' => array('label' => 'Circular white border with shadow', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-circle-white.png'),
					//		'border-style-square-black' => array('label' => 'Square Black', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-square-black.png'),
					//		'border-style-circle-black' => array('label' => 'Circular Black', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-circle-black.png'),
					//		'border-style-inset' => array('label' => 'Square Inset', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-square-inset.png'),
					//		'border-style-rounded' => array('label' => 'Plain Rounded', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-plain-rounded.png'),
					//		'' => array('label' => 'Plain', 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'assets/border-style-icon-none.png'),
					//	)
					//),
				)
			);

			return $gallery_templates;
		}
	}
}