<?php
get_header(); // 加载头部文件
?>

<div class="becontainer">
    <div id="primary" class="becontent-area">
        <!-- besite-main 是首页文章卡片列表下面的容器, 要启用就删掉注释 -->
        <!-- <main id="main" class="besite-main"> -->

        <?php if (have_posts()) : ?>

            <?php
            // 如果是首页，显示页面标题
            if (is_home() && !is_front_page()) : ?>
                <header>
                    <h1 class="page-title"><?php echo esc_html(single_post_title('', false)); ?></h1>
                </header>
            <?php endif; ?>

            <?php
            // 循环显示文章
            while (have_posts()) : the_post();

                // 使用模板部分文件显示内容
                get_template_part('template-parts/content', get_post_format());

            endwhile;

            // 分页导航
            the_posts_pagination(array(
                'prev_text' => __('上一页', 'betheme'),
                'next_text' => __('下一页', 'betheme'),
            ));

        else :

            // 如果没有文章，加载 content 模板
            get_template_part('template-parts/content', 'none');

        endif;
        ?>

        <!-- </main> -->
        <!-- besite-main 是首页文章卡片列表下面的容器 -->
    </div>

    <?php get_sidebar(); // 加载侧边栏（没有就不加载） ?>
</div>

<?php
get_footer(); // 加载底部文件
?>
