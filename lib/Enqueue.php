<?php 

namespace Docly;

class Enqueue {


    public function __construct() {

        /* 
         * Script registration 
         * 
         * Runs register on priority 5 so that developers can deregister prior to enqueue.
         * 
         */
        add_action('wp_enqueue_scripts', function() {

            $doc_page_id = $this->get_doc_page_option();

            if ( $doc_page_id && is_page( $doc_page_id ) ) {

                $this->register_scripts();

                wp_enqueue_style(
                    'docly-main', 
                    DOCLY_URL . '/css/main.css', 
                    [], 
                    DOCLY_VERSION, 
                    'all'
                );

            }

        });

        /* 
         * Script enqueue
         * 
         * Runs enqueue on priority 20 so that developers can deregister prior to enqueue with a priority of 6-19.
         * 
         */
        add_action('wp_enqueue_scripts', function() {

            $doc_page_id = $this->get_doc_page_option();

            if ( $doc_page_id && is_page( $doc_page_id ) ) {

                $this->enqueue_scripts();

                wp_enqueue_style(
                    'docly-main', 
                    DOCLY_URL . '/css/main.css', 
                    [], 
                    DOCLY_VERSION, 
                    'all'
                );

            }

        });

    }

    public function register_scripts() {

        wp_register_script(
            'docly-controller', 
            DOCLY_URL . '/js/DocController.js', 
            [], 
            DOCLY_VERSION, 
            true
        );
    
        wp_register_script(
            'docly-toc-generator', 
            DOCLY_URL . '/js/TableContentsGenerator.js', 
            [], 
            DOCLY_VERSION, 
            true
        );
    
        wp_register_script(
            'docly-search', 
            DOCLY_URL . '/js/DoclySearch.js', 
            [], 
            DOCLY_VERSION, 
            true
        );

    }

    public function enqueue_scripts() {

        wp_enqueue_script('docly-controller');
        wp_enqueue_script('docly-toc-generator');
        wp_enqueue_script('docly-search');

    }
    

    public static function get_doc_page_option() {

        $page_id = carbon_get_theme_option('docly_doc_page_id');
        return $page_id !== false ? $page_id : false;
        
    }


}