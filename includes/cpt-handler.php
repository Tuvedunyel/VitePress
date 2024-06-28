<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	/**
	 * Handles services posts
	 *
	 * @class       services_Handler
	 * @version     1.0.0
	 * @package     -
	 * @category    Class
	 * @author      -
	 */
	class CPTs_Handler {

		private $name = 'cpt-handler';

		public static function init() {
			add_action( 'init', array( __CLASS__, 'register_post_types' ) );
		}

		public static function register_post_types() {
			register_post_type( 'a_cpt', array(
					'label'               => 'A Custom Post type',
					'labels'              => array(
							'name'               => 'A Custom Post type',
							'singular_name'      => 'A Custom Post type',
							'all_items'          => 'Touts les Custom Post type',
							'add_new_item'       => 'Ajouter un Custom Post type',
							'edit_item'          => 'Éditer le Custom Post type',
							'new_item'           => 'Nouveau Custom Post type',
							'view_item'          => 'Voir le Custom Post type',
							'search_items'       => 'Rechercher parmi les Custom Post type',
							'not_found'          => 'Pas de Custom Post type',
							'not_found_in_trash' => 'Pas de Custom Post type'
					),
					'description'         => 'A Custom Post type',
					'public'              => true,
					'menu_position'       => 4,
					'supports'            => array(
							'title',
							'editor',
							'thumbnail'
					),
					'taxonomies'          => array( 'category' ),
					'menu_icon'           => 'dashicons-smiley',
					'capability_type'     => 'post',
					'has_archive'         => true,
					'exclude_from_search' => true,
					'publicly_queryable'  => true
			) );
		}

		public static function get_cpts( $limit = - 1, $categories_filters = array() ) {
			$cpts = array();

			$args = array(
					'post_type'      => array( 'cpt' ),
					'post_status'    => array( 'publish' ),
					'posts_per_page' => - 1,
					'category__in'   => ( ! empty( $categories_filters ) ) ? implode( ',', $categories_filters ) : ''
			);
			if ( ! empty( $categories_filters ) && is_array( $categories_filters ) ) {
				$args['category__in'] = implode( ',', $categories_filters );
			}
			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$cpt_id = get_the_ID();

					$cpt          = new stdClass();
					$cpt->link    = ( ! empty( $cpt_external_link ) ? $cpt_external_link : get_the_permalink( $cpt_id ) );
					$cpt->logo    = get_field( 'cpt_logo', $cpt_id );
					$cpt->media   = get_field( 'media_choice', $cpt_id );
					$cpt->img     = get_field( 'cpt_main_image' );
					$cpt->gallery = get_field( 'cpt_images', $cpt_id );
					$cpt->title   = get_the_title( $cpt_id );
					$cpt->content = get_the_content( $cpt_id );
					// $cpt->text = get_field('cpt_content', $cpt_id);

					array_push( $cpts, $cpt );
				}
			}

			wp_reset_postdata();

			return $cpts;
		}
	}

