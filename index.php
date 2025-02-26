<?php get_header(); ?>

<?php 
// Load hero-home on front page, otherwise use default layout
if (is_front_page()) {
    get_template_part('template-parts/hero', 'home');
} else {
    get_template_part('template-parts/hero', 'page');
}
?>

<main class="site-main">
    <div class="container">
        <?php
        if (have_posts()):
            while (have_posts()): the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>