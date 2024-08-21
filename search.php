<?php get_header(); ?>

<div class="custom-search-container">
    <div class="custom-search-content">
        <div class="custom-search-background">
            <?php if (have_posts()) : ?>
                <h1 class="custom-search-title">
                    <?php printf(__('搜索结果: %s', 'betheme'), '<span>' . esc_html(get_search_query()) . '</span>'); ?>
                </h1>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="custom-search-result">
                        <h2 class="custom-search-result-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="custom-search-result-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <h2 class="custom-search-no-results"><?php _e('没有搜索结果.', 'betheme'); ?></h2>
            <?php endif; ?>
        </div>
    </div>

    <div class="custom-search-sidebar">
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
