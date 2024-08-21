<?php
get_header(); // 加载头部文件

// 获取当前分类对象
$category = get_queried_object();
?>

<div class="becontainer">
    <div id="primary" class="becontent-area">
        <main id="main" class="besite-main">

            <header class="page-header">
                <?php
                // 显示分类名称
                the_archive_title('<h1 class="page-title">', '</h1>');
                ?>
            </header>

            <?php if (have_posts()) : ?>

                <?php
                // 开始文章循环
                while (have_posts()) :
                    the_post();

                    // 使用模板内容结构显示文章摘要
                    get_template_part('template-parts/content', get_post_format());

                endwhile;

                // 分页导航
                the_posts_pagination(array(
                    'prev_text' => __('上一页', 'betheme'),
                    'next_text' => __('下一页', 'betheme'),
                ));

            else :

                // 如果没有文章，显示提示消息
                echo '<p>当前分类下还没有文章。</p>';
                get_template_part('template-parts/content', 'none');

            endif;
            ?>

        </main>
    </div><!-- 框架结束 -->

    <?php get_sidebar(); // 加载侧边栏（没有就不显示） ?>
</div><!-- 整个页面结束 -->

<?php
get_footer(); // 加载底部文件
?>
