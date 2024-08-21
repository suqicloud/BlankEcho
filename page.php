<?php
get_header(); // 加载头部文件
?>

<div class="becontainer">

    <main id="main" class="pagesite-main">

        <?php
        while (have_posts()) :
            the_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header><!-- 页面标题 -->

                <div class="entry-content">
                    <?php
                    the_content();

                    // 分页链接
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('页面:', 'betheme'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <?php if (get_edit_post_link()) : ?>
                    <footer class="entry-footer">
                        <?php
                        edit_post_link(
                            sprintf(
                                wp_kses(
                                    __('编辑 <span class="screen-reader-text">%s</span>', 'betheme'),
                                    array(
                                        'span' => array(
                                            'class' => array(),
                                        ),
                                    )
                                ),
                                get_the_title()
                            ),
                            '<span class="edit-link">',
                            '</span>'
                        );
                        ?>
                    </footer><!-- 页面底部 -->
                <?php endif; ?>
            </article><!-- #post-<?php the_ID(); ?> -->

        <?php
        endwhile; // 循环结束
        ?>

    </main>
</div>

<?php
get_footer(); // 加载底部文件
?>
