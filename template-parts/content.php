<article id="post-<?php the_ID(); ?>" <?php post_class('article-card'); ?>>
    <figure class="post-thumbnail">
        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('medium'); // 使用中等尺寸的特色图片
        }
        ?>
    </figure>

    <div class="article-content">
        <header class="entry-header">
            <?php
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            ?>
            <div class="entry-meta">
                <?php
                if ('post' === get_post_type()) :
                    echo '<span class="posted-on">&#128198; ' . get_the_date() . '</span>';
                endif;
                ?>
            </div>
        </header>

        <div class="entry-summary">
            <?php 
            // 设置摘要的长度为30个字符
            $excerpt = wp_trim_words(get_the_excerpt(), 30, '...');
            echo '<p>' . $excerpt . '</p>';
            ?>
        </div>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
