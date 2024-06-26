<?php
if (!defined('ABSPATH')) {
    exit;
}
define(
    'IS_VITE_DEVELOPMENT',
    true
);

include "inc/inc.vite.php";
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );

add_filter(
    'show_admin_bar',
    '__return_false'
);

add_filter(
    'wpcf7_autop_or_not',
    '__return_false'
);
