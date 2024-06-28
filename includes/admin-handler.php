<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	/**
	 * Handle admin stuff
	 *
	 * @class       Admin_Handler
	 * @version     1.0.0
	 * @package     -
	 * @category    Class
	 * @author      -
	 */
	class Admin_Handler {

		private $name = 'admin-handler';

		public static function init() {
			add_filter( 'bea.beautiful_flexible.images_path', array( __CLASS__, 'custom_sections_images' ) );
		}

		/*
		* Provide path for sections images
		* Used by `BEA - Beautiful Flexible` plugin
		*/
		public static function custom_sections_images( $path ) {
			return 'assets/img/sections';
		}
	}

