<?php

/**
 * Template for displaying a single Project post
 * @package HelloElementor Child
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

while (have_posts()) :
    the_post();
?>

    <main id="content" <?php post_class('site-main'); ?> style="max-width: 900px; margin: 0 auto; padding: 60px 20px;">

        <header class="page-header" style="text-align: center; margin-bottom: 40px;">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php
            $terms = get_the_term_list(get_the_ID(), 'project_type', '<p class="project-types">', ', ', '</p>');
            if ($terms) {
                echo $terms;
            }
            ?>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail" style="margin-bottom: 30px; text-align: center;">
                <?php the_post_thumbnail('large', ['style' => 'max-width:100%; border-radius: 10px;']); ?>
            </div>
        <?php endif; ?>

        <div class="page-content" style="font-size: 18px; line-height: 1.8;">
            <?php the_content(); ?>
        </div>

        <?php if (has_tag()) : ?>
            <div class="post-tags" style="margin-top: 40px;">
                <?php the_tags('<p><strong>' . esc_html__('Tags: ', 'hello-elementor') . '</strong>', ', ', '</p>'); ?>
            </div>
        <?php endif; ?>

        <?php comments_template(); ?>

    </main>

<?php
endwhile;
