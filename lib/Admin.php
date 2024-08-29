<?php 

namespace Docly;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Admin {

    public function __construct() {
        add_action('after_setup_theme', function() {
            require_once(DOCLY_PATH . 'vendor/autoload.php');
            \Carbon_Fields\Carbon_Fields::boot();
        });

        // Add custom admin page
        add_action('admin_menu', function() {
            add_menu_page(
                __('Docly Admin', 'docly'), // Page title
                __('Docly', 'docly'),       // Menu title
                'manage_options',          // Capability
                'docly',                   // Menu slug
                [$this, 'renderAdminPage'], // Callback function
                'dashicons-admin-generic', // Icon URL
                20                        // Position
            );
        });

        // Add Carbon Fields to custom admin page
        add_action('carbon_fields_register_fields', function() {
            Container::make('theme_options', __('Settings', 'crb'))
                ->add_fields(array(
                    Field::make('select', 'docly_doc_page_id', __('Documentation Page'))
                        ->add_options(array_combine(
                            wp_list_pluck(get_pages(), 'ID'),
                            wp_list_pluck(get_pages(), 'post_title')
                        )),
                    Field::make('image', 'docly_logo', 'Logo Upload'),
                    Field::make('color', 'docly_color_primary', __('Primary Color'))->set_default_value('#FFFFFF'),
                    Field::make('color', 'docly_color_accent', __('Accent Color'))->set_default_value('#0C8CE9'),
                    Field::make('color', 'docly_color_offset', __('Offset Color'))->set_default_value('#353535'),
                    Field::make('color', 'docly_color_text', __('Text Color'))->set_default_value('#242424'),
                    Field::make('checkbox', 'docly_github_button', 'Render GitHub Button')->set_default_value(true),
                    Field::make('text', 'docly_github_url', 'GitHub URL'),
                ))
                ->set_page_parent('docly'); // This associates the Carbon Fields container with the custom admin page slug
        });
    }

    public function renderAdminPage() {
        echo '<div class="wrap"><h1>' . __('Docly Admin Page', 'docly') . '</h1></div>';
    }
}
