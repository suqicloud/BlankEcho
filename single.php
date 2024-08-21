<?php
get_header(); // 加载头部文件
?>

<div class="becontainer">
    <div id="primary" class="becontent-area">
        <main id="main" class="besite-main">
            <?php
            while (have_posts()) : the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        <div class="entry-meta">
                            <?php
                            echo '<span class="posted-on">&#128198; ' . get_the_date() . '</span>';

                            // 显示文字总数不包括符号
                            $character_count = get_filtered_character_count(get_the_ID());
                            echo '<span class="character-count">&#128214; 字数: ' . $character_count . '</span>';

                            ?>
                        </div>
                    </header>

                    <div class="entry-content post-content">
                        <?php the_content(); ?>
                    </div>

                    <footer class="entry-footer">
                        <?php
                        // 显示分类和标签
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            echo '<span class="cat-links">分类: ';
                            foreach ($categories as $category) {
                                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a> ';
                            }
                            echo '</span>';
                        }

                        $tags = get_the_tags();
                        if ($tags) {
                            echo '<span class="tags-links">标签: ';
                            foreach ($tags as $tag) {
                                echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</a> ';
                            }
                            echo '</span>';
                        }
                        ?>
                    </footer>

                </article><!-- #post-<?php the_ID(); ?> -->

            <?php endwhile; ?>

            
        </main>
    </div><!-- 板块结束 -->

    <?php get_sidebar(); // 加载侧边栏 ?>
</div><!-- 页面结束 -->

<?php
get_footer(); // 加载底部文件
?>
