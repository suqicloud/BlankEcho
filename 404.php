<?php
get_header(); // 加载头部文件
?>

<div class="container becustom-404-container">
    <div id="primary" class="becontent-area">
        <section class="error-404 not-found custom-404-content">
            <header class="page-header becustom-404-header">
                <h1 class="page-title">哎呀！我找不到该页面。</h1>
            </header><!-- 头部文件 -->

            <div class="page-content becustom-404-page-content">
                <p>看来在这个地方什么也没找到。</p>

                <!-- 显示最近的文章 -->
                <h2>最新文章</h2>
                <ul class="becustom-404-recent-posts">
                    <?php
                    $recent_posts = new WP_Query(array(
                        'posts_per_page' => 5,
                        'post_status'    => 'publish',
                    ));

                    if ($recent_posts->have_posts()) :
                        while ($recent_posts->have_posts()) : $recent_posts->the_post();
                            ?>
                            <li><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></li>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        ?>
                        <li>没有文章.</li>
                        <?php
                    endif;
                    ?>
                </ul>
            </div>
        </section><!-- 404板块 -->
    </div>
</div><!-- 整个页面 -->


<?php
get_footer(); // 加载底部文件
?>
