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
    <section class="color-theme">
      <button id="theme-handler" aria-label="Cliquez moi dessus pour choisir votre thème" title="Couleur système par défaut">
	      <span class="default"><?php get_template_part('./src/img/laptop-minimal') ?></span>
	      <span class="dark"><?php get_template_part('./src/img/moon') ?></span>
	      <span class="light"><?php get_template_part('./src/img/sun') ?></span>
      </button>
      <ul class="other-themes">
        <li data-theme="dark"><?php get_template_part('./src/img/moon') ?></li>
        <li data-theme="light"><?php get_template_part('./src/img/sun') ?></li>
        <li data-theme="default"><?php get_template_part('./src/img/laptop-minimal') ?></li>
      </ul>
    </section>
  </div>
</header>
