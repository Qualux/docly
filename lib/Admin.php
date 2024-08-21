<?php

namespace Docly;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Admin {

    public function __construct() {

        add_action( 'after_setup_theme', function() {
            require_once( DOCLY_PATH . 'vendor/autoload.php' );
            \Carbon_Fields\Carbon_Fields::boot();
        });

        add_action( 'carbon_fields_register_fields', function() {
            Container::make( 'theme_options', __( 'Docly', 'crb' ) )
                ->add_fields( array(
                    Field::make( 'checkbox', 'docly_github_button', 'Render GitHub Button' )->set_default_value( true ),
                    Field::make( 'text', 'docly_github_url', 'GitHub URL' ),
                    Field::make( 'image', 'docly_logo', 'Logo Upload' ),
                    Field::make('color', 'docly_color_primary', __('Primary Color'))->set_default_value('#FFFFFF'),
                    Field::make('color', 'docly_color_accent', __('Accent Color'))->set_default_value('#0C8CE9'),
                    Field::make('color', 'docly_color_offset', __('Offset Color'))->set_default_value('#737373'),
                    Field::make('color', 'docly_color_text', __('Text Color'))->set_default_value('#242424'),
                ));
        }); 

        

    }

}