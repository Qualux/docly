<?php 

/*
 * Plugin Name: Docly
 * Author: Qualux LLC.
 * Author URI: https://qualux.io
 * Version: 0.0.5
 * Description: Simple and modern documentation plugin.
 */

namespace Docly;

define('DOCLY_URL', plugin_dir_url(__FILE__));
define('DOCLY_PATH', plugin_dir_path(__FILE__));
define('DOCLY_VERSION', '0.0.5');

class Plugin {

    public function __construct() {

        // Require the lib classes.
        require_once DOCLY_PATH . 'lib/DocPostType.php';
        require_once DOCLY_PATH . 'lib/DocPostModel.php';
        require_once DOCLY_PATH . 'lib/DocNav.php';
        require_once DOCLY_PATH . 'lib/Admin.php';
        require_once DOCLY_PATH . 'lib/Template.php';
        require_once DOCLY_PATH . 'lib/Enqueue.php';

        // Instantiate the admin class.
        new \Docly\Admin();

        // Instantiate the doc post type.
        new \Docly\DocPostType();

        // Enqueue Init.
        new \Docly\Enqueue();
        

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

        $doc_page_id = $this->get_doc_page_option();

        if ( $doc_page_id && is_page( $doc_page_id ) ) {

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

            $color_primary = carbon_get_theme_option( 'docly_color_primary' );
            if( ! $color_primary ) {
                $color_primary = '#FFFFFF';
            }

            $color_accent = carbon_get_theme_option( 'docly_color_accent' );
            if( ! $color_accent ) {
            $color_accent = '#0C8CE9';
            }

            $color_offset = carbon_get_theme_option( 'docly_color_offset' );
            if( ! $color_offset ) {
            $color_offset = '#353535';
            }

            $color_text = carbon_get_theme_option( 'docly_color_text' );
            if( ! $color_text ) {
            $color_text = '#242424';
            }

             // Make modal background color with transparency. 
             $color_modal_bg = $color_offset . 'CC';
             
            echo "
                <style>
                    :root {
                        --docly-color-primary: {$color_primary};
                        --docly-color-accent: {$color_accent};
                        --docly-color-offset: {$color_offset};
                        --docly-color-text: {$color_text};
                        --docly-color-modal-bg: {$color_modal_bg};
                    }
                </style>
            ";

        });

    }

    public static function activate() {
        
        if (!self::get_doc_page_option()) {
            $page_id = wp_insert_post([
                'post_title'   => 'Docs',
                'post_name'    => 'docs',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ]);

            // Set the new page ID in the option
            if ($page_id && !is_wp_error($page_id)) {
                self::set_doc_page_option($page_id);
            }
        }

        flush_rewrite_rules();

    }

    public static function get_doc_page_option() {
        $page_id = carbon_get_theme_option('docly_doc_page_id');
        return $page_id !== false ? $page_id : false;
    }

    public static function set_doc_page_option($page_id) {
        carbon_set_theme_option('docly_doc_page_id', $page_id);
    }
    
}

// Instantiate the Plugin class
new Plugin();

// Register activation hook.
register_activation_hook(__FILE__, ['\Docly\Plugin', 'activate']);
