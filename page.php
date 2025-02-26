<?php
/*
 * Template Name: Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package blabaergris
 */

get_header(); ?>

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