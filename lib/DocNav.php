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

        if (!empty($posts)) {
            // Populate the post_titles array
            foreach ($posts as $post) {
                $post_titles[$post->ID] = $post->post_title;
            }

            // Organize posts into a tree structure
            foreach ($posts as $post) {
                if ($post->post_parent == 0) {
                    // Top-level post
                    $this->posts_tree[$post->ID] = $post;
                    $this->posts_tree[$post->ID]->children = [];
                } else {
                    // Child post
                    if (isset($this->posts_tree[$post->post_parent])) {
                        $child = $post;
                        // Add the parent title to the child post
                        $child->parent_title = $post_titles[$post->post_parent];
                        $this->posts_tree[$post->post_parent]->children[] = $child;
                    }
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
        include DOCLY_PATH . 'templates/nav.php';
    }
}
