<?php

/**
 * Archive Template for Projects Post Type
 * @package HelloElementor Child
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<style>
    .pagination {
        display: flex;
        justify-content: center;
        gap: 20px;
        padding-top: 20px;
    }

    .pagination .page-numbers {
        background: #eee;
        padding: 10px 15px;
        text-decoration: none;
        color: #333;
    }

    .pagination .current {
        background: #333;
        color: #fff;
    }
</style>
<main id="content" class="site-main" style="padding: 60px 20px; max-width: 1200px; margin: 0 auto;">

    <header class="page-header" style="text-align: center; margin-bottom: 40px;">
        <h1 class="entry-title"><?php post_type_archive_title(); ?></h1>
        <p class="archive-description"><?php echo category_description(); ?></p>
    </header>

    <div class="projects-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large', ['style' => 'width:100%; border-radius:8px;']); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <h2 class="entry-title" style="font-size: 24px; margin: 20px 0 10px;">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <div class="entry-excerpt" style="font-size: 16px;">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile;
        else: ?>
            <p><?php esc_html_e('No projects found.', 'hello-elementor'); ?></p>
        <?php endif; ?>
    </div>

    <div class="pagination" style="text-align: center; margin-top: 40px;">
        <?php
        the_posts_pagination([
            'prev_text' => __('« Previous'),
            'next_text' => __('Next »'),
        ]);
        ?>
    </div>
    </div>


</main>