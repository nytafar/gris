<?php
if (!defined('ABSPATH')) exit;

// Debug
add_action('wp_head', function() {
    echo '<!-- Theme is loading -->';
});

// Debug logging function
function gris_debug_log($message, $data = null) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('[GRIS] ' . $message . ($data !== null ? ': ' . print_r($data, true) : ''));
    }
}

// Add debug hooks
add_action('template_redirect', function() {
    gris_debug_log('Template being loaded', [
        'is_front_page' => is_front_page(),
        'template' => get_page_template(),
        'queried_object' => get_queried_object()
    ]);
});

add_action('wp_head', function() {
    gris_debug_log('wp_head executing');
}, 1);

function blabaergris_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['navigation-widgets']);
    add_theme_support('custom-logo');
    
    register_nav_menus([
        'primary' => 'Primary Menu'
    ]);
    
    // Footer widget area
    register_sidebar([
        'name'          => 'Footer Area',
        'id'            => 'footer-1',
        'description'   => 'Add widgets here to appear in footer',
        'before_widget' => '<div class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('after_setup_theme', 'blabaergris_setup');

/**
 * Add theme support for custom logos and secondary logo
 */
function blabaergris_custom_logo_setup() {
    // Main logo (for front page)
    add_theme_support('custom-logo', array(
        'height'      => 1024,
        'width'       => 618,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    
    // Register secondary logo (for inner pages)
    register_setting('general', 'blabaergris_secondary_logo', array(
        'type'        => 'string',
        'description' => 'Secondary logo for inner pages',
    ));
}
add_action('after_setup_theme', 'blabaergris_custom_logo_setup');

/**
 * Add secondary logo field to customizer
 */
function blabaergris_customize_register($wp_customize) {
    // Add secondary logo section
    $wp_customize->add_section('blabaergris_secondary_logo_section', array(
        'title'       => __('Secondary Logo', 'blabaergris'),
        'description' => __('Upload a secondary logo for inner pages', 'blabaergris'),
        'priority'    => 30,
    ));
    
    // Add secondary logo setting
    $wp_customize->add_setting('blabaergris_secondary_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    // Add secondary logo control
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'blabaergris_secondary_logo', array(
        'label'    => __('Secondary Logo', 'blabaergris'),
        'section'  => 'blabaergris_secondary_logo_section',
        'settings' => 'blabaergris_secondary_logo',
    )));
}
add_action('customize_register', 'blabaergris_customize_register');

/**
 * Helper function to get the secondary logo
 */
function blabaergris_get_secondary_logo() {
    $logo_url = get_theme_mod('blabaergris_secondary_logo');
    if (!$logo_url) {
        return '';
    }
    
    $logo_id = attachment_url_to_postid($logo_url);
    if (!$logo_id) {
        return '<img src="' . esc_url($logo_url) . '" alt="' . get_bloginfo('name') . '" class="secondary-logo" />';
    }
    
    $logo_attr = array(
        'class' => 'secondary-logo',
        'alt'   => get_bloginfo('name'),
    );
    
    return wp_get_attachment_image($logo_id, 'full', false, $logo_attr);
}

function blabaergris_scripts() {
    gris_debug_log('Enqueuing scripts and styles');
    $version = time(); // Use current time as version to prevent caching
    wp_enqueue_style('blabaergris-style', get_stylesheet_uri(), [], $version);
    gris_debug_log('Style enqueued', [
        'stylesheet_uri' => get_stylesheet_uri(),
        'template_directory' => get_template_directory_uri(),
        'version' => $version
    ]);
}
add_action('wp_enqueue_scripts', 'blabaergris_scripts');

function allow_svg_uploads($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
