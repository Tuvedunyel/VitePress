<?php
/*
* There's no need to add anything in this file. If you do so, you are doing it wrong. Just go to inc/inc.vite.php and edit the TribuVite class.
*/

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

  define( 'IS_VITE_DEVELOPMENT', true );

  $acf_options_page = array (
    array(
      'name' => 'OptionTribu',
      'icon_url' => 'dashicons-admin-generic'
    )
  );

  include "inc/inc.vite.php";

  $tribu = new TribuVite();

  // $tribu->declare_options_page($acf_options_page);


