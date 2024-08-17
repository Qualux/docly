<?php 

namespace App\PostTypes;

class DocPostType
{
    public function __construct()
    {
        add_action('init', [$this, 'registerDocPostType']);
    }

    public function registerDocPostType()
    {
        $labels = [
            'name'               => _x('Docs', 'post type general name', 'docly'),
            'singular_name'      => _x('Doc', 'post type singular name', 'docly'),
            'menu_name'          => _x('Docs', 'admin menu', 'docly'),
            'name_admin_bar'     => _x('Doc', 'add new on admin bar', 'docly'),
            'add_new'            => _x('Add New', 'doc', 'docly'),
            'add_new_item'       => __('Add New Doc', 'docly'),
            'new_item'           => __('New Doc', 'docly'),
            'edit_item'          => __('Edit Doc', 'docly'),
            'view_item'          => __('View Doc', 'docly'),
            'all_items'          => __('All Docs', 'docly'),
            'search_items'       => __('Search Docs', 'docly'),
            'parent_item_colon'  => __('Parent Docs:', 'docly'),
            'not_found'          => __('No docs found.', 'docly'),
            'not_found_in_trash' => __('No docs found in Trash.', 'docly'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'hierarchical'       => true,
            'supports'           => ['title', 'editor', 'post-formats', 'revisions', 'page-attributes'],
            'has_archive'        => false,
            'show_in_rest'       => true,
        ];

        register_post_type('doc', $args);
    }
}
