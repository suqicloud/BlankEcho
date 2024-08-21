</div><!--底部文件 -->

<footer class="site-footer">
    <div class="footer-widgets">
        <?php if (is_active_sidebar('footer-1')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-1'); ?>
            </div>
        <?php endif; ?>
        <?php if (is_active_sidebar('footer-2')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-2'); ?>
            </div>
        <?php endif; ?>
    </div><!-- 底部小工具 -->

    <div class="site-info">
        <?php
        // 获取备案号和网安备案号
        $beian_number = get_option('beian_number');
        $wang_an_beian_number = get_option('wang_an_beian_number');

        if ($beian_number || $wang_an_beian_number) {
            echo '<div class="beian-info">';

            // 网安备案号
            if ($wang_an_beian_number) {
            // 只提取数字部分
                $filtered_number = preg_replace('/\D/', '', $wang_an_beian_number);

                // 生成链接
                $wang_an_url = 'http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=' . esc_attr($filtered_number);

                echo '<p class="wang-an-beian">';
                echo '<img src="' . get_template_directory_uri() . '/img/wang.png" alt="网安备案号图标" class="beian-icon" />';
                echo '<a href="' . esc_url($wang_an_url) . '" target="_blank" rel="external nofollow noopener noreferrer">' . esc_html($wang_an_beian_number) . '</a>';
                echo '</p>';
            }


            // 备案号
            if ($beian_number) {
                echo '<p class="beian">';
                echo '<a href="https://beian.miit.gov.cn/" target="_blank" rel="external nofollow noopener noreferrer">备案号：' . esc_html($beian_number) . '</a>';
                echo '</p>';
            }

            echo '</div>';
        }
        ?>

        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('版权所有.', 'betheme'); ?></p>
        <?php

        // 显示自定义版权信息
        $custom_footer_text = get_option('custom_footer_text');
        if ($custom_footer_text) {
            echo '<p>' . wp_kses_post($custom_footer_text) . '</p>';
        }
        ?>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var menuButton = document.getElementById('mobile-menu-button');
    var nav = document.getElementById('site-navigation');

    menuButton.addEventListener('click', function(event) {
        event.stopPropagation();
        nav.classList.toggle('active');
    });

    document.addEventListener('click', function(event) {
        var isClickInside = nav.contains(event.target) || menuButton.contains(event.target);

        if (!isClickInside) {
            nav.classList.remove('active');
        }
    });
});
</script>

<?php wp_footer(); ?>
</body>
</html>
