<?php
/**
 * Jardins Secrets Child Theme Functions
 */

// Enqueue parent + child styles
function jardins_secrets_enqueue_styles() {
    wp_enqueue_style('spectra-one-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('jardins-secrets-style', get_stylesheet_directory_uri() . '/style.css', array('spectra-one-style'), '1.0.0');
    wp_enqueue_script('jardins-secrets-js', get_stylesheet_directory_uri() . '/assets/js/jardins-secrets.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'jardins_secrets_enqueue_styles');

// Gutenberg color palette
function jardins_secrets_theme_support() {
    add_theme_support('editor-color-palette', array(
        array('name' => 'Vert Nature', 'slug' => 'js-green', 'color' => '#2d5016'),
        array('name' => 'Vert Clair', 'slug' => 'js-green-light', 'color' => '#4a7c29'),
        array('name' => 'Terre', 'slug' => 'js-brown', 'color' => '#8B6914'),
        array('name' => 'Crème', 'slug' => 'js-cream', 'color' => '#F5F0E8'),
        array('name' => 'Blanc', 'slug' => 'js-white', 'color' => '#FFFFFF'),
    ));
}
add_action('after_setup_theme', 'jardins_secrets_theme_support');

// Tally Form Shortcode
function jardins_secrets_tally_shortcode($atts) {
    $atts = shortcode_atts(array('id' => '', 'height' => '500'), $atts);
    if (empty($atts['id'])) return '';
    return '<iframe data-tally-src="https://tally.so/embed/' . esc_attr($atts['id']) . '?alignLeft=1&hideTitle=1&transparentBackground=1" loading="lazy" width="100%" height="' . esc_attr($atts['height']) . '" frameborder="0" title="Formulaire de contact"></iframe>';
}
add_shortcode('tally_form', 'jardins_secrets_tally_shortcode');
