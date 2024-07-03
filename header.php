<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header>
  <div class="container">
    <section class="main">
      <h1>VitePress</h1>
      <p>Bienvenue sur votre thème</p>
    </section>
    <section class="menu-container">
      <div class="site-header__menu-toggler menu-toggler">
      <span class="menu-toggler__line"></span>
      <span class="menu-toggler__line"></span>
      <span class="menu-toggler__line"></span>
      <?php get_template_part('partials/main-menu'); ?>
    </section>

   <?php get_template_part('partials/theme_selector') ?>
  </div>
</header>
