<div class="hero hero-home">
    <?php if (has_post_thumbnail()): ?>
    <?php the_post_thumbnail('full', ['class' => 'hero-image']); ?>
    <div class="hero-overlay"></div>
    <?php endif; ?>
    
    <div class="hero-content">
        <div class="hero-logo-container">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <?php the_custom_logo(); ?>
            </a>
        </div>
        <nav class="site-nav-container">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'site-nav',
                'fallback_cb'    => false,
            ]);
            ?>
        </nav>
    </div>
</div>