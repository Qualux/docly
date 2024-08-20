<?php if (!empty($posts_tree)) : ?>
    <div class="docly-nav">
            <ul class="docly-headings">
                <?php foreach ($posts_tree as $heading_post) : ?>
                    <li class="docly-heading">
                        <span class="docly-heading__title"><?php echo esc_html($heading_post->post_title); ?></span>
                        <?php if (!empty($heading_post->children)) : ?>
                            <ul class="docly-links">
                                <?php foreach ($heading_post->children as $child_post) : ?>
                                    <li class="docly-link" doc-post-id="<?php echo $child_post->ID; ?>">
                                        <a 
                                            href="<?php echo esc_url(get_permalink($child_post->ID)); ?>" 
                                            doc-post-id="<?php echo $child_post->ID; ?>"
                                            doc-post-parent-title="<?php echo $child_post->parent_title; ?>"
                                            class="docly-link__a"
                                        >
                                            <?php echo esc_html($child_post->post_title); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
    </div>
<?php endif; ?>
