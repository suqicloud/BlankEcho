<?php
/*
Template Name: 心情动态页面
*/
get_header(); // 加载头部文件
?>

<div class="becontainer social-container">
    <div id="primary" class="becontent-area">
        <main id="main" class="social-site-main">
            <?php
            $args = array(
                'post_type'      => 'social_posts',
                'posts_per_page' => 10, // 每页显示的动态数量
                'paged'          => get_query_var('paged') ? get_query_var('paged') : 1
            );

            $social_query = new WP_Query($args);

            if ($social_query->have_posts()) :
                while ($social_query->have_posts()) : $social_query->the_post();
                    // 计算图片数量
                    $content = get_the_content();
                    $image_count = substr_count($content, '<img');

                    // 设置 CSS 类
                    $image_class = '';
                    if ($image_count == 1) {
                        $image_class = 'one-image';
                    } elseif ($image_count == 2) {
                        $image_class = 'two-images';
                    } elseif ($image_count >= 3) {
                        $image_class = 'three-or-more-images';
                    }
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('social-post ' . $image_class); ?>>
                        <div class="social-content">
                            <?php the_content(); // 显示动态内容 ?>
                        </div>
                        <div class="social-meta">
                            <span class="social-time"><?php echo get_the_date(); // 显示发布时间 ?></span>
                        </div>
                    </article>
                    <?php
                endwhile;

                // 默认分页导航
                echo '<div class="socialpagination">';
                echo paginate_links(array(
                    'total'     => $social_query->max_num_pages,
                    'prev_text' => __('上一页', 'betheme'),
                    'next_text' => __('下一页', 'betheme'),
                ));
                echo '</div>';

            else :
                ?>
                <p><?php _e('暂无动态', 'betheme'); ?></p>
                <?php
            endif;

            wp_reset_postdata();
            ?>
        </main>
    </div><!-- #primary 结束 -->

    <?php get_sidebar(); // 加载侧边栏小工具 ?>

</div><!-- social-container 结束 -->

<?php
get_footer(); // 加载底部文件
?>
