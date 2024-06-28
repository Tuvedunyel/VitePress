<?php

	/**
	 * Get other templates passing attributes and including the file.
	 */
	function tribu_get_template( $template_name, $args = array(), $return_include_result = false, $use_locate_template = true ) {
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args );
		}

		if ( $use_locate_template === true ) {
			$located = locate_template( $template_name );
		} else {
			$located = $template_name;
		}

		if ( ( $use_locate_template === true && empty( $located ) ) || ( $use_locate_template === false && ! file_exists( $located ) ) ) {
			var_dump( sprintf( '<code>%s</code> does not exist.', ( ! empty( $located ) ? $located : $template_name ) ) );

			return;
		}

		if ( ! $return_include_result ) {
			include( $located );
		} else {
			ob_start();
			include( $located );

			return ob_get_clean();
		}
	}

	function tribu_get_form_id( $form_title = '' ) {
		if ( empty( $form_title ) || ( ! class_exists( 'RGFormsModel' ) ) ) {
			return false;
		} else {
			return RGFormsModel::get_form_id( $form_title );
		}
	}

	function get_remote_ip_address() {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			return $_SERVER['HTTP_CLIENT_IP'];
		} else if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		return $_SERVER['REMOTE_ADDR'];
	}

	function get_logo( $location = 'header' ) {
		$html = get_custom_logo();

		if ( $location === 'header' ) {
			$html = str_replace( 'custom-logo-link', 'site-header__logo-link', $html );
			$html = str_replace( 'custom-logo', 'site-header__logo', $html );
		} else if ( $location === 'footer' ) {
			$html = str_replace( 'custom-logo-link', 'footer__logo-link', $html );
			$html = str_replace( 'custom-logo', 'footer__logo', $html );
		}

		return $html;
	}

