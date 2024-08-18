<?php 

/*
 * Plugin Name: Docly
 */

namespace Docly;

// Define constants
define('DOCLY_URL', plugin_dir_url(__FILE__));
define('DOCLY_PATH', plugin_dir_path(__FILE__));
define('DOCLY_VERSION', '1.0.0');

class Plugin {

    public function __construct() {

        // Require the lib classes.
        require_once DOCLY_PATH . 'lib/DocPostType.php';
        require_once DOCLY_PATH . 'lib/DocPostModel.php';
        require_once DOCLY_PATH . 'lib/DocNav.php';

        // Instantiate the DocPostType class
        new \App\PostTypes\DocPostType();

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
                DOCLY_URL . '/js/ContentMenuGenerator.js', 
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
    
}

// Instantiate the Plugin class
new Plugin();
