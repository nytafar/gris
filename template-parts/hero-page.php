<div class="hero hero-page">
    <?php if (has_post_thumbnail()): ?>
    <?php the_post_thumbnail('full', ['class' => 'hero-image']); ?>
    <div class="hero-overlay"></div>
    <?php endif; ?>
    
    <div class="hero-header">
        <div class="secondary-logo-container">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <?php echo blabaergris_get_secondary_logo(); ?>
            </a>
        </div>
        <nav class="site-nav-container">
            <button class="menu-toggle" aria-label="Toggle menu" onclick="this.classList.toggle('open');document.querySelector('.site-nav').classList.toggle('open')">
                <span class="hamburger"></span>
            </button>
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
    
    <div class="hero-title">
        <h1><?php the_title(); ?></h1>
    </div>
</div>