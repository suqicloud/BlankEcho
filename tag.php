<?php
get_header(); // 加载头部文件
?>

<div class="becontainer">
    <div id="primary" class="becontent-area">
        <main id="main" class="besite-main">

            <?php if (have_posts()) : ?>

                <header class="page-header">
                    <h1 class="page-title"><?php single_tag_title(); ?></h1>
                    <?php
                    // 显示标签描述（没有就不显示）
                    $tag_description = tag_description();
                    if ($tag_description) :
                        echo '<div class="taxonomy-description">' . esc_html($tag_description) . '</div>';
                    endif;
                    ?>
                </header>

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
    </div>

    <?php get_sidebar(); // 加载侧边栏（没有就不显示） ?>
</div><!-- 页面结束 -->

<?php
get_footer(); // 加载底部文件
?>
