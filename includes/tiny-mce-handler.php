<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	/**
	 * Handle Tiny MCE
	 *
	 * @class    Tiny_Mce_Handler
	 * @version    1.0.0
	 * @package    -
	 * @category  Class
	 * @author    -
	 */
	class Tiny_Mce_Handler {

		private $name = 'tiny-mce-handler';

		public static function init() {
			add_filter( 'mce_external_plugins', array( __CLASS__, 'add_table_plugin' ) );
			add_filter( 'mce_buttons', array( __CLASS__, 'tinymce_buttons_1' ) );
			add_filter( 'mce_buttons_2', array( __CLASS__, 'tinymce_buttons_2' ) );
			add_filter( 'tiny_mce_before_init', array( __CLASS__, 'tinymce_custom_colors' ) );
			add_filter( 'tiny_mce_before_init', array( __CLASS__, 'tinymce_insert_formats' ) );
		}

		// Filter Tiny MCE buttons which appears on the first buttons line
		public static function tinymce_buttons_1( $buttons ) {
			$remove = array(
					'formatselect'
				// 'bold',
				// 'italic',
				// 'bullist',
				// 'numlist',
				// 'wp_more',
				// 'wp_adv'
			);

			// Display font-size select dropdown
			// array_unshift($buttons, 'fontsizeselect');
			// Display font-familly select dropdown
			// array_unshift($buttons, 'fontselect');
			// Display style select dropdown
			array_unshift( $buttons, 'styleselect' );

			// array_push($buttons, 'table');
			// array_push($buttons, 'removeformat');
			// array_push($buttons, 'outdent');
			// array_push($buttons, 'indent');
			// array_push($buttons, 'undo');
			// array_push($buttons, 'redo');
			// array_push($buttons, 'forecolor');

			return array_diff( $buttons, $remove );
		}

		// Filter Tiny MCE buttons which appears on the second buttons line
		public static function tinymce_buttons_2( $buttons ) {
			// $remove = array(
			// 	// 'forecolor',
			// 	// 'pastetext',
			// 	// 'charmap',
			// 	'table'
			// );

			// return array_diff($buttons, $remove);
			$buttons[] = 'subscript';
			$buttons[] = 'superscript';
			$buttons[] = 'table';

			return $buttons;
		}


		public static function tinymce_custom_colors( $init ) {
			$default_colours = '"000000", "Noir",
		                    "FFFFFF", "Blanc"';

			$custom_colours = '"2e8bd9", "Bleu",
		                  	"dd6959", "Rouge",
							"de9508", "Orange",
							"E2E2E2", "Gris clair"';

			// build colour grid default+custom colors
			$init['textcolor_map'] = '[' . $default_colours . ',' . $custom_colours . ']';

			// enable 6th row for custom colours in grid
			$init['textcolor_rows'] = 6;

			return $init;
		}

		// Filter Tiny MCE styles dropdown list
		public static function tinymce_insert_formats( $init_array ) {
			// Define the style_formats array
			$style_formats = array(
					array(
							'title' => _x( 'Headings', 'TinyMCE' ),
							'items' => array(
									array(
											'title'   => 'Titre de niveau 2',
											'block'   => 'h2',
											'classes' => 'heading heading--h2'
									),
									array(
											'title'   => 'Titre de niveau 3',
											'block'   => 'h3',
											'classes' => 'heading heading--h3'
									),
									array(
											'title'   => 'Titre de niveau 4',
											'block'   => 'h4',
											'classes' => 'heading heading--h4'
									)
							)
					),
					array(
							'title' => 'Boutons',
							'items' => array(
									array(
											'title'    => 'Bouton bleu',
											'selector' => 'a',
											'classes'  => 'button button--primary'
									),
									array(
											'title'    => 'Bouton jaune',
											'selector' => 'a',
											'classes'  => 'button button--secondary'
									),
									array(
											'title'    => 'Bouton blanc',
											'selector' => 'a',
											'classes'  => 'button button--white'
									),
									array(
											'title'    => 'Bouton noir',
											'selector' => 'a',
											'classes'  => 'button button--black'
									)
							)
					),
					array(
							'title' => 'Listes',
							'items' => array(
									array(
											'title'    => 'Liste à puces par défaut',
											'selector' => 'ul',
											'classes'  => 'list list--unstyled list--coloured-bullet'
									),
									array(
											'title'    => 'Liste à puces colorées',
											'selector' => 'ul',
											'classes'  => 'list list--unstyled list--coloured-bullet list--coloured-bullet--primary'
									)
							)
					),
					array(
							'title' => 'Paragraphe',
							'block' => 'p'
					)
			);

			// Insert the array, JSON ENCODED, into 'style_formats'
			$init_array['style_formats'] = json_encode( $style_formats );

			// Remove the preview of styles in the formats dropdown
			$init_array['preview_styles'] = '';

			return $init_array;
		}

		public static function add_table_plugin( $plugins ) {
			$plugins['table'] = get_template_directory_uri() . '/assets/js/vendors/tiny-mce/table/plugin.min.js';

			return $plugins;
		}
	}
