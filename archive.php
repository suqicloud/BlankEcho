<?php
get_header(); // 加载头部文件
?>

<div class="becontainer">
    <div id="primary" class="becontent-area">
        <main id="main" class="besite-main">

            <?php if (have_posts()) : ?>

                <header class="page-header">
                    <?php
                    // 显示存档标题
                    if (is_category()) :
                        single_cat_title('<h1 class="page-title">分类: ', '</h1>');
                    elseif (is_tag()) :
                        single_tag_title('<h1 class="page-title">标签: ', '</h1>');
                    elseif (is_author()) :
                        the_post();
                        echo '<h1 class="page-title">作者: ' . esc_html(get_the_author()) . '</h1>';
                        rewind_posts();
                    elseif (is_year()) :
                        echo '<h1 class="page-title">日期: ' . esc_html(get_the_date('Y年')) . '</h1>';
                    elseif (is_month()) :
                        echo '<h1 class="page-title">日期: ' . esc_html(get_the_date('Y年F')) . '</h1>';
                    elseif (is_day()) :
                        echo '<h1 class="page-title">日期: ' . esc_html(get_the_date('Y年Fj日')) . '</h1>';
                    elseif (is_post_type_archive()) :
                        post_type_archive_title('<h1 class="page-title">', '</h1>');
                    elseif (is_tax()) :
                        $term = get_queried_object();
                        echo '<h1 class="page-title">存档: ' . esc_html($term->name) . '</h1>';
                    else :
                        echo '<h1 class="page-title">存档</h1>';
                    endif;
                    ?>
                </header><!-- 头部结束 -->

                <?php
                // 循环显示文章
                while (have_posts()) : the_post();
                    get_template_part('template-parts/content', get_post_format());
                endwhile;

                // 分页导航
                the_posts_pagination(array(
                    'prev_text' => __('上一页', 'betheme'),
                    'next_text' => __('下一页', 'betheme'),
                ));

            else :

                // 如果没有文章，显示content模板
                get_template_part('template-parts/content', 'none');

            endif;
            ?>

        </main>
    </div><!-- 框架 -->

    <?php get_sidebar(); // 加载侧边栏（没有就不加载） ?>
</div><!-- 整个页面 -->

<?php
get_footer(); // 加载底部文件
?>
