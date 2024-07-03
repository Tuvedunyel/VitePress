<?php
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

  require_once 'includes/admin-handler.php';
  require_once 'includes/tiny-mce-handler.php';
  require_once 'includes/utility-functions.php';


  define( 'IS_VITE_DEVELOPMENT', true );

  include "inc/inc.vite.php";
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'title-tag' );

  add_filter( 'show_admin_bar', '__return_false' );

  add_filter( 'wpcf7_autop_or_not', '__return_false' );
