<aside id="secondary" class="widget-area">
    <?php if (is_active_sidebar('primary-sidebar')) : ?>
        <?php dynamic_sidebar('primary-sidebar'); ?>
    <?php else : ?>
        <!-- 侧边栏没有小工具时的默认内容 -->

        <section class="widget">
            <h2 class="widget-title"><?php _e('最新文章', 'betheme'); ?></h2>
            <ul>
                <?php
                $recent_posts = new WP_Query(array(
                    'posts_per_page' => 5,
                    'post_status'    => 'publish',
                ));

                if ($recent_posts->have_posts()) :
                    while ($recent_posts->have_posts()) : $recent_posts->the_post();
                        ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <li><?php _e('没有新文章.', 'betheme'); ?></li>
                    <?php
                endif;
                ?>
            </ul>
        </section>

        <section class="widget">
            <h2 class="widget-title"><?php _e('分类', 'betheme'); ?></h2>
            <ul>
                <?php
                wp_list_categories(array(
                    'orderby' => 'name',
                    'show_count' => true,
                    'title_li' => '',
                ));
                ?>
            </ul>
        </section>

        <section class="widget">
            <h2 class="widget-title"><?php _e('归档', 'betheme'); ?></h2>
            <ul>
                <?php
                wp_get_archives(array(
                    'type' => 'monthly',
                    'show_post_count' => true,
                ));
                ?>
            </ul>
        </section>
    <?php endif; ?>
</aside>
