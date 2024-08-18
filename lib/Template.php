<?php

namespace Docly;

class Template {

    public function render_header() {

        // Retrieve the option to determine which header to use
        $use_docly_header = get_option('docly_header', true); // Default to true if not set

        if ($use_docly_header) {
            // Check if the theme provides a custom header override in /docly/header.php
            $custom_header = locate_template('docly/header.php');

            if ($custom_header) {
                // Use the custom header from the theme if available
                include $custom_header;
            } else {
                // Fall back to the header provided by the plugin
                include DOCLY_PATH . 'templates/header.php';
            }
        } else {
            // Use the default site header
            get_header('docs');
        }
    }

    public function render_footer() {

        // Retrieve the option to determine which header to use
        $use_docly_footer = get_option('docly_footer', true); // Default to true if not set

        if ($use_docly_footer) {
            // Check if the theme provides a custom footer override in /docly/header.php
            $custom_footer = locate_template('docly/footer.php');

            if ($custom_footer) {
                // Use the custom footer from the theme if available
                include $custom_footer;
            } else {
                // Fall back to the footer provided by the plugin
                include DOCLY_PATH . 'templates/footer.php';
            }
        } else {
            // Use the default site footer
            get_footer('docs');
        }
    }

}
