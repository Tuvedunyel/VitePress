<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	/**
	 *
	 * @class       Multilanguage_Handler
	 * @version     1.0.0
	 * @package     -
	 * @category    Class
	 * @author      -
	 */
	class Multilanguage_Handler {

		private static $default_lang;
		private $name = 'multilanguage-handler';

		public static function init() {
			add_filter( 'gform_pre_render', array( __CLASS__, 'set_recaptcha_language' ), 10, 2 );
			add_filter( 'wpseo_title', array( __CLASS__, 'wpml_translate_wpseo_titles' ), 10, 2 );
		}

		// WPML Utils

		/**
		 * @param (int|Required) $element_id : The ID of the post type
		 * @param (string|Required) $element_type : Post, page, {custom post type key}, nav_menu, nav_menu_item, category, post_tag or {custom taxonomy key}
		 * @param (bool|Optional) $return_original_if_missing : If set to TRUE return the original value, if translation is missing
		 * @param (mixed|Optional) $language_code : If set to TRUE return the original value, if translation is missing
		 */
		public static function get_url_for_language( $element_id, $element_type, $return_original_if_missing = false, $language_code = null, $prevent_fallback_url = false ) {
			$lang_post_id = apply_filters( 'wpml_object_id', $element_id, $element_type, $return_original_if_missing, $language_code );

			$url = '';
			if ( $lang_post_id != 0 ) {
				$url = get_permalink( $lang_post_id );
			} else {
				if ( $prevent_fallback_url == false ) {
					// No page found, go to the homepage
					global $sitepress;
					$url = $sitepress->language_url( $language_code );
				}
			}

			return $url;
		}

		public static function get_language_menu() {
			$wpml_languages = icl_get_languages( 'skip_missing=0&orderby=name&order=asc' );
			$languages      = array();

			if ( ! empty( $wpml_languages ) ) {
				foreach ( $wpml_languages as $wpml_language ) {
					$language_code = strtoupper( $wpml_language['code'] );

					switch ( $language_code ) {
						case 'PT-PT':
							$language_code = 'PT';
							break;

						case 'ZH-HANT':
							$language_code = 'CN';
							break;

						default:
							break;
					}

					$language_data = array(
							'code'   => $language_code,
							'url'    => $wpml_language['url'],
							'active' => $wpml_language['active']
					);

					if ( ! $wpml_language['active'] ) {
						$languages[ $language_code ] = $language_data;
					} else {
						$active_language = $language_data;
					}
				}

				// Sort languages array by language codes
				usort( $languages, function ( $a, $b ) {
					return strcmp( $a['code'], $b['code'] );
				} );

				// Add the active language in first position in the languages array
				$languages = array_merge( array( $active_language['code'] => $active_language ), $languages );

				// Display the language selector
				echo '<ul class="language-selector list list--unstyled">';

				foreach ( $languages as $language ) {
					if ( $language['active'] ) {
						echo '<li class="language-selector__language-name language-name--active"><span class="language-name__link">' . $language['code'] . '.</span></li>';
					} else {
						echo '<li class="language-selector__language-name"><a class="language-name__link" href="' . $language['url'] . '">' . $language['code'] . '.</a></li>';
					}
				}

				echo '</ul>';
			}
		}

		public static function get_default_lang() {
			return self::$default_lang;
		}

		public static function set_default_lang( $lang ) {
			self::$default_lang = $lang;
		}

		public static function set_recaptcha_language( $form ) {
			if ( $form['id'] !== tribu_get_form_id( 'Demande de devis' ) ) {
				foreach ( $form['fields'] as &$field ) {
					// If it's the recaptcha field
					if ( $field->type == 'captcha' ) {

						// Must be a language code supported by Google reCAPTCHA - https://developers.google.com/recaptcha/docs/language
						$field->captchaLanguage = self::get_lang();
					}
				}
			}

			return $form;
		}

		public static function get_lang() {
			return defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : self::$default_lang;
		}

		// Workaround required to be able to translate 404 seo title with Yoast v14.2

		public static function wpml_translate_wpseo_titles( $title, $presentation = null ) {
			if ( is_null( $presentation ) ) {
				return $title;
			}

			$source_type     = $presentation->model->object_type;
			$source_sub_type = $presentation->model->object_sub_type;

			$string_domain = '';

			switch ( $source_type ) {
				case 'post-type-archive':
					$string_domain = 'title-ptarchive-';
					break;

				case 'system-page':
					$string_domain   = 'title-' . $source_sub_type . '-wpseo';
					$source_sub_type = '';
					break;
				default:
					return $title;
			}

			return apply_filters( 'wpml_translate_single_string', $title, 'admin_texts_wpseo_titles', '[wpseo_titles]' . $string_domain . $source_sub_type );
		}

	}
