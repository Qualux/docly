<?php 

/*
 * Plugin Name: Docly
 * Author: Qualux LLC.
 * Author URI: https://qualux.io
 * Version: 0.0.1
 * Description: Simple and modern documentation plugin.
 */

namespace Docly;

define('DOCLY_URL', plugin_dir_url(__FILE__));
define('DOCLY_PATH', plugin_dir_path(__FILE__));
define('DOCLY_VERSION', '1.0.0');

class Plugin {

    public function __construct() {

        // Require the lib classes.
        require_once DOCLY_PATH . 'lib/DocPostType.php';
        require_once DOCLY_PATH . 'lib/DocPostModel.php';
        require_once DOCLY_PATH . 'lib/DocNav.php';
        require_once DOCLY_PATH . 'lib/Admin.php';
        require_once DOCLY_PATH . 'lib/Template.php';

        // Instantiate the admin class.
        new \Docly\Admin();

        // Instantiate the doc post type.
        new \Docly\DocPostType();

        // Enqueue DocController JS.
        add_action('wp_enqueue_scripts', function() {

            wp_enqueue_script(
                'docly-doc-controller', 
                DOCLY_URL . '/js/DocController.js', 
                [], 
                DOCLY_VERSION, 
                true // Load in footer
            );

            wp_enqueue_script(
                'docly-doc-content-menu-generator', 
                DOCLY_URL . '/js/TableContentsGenerator.js', 
                [], 
                DOCLY_VERSION, 
                true // Load in footer
            );

            wp_enqueue_script(
                'docly-search', 
                DOCLY_URL . '/js/DoclySearch.js', 
                [], 
                DOCLY_VERSION, 
                true // Load in footer
            );

            wp_enqueue_style(
                'docly-main', 
                DOCLY_URL . '/css/main.css', 
                [], 
                DOCLY_VERSION, 
                'all'
            );

        });

        // Register the page template
        add_filter('theme_page_templates', [$this, 'register_page_template']);

        // Load the correct template
        add_filter('template_include', [$this, 'template']);

        // Render the styles from settings.
        $this->styles();

    }

    public function register_page_template($templates) {

        $templates['doc_page'] = __('Documentation Page', 'docly');
        return $templates;
        
    }
    
    public function template( $template ) {

        $template_slug = get_page_template_slug();

        if ( $template_slug === 'doc_page' ) {

            $override_template = locate_template('docly/page.php');

            if ($override_template) {
                return $override_template;
            }

            return DOCLY_PATH . 'templates/page.php';

        }

        return $template;

    }

    public function styles() {

        add_action('wp_head', function() {

             $color_accent = carbon_get_theme_option( 'docly_color_accent' );
             if( ! $color_accent ) {
                $color_accent = '#0C8CE9';
             } else {
                $color_accent = '#'.$color_accent;
             }

            echo "
                <style>
                    .page-template-doc_page {
                        --docly-color-accent: {$color_accent};
                    }
                </style>
            ";

        });

    }
    
}

// Instantiate the Plugin class
new Plugin();
