<?php

namespace Docly;

class DocNav {

    protected $posts_tree = [];
    protected $doc_post_model;

    public function __construct() {
        // Instantiate the DocPostModel
        $this->doc_post_model = new DocPostModel();
        
        // Fetch and organize posts into a tree structure
        $this->prepare_posts_tree();
    }

    /**
     * Fetch posts and organize them into a tree structure.
     */
    protected function prepare_posts_tree() {
        $posts = $this->doc_post_model->fetch_all();

        $post_titles = []; // Array to store post titles
        $parent_posts = []; // Array to store parent posts
        $child_posts = []; // Array to store child posts

        if (!empty($posts)) {
            // Populate the post_titles array
            foreach ($posts as $post) {
                $post_titles[$post->ID] = $post->post_title;
            }

            // Separate parent and child posts
            foreach ($posts as $post) {
                if ($post->post_parent == 0) {
                    // Top-level post
                    $parent_posts[$post->ID] = $post;
                    $parent_posts[$post->ID]->children = [];
                } else {
                    // Child post
                    $child_posts[] = $post;
                }
            }

            // Add parent posts to the tree
            foreach ($parent_posts as $parent_post) {
                $this->posts_tree[$parent_post->ID] = $parent_post;
            }

            // Add child posts to their respective parents
            foreach ($child_posts as $child_post) {
                if (isset($this->posts_tree[$child_post->post_parent])) {
                    $child = $child_post;
                    // Add the parent title to the child post
                    $child->parent_title = $post_titles[$child_post->post_parent];
                    $this->posts_tree[$child_post->post_parent]->children[] = $child;
                }
            }
        }
    }


    /**
     * Render the navigation.
     */
    public function render() {
        // Pass the tree to the template and render it
        $posts_tree = $this->posts_tree; // Pass the tree to the template

        /*
        echo '<pre>';
        var_dump( $posts_tree );
        echo '<pre>';
        */

        include DOCLY_PATH . 'templates/nav.php';
    }
}
