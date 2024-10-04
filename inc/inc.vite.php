<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/includes/admin-handler.php';
require_once get_template_directory() . '/includes/tiny-mce-handler.php';
require_once get_template_directory() . '/includes/utility-functions.php';

define('DIST_DEF', 'dist');

define('DIST_URI', get_template_directory_uri() . '/' . DIST_DEF);
define('DIST_PATH', get_template_directory() . '/' . DIST_DEF);

define('JS_DEPENDENCY', array());
define('JS_LOAD_IN_FOOTER', true);

define('VITE_SERVER', 'http://localhost:3000');
define('VITE_ENTRY_POINT', '/script.ts');

class TribuVite {

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('init', [$this, 'register_menus']);
        add_action('after_setup_theme', [$this, 'declare_theme_support']);
        add_action('after_setup_theme', [$this, 'tribu_theme_language']);
        add_action('after_setup_theme', [$this, 'declare_filters']);
        add_action('after_setup_theme', [$this, 'add_image_size']);
        // add_action('admin_init', [$this, 'add_editor_styles']);
        // add_action('acf/input/admin_enqueue_scripts', array($this, 'acf_admin_enqueue_scripts'));
        add_filter('wp_nav_menu_objects', [$this, 'my_wp_nav_menu_objects'], 10, 2);

        $this->init_components();
    }

    public function register_menus() {
        register_nav_menus(
            array(
            'main-menu' => __('Main menu', 'tribu'),
            'secondary-menu' => __('Menu secondaire', 'tribu'),
            'social-menu' => __('Social networks menu', 'tribu'),
            'footer-menu' => __('Footer menu', 'tribu'),
            )
        );
    }

    public function init_components() {
        Tiny_Mce_Handler::init();
        Admin_Handler::init();
    }

    public function declare_options_page($options_page) {
        foreach ($options_page as $page) {
            if (function_exists('acf_add_options_page')) {
                acf_add_options_page(array(
                    'page_title' => $page['name'],
                    'icon_url' => $page['icon_url']
                ));
            }
        }
    }

    public function add_image_size() {
        add_image_size('news-thumb', 700, 700, true);
    }

    public function declare_theme_support() {
        $logo_defaults = array(
            'height' => 200,
            'width' => 200,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => array('site-title', 'site-descritpion'),
        );

        add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script']);
        add_theme_support('menus');
        add_theme_support('title-tag');
        add_theme_support('custom-logo', $logo_defaults);
        add_theme_support('post-thumbnails', ['post', 'page']);
    }

    public function declare_filters() {
        add_filter( 'show_admin_bar', '__return_false' );
        add_filter('wpcf7_autop_or_not', '__return_false');
    }

    public function tribu_theme_language() {
        load_theme_textdomain('tribu', get_template_directory() . '/languages');
    }

    public function acf_admin_enqueue_scripts() {
        wp_enqueue_script('acf-admin-js', get_template_directory_uri() . '/assets/js/vendors/acf-color-picker.js', array(), '1.0.0', true);
        wp_enqueue_style('acf-admin-css', get_stylesheet_directory_uri() . '/assets/css/vendors/acf-admin.css', false, '1.0.0');
    }

    public function add_editor_styles() {
        add_editor_style('editor-style.css');
    }

    public function enqueue_scripts() {
        if (defined('IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT === true) {

            function vite_head_module_hook()
        {
            echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ENTRY_POINT . '"></script>';
        }
            add_action('wp_head', 'vite_head_module_hook');
        } else {
            $manifest = json_decode(file_get_contents(DIST_PATH . '/.vite/manifest.json'), true);
            if (is_array($manifest)) {
                $manifest_key = array_keys($manifest);
                $last_key = end($manifest_key);
                if ($last_key && is_array($manifest[$last_key] )) {
                    foreach ($manifest[$last_key]['css'] as $css_file) {
                        wp_enqueue_style('main', DIST_URI . '/' . $css_file);
                    }
                    $js_file = $manifest[$last_key]['file'];
                    if (!empty($js_file)) {
                        wp_enqueue_script('main', DIST_URI . '/' . $js_file, JS_DEPENDENCY, '', JS_LOAD_IN_FOOTER);
                    }
                }
            }
        }
    }

    public function my_wp_nav_menu_objects($items, $args)
    {
        if ($args->theme_location == 'secondary-menu') {
            function classes($classes)
            {
                foreach ($classes as $class) {
                    return $class;
                }
            }

            foreach ($items as &$item) {
                $img = get_field('image', $item);
                $img_hover = get_field('image_hover', $item);
                $color = get_field_object('couleur', $item);
                $item->title = '<span class="' . esc_attr($color['value']) . '">
                <img class="init-img" src="' . esc_url($img['url']) . '" alt="' . esc_attr($img['alt']) . '" />
                <img class="hover-img" src="' . esc_url($img_hover['url']) . '" alt="' . esc_attr($img_hover['alt']) . '" />' . $item->title . '</span>';
            }

            return $items;
        }

        foreach ($items as &$item) {
            $icon = get_field('network', $item);

            if ($icon) {
                $item->title = ' <span class="screen-reader-text">' . $item->title . '</span><span class="icon-' . $icon . '"></span>';
            }
        }
        return $items;
    }
}

/*
* Under this comment, you can find the old version of this file.
* You can delete it if you want.
*/

// add_action('wp_enqueue_scripts', function () {
//  if (defined('IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT === true) {

//         function vite_head_module_hook()
//         {
//             echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ENTRY_POINT . '"></script>';
//         }
//         add_action('wp_head', 'vite_head_module_hook');
//     } else {

//         $manifest = json_decode(file_get_contents(DIST_PATH . '/.vite/manifest.json'), true);

//         if (is_array($manifest)) {

//             $manifest_key = array_keys($manifest);
// 						$last_key = end($manifest_key);


//             if ($last_key && is_array($manifest[$last_key] )) {

//                 foreach ($manifest[$last_key]['css'] as $css_file) {
//                     wp_enqueue_style('main', DIST_URI . '/' . $css_file);
//                 }

//                 $js_file = $manifest[$last_key]['file'];
//                 if (!empty($js_file)) {
//                     wp_enqueue_script('main', DIST_URI . '/' . $js_file, JS_DEPENDENCY, '', JS_LOAD_IN_FOOTER);
//                 }
//             }
//         }
//     }
// });
