<nav class="header__nav-wrapper">
    <div class="buttons-wrapper">
        <div class="search-bar">
            <img src="<?= get_template_directory_uri(); ?>/assets/svg/search-loupe.svg" alt="Rechecher" class="loupe">
            <?php get_template_part('./searchform') ?>
        </div>
        <?php wp_nav_menu(
            array(
                'theme_location' => 'secondary-menu',
                'menu_id' => 'secondary-menu',
                'menu_class' => 'header__nav list list--unstyled',
                'container' => false
            )
        ) ?>
    </div>
    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'main-menu',
            'menu_id' => 'main-menu',
            'menu_class' => 'header__nav list list--unstyled',
            'container' => false,
        )
    );
    ?>
</nav>
<div class="header-nav__overlay"></div>
