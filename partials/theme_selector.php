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
