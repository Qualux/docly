<?php

namespace Docly;

use WP_Query;

class DocPostModel {

    public $postCount;
    public $hasPosts;
    public $posts;

    public function __construct() {
        // Initialize properties
        $this->postCount = 0;
        $this->hasPosts = false;
        $this->posts = [];
    }

    /**
     * Fetch all posts of type 'doc' ordered by 'menu_order'
     *
     * @return array|WP_Post[]
     */
    public function fetch_all() {
        $query = new WP_Query([
            'post_type'      => 'doc',
            'posts_per_page' => -1,  // Fetch all posts
            'post_status'    => 'publish',  // Only published posts
            'orderby'        => 'menu_order',  // Order by 'menu_order'
            'order'          => 'ASC',  // Ascending order
        ]);

        $this->postCount = $query->found_posts; // Set post count
        $this->hasPosts = $query->have_posts(); // Set hasPosts flag
        $this->posts = $query->posts; // Store posts

        return $this->posts;
    }
}
