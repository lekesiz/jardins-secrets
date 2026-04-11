<?php
/**
 * Jardins Secrets Child Theme Functions
 *
 * @package JardinsSecrets
 * @since 1.1.0
 */

defined('ABSPATH') || exit;

/**
 * Theme constants
 */
define('JS_THEME_VERSION', '1.1.0');

/**
 * Enqueue parent + child styles and scripts
 */
function jardins_secrets_enqueue_styles() {
    // Parent theme
    wp_enqueue_style(
        'spectra-one-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme('flavor')->get('Version')
    );

    // Google Fonts — loaded properly via wp_enqueue (not @import)
    wp_enqueue_style(
        'jardins-secrets-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Open+Sans:wght@300;400;600;700&display=swap',
        array(),
        null
    );

    // Child theme stylesheet
    wp_enqueue_style(
        'jardins-secrets-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('spectra-one-style', 'jardins-secrets-fonts'),
        JS_THEME_VERSION
    );

    // Custom JavaScript
    wp_enqueue_script(
        'jardins-secrets-js',
        get_stylesheet_directory_uri() . '/assets/js/jardins-secrets.js',
        array(),
        JS_THEME_VERSION,
        true
    );

    // Pass data to JS
    wp_localize_script('jardins-secrets-js', 'jsTheme', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'themeUrl' => get_stylesheet_directory_uri(),
    ));
}
add_action('wp_enqueue_scripts', 'jardins_secrets_enqueue_styles');

/**
 * Theme setup
 */
function jardins_secrets_theme_support() {
    // Gutenberg color palette
    add_theme_support('editor-color-palette', array(
        array('name' => 'Vert Nature',  'slug' => 'js-green',       'color' => '#2d5016'),
        array('name' => 'Vert Clair',   'slug' => 'js-green-light', 'color' => '#4a7c29'),
        array('name' => 'Terre',        'slug' => 'js-brown',       'color' => '#8B6914'),
        array('name' => 'Crème',        'slug' => 'js-cream',       'color' => '#F5F0E8'),
        array('name' => 'Blanc',        'slug' => 'js-white',       'color' => '#FFFFFF'),
    ));

    // Responsive embeds
    add_theme_support('responsive-embeds');

    // Wide alignment
    add_theme_support('align-wide');

    // Custom logo
    add_theme_support('custom-logo', array(
        'width'       => 200,
        'height'      => 80,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Title tag
    add_theme_support('title-tag');

    // HTML5 support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ));
}
add_action('after_setup_theme', 'jardins_secrets_theme_support');

/**
 * Tally Form Shortcode — [tally_form id="xxx" height="500"]
 */
function jardins_secrets_tally_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id'     => '',
        'height' => '500',
    ), $atts, 'tally_form');

    if (empty($atts['id'])) {
        return '';
    }

    return sprintf(
        '<div class="js-tally-wrapper"><iframe data-tally-src="https://tally.so/embed/%s?alignLeft=1&hideTitle=1&transparentBackground=1" loading="lazy" width="100%%" height="%s" frameborder="0" title="Formulaire de contact" allow="payment"></iframe></div>',
        esc_attr($atts['id']),
        esc_attr($atts['height'])
    );
}
add_shortcode('tally_form', 'jardins_secrets_tally_shortcode');

/**
 * Load Tally embed script only on pages that use the shortcode
 */
function jardins_secrets_tally_script() {
    global $post;
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'tally_form')) {
        wp_enqueue_script(
            'tally-embed',
            'https://tally.so/widgets/embed.js',
            array(),
            null,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'jardins_secrets_tally_script');

/**
 * Add skip link to header (accessibility)
 */
function jardins_secrets_skip_link() {
    echo '<a class="js-skip-link" href="#main-content">Aller au contenu principal</a>';
}
add_action('wp_body_open', 'jardins_secrets_skip_link');

/**
 * SEO: Add structured data (Schema.org LocalBusiness)
 */
function jardins_secrets_schema_markup() {
    if (is_front_page()) {
        $schema = array(
            '@context'    => 'https://schema.org',
            '@type'       => 'LocalBusiness',
            'name'        => 'Jardins Secrets',
            'description' => 'Paysagiste conseil en Moselle — Conception, aménagement et entretien d\'espaces verts pour particuliers et professionnels.',
            'url'         => home_url('/'),
            'telephone'   => '',
            'email'       => 'contact@jardins-secrets.fr',
            'address'     => array(
                '@type'           => 'PostalAddress',
                'streetAddress'   => '1 Rue des Jardins',
                'addressLocality' => 'Montbronn',
                'postalCode'      => '57415',
                'addressCountry'  => 'FR',
            ),
            'geo' => array(
                '@type'     => 'GeoCoordinates',
                'latitude'  => '49.0094',
                'longitude' => '7.3769',
            ),
            'areaServed' => array(
                '@type' => 'GeoCircle',
                'geoMidpoint' => array(
                    '@type'     => 'GeoCoordinates',
                    'latitude'  => '49.0094',
                    'longitude' => '7.3769',
                ),
                'geoRadius' => '50000',
            ),
            'priceRange'   => '€€',
            'openingHours' => 'Mo-Fr 08:00-18:00',
            'sameAs'       => array(),
            'image'        => '',
        );
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}
add_action('wp_head', 'jardins_secrets_schema_markup');

/**
 * SEO: Custom meta description for pages
 */
function jardins_secrets_meta_description() {
    $descriptions = array(
        'is_front_page' => 'Jardins Secrets, paysagiste conseil à Montbronn (Moselle). Conception, aménagement et entretien de jardins pour particuliers et professionnels. Devis gratuit.',
    );

    if (is_front_page()) {
        echo '<meta name="description" content="' . esc_attr($descriptions['is_front_page']) . '">' . "\n";
    }
}
add_action('wp_head', 'jardins_secrets_meta_description', 1);

/**
 * Security: Remove WordPress version from head
 */
remove_action('wp_head', 'wp_generator');

/**
 * Performance: Add resource hints for Google Fonts
 */
function jardins_secrets_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => true,
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => true,
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'jardins_secrets_resource_hints', 10, 2);

/**
 * Admin: Customize login page with brand colors
 */
function jardins_secrets_login_styles() {
    echo '<style>
        body.login { background-color: #F5F0E8; }
        .login h1 a { background-image: none !important; text-indent: 0 !important; font-family: "Playfair Display", Georgia, serif; font-size: 24px !important; color: #2d5016 !important; width: auto !important; height: auto !important; }
        .login h1 a::after { content: "Jardins Secrets"; }
        .login #loginform { border-radius: 12px; border-top: 4px solid #2d5016; }
        .login .button-primary { background: #2d5016 !important; border-color: #2d5016 !important; }
        .login .button-primary:hover { background: #4a7c29 !important; border-color: #4a7c29 !important; }
    </style>';
}
add_action('login_head', 'jardins_secrets_login_styles');

/**
 * Performance: Disable emojis script (not needed)
 */
function jardins_secrets_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'jardins_secrets_disable_emojis');
