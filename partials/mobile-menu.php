<nav class="handheld-header__nav-wrapper">
    <?php
        wp_nav_menu(
            array(
                'theme_location' => 'main-menu',
                'menu_id' => 'mobile-menu',
                'menu_class' => 'handheld-header__nav list list--unstyled',
                'container' => false
            )
        );
    ?>
</nav>
