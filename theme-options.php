<?php
// theme-options.php

// 注册设置页面
function betheme_add_theme_options_page() {
    add_menu_page(
        '空白回声主题设置页面',          //页面标题
        '空白回声主题',          // 菜单标题
        'manage_options',         // 用户权限角色
        'theme-options',          // 菜单slug
        'betheme_render_theme_options_page' // 回调函数
    );
}
add_action('admin_menu', 'betheme_add_theme_options_page');

// 渲染主题选项页面
function betheme_render_theme_options_page() {
    ?>
    <div class="becustom-settings-container">
        <h1 class="becustom-settings-header"><?php _e('空白回声主题设置', 'betheme'); ?></h1>
        <?php
        if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
            echo '<div class="becustom-success-message"><p>' . __('保存成功.', 'betheme') . '</p></div>';
        }
        ?>
        <form method="post" action="options.php">
            <?php
            settings_fields('betheme_theme_options_group');
            do_settings_sections('theme-options');
            submit_button(__('保存设置', 'betheme'), 'becustom-save-button');
            ?>
        </form>
    </div>
    <?php
}

// 注册设置项
function betheme_register_settings() {
    register_setting('betheme_theme_options_group', 'default_featured_image_url'); //特色图片
    register_setting('betheme_theme_options_group', 'clear_default_featured_image'); //清除特色图片
    register_setting('betheme_theme_options_group', 'custom_footer_text'); //底部文字
    register_setting('betheme_theme_options_group', 'hide_featured_image_on_cards'); //文章卡片特色图
    register_setting('betheme_theme_options_group', 'beian_number'); //备案
    register_setting('betheme_theme_options_group', 'wang_an_beian_number'); //网安备案号
    register_setting('betheme_theme_options_group', 'hide_sidebar_on_mobile'); //手机端侧边栏
    register_setting('betheme_theme_options_group', 'footer_bg_color_1');  //底部颜色1
    register_setting('betheme_theme_options_group', 'footer_bg_color_2');  //底部颜色2
    register_setting('betheme_theme_options_group', 'homepage_keywords'); // 网站首页关键词
    register_setting('betheme_theme_options_group', 'homepage_description'); // 网站首页描述


    add_settings_section(
        'betheme_featured_image_section',
        '', // 不显示标题
        'betheme_featured_image_section_callback',
        'theme-options'
    );

    add_settings_field(
        'default_featured_image_url',
        __('文章默认封面特色图', 'betheme'),
        'betheme_default_featured_image_url_callback',
        'theme-options',
        'betheme_featured_image_section'
    );

    add_settings_field(
        'clear_default_featured_image',
        __('取消文章默认特色图', 'betheme'),
        'betheme_clear_default_featured_image_callback',
        'theme-options',
        'betheme_featured_image_section'
    );

    add_settings_field(
        'hide_featured_image_on_cards',
        __('关闭文章卡片特色图', 'betheme'),
        'betheme_hide_featured_image_on_cards_callback',
        'theme-options',
        'betheme_featured_image_section'
    );

    add_settings_field(
        'hide_sidebar_on_mobile',
        __('手机访问隐藏侧边栏', 'betheme'),
        'betheme_hide_sidebar_on_mobile_callback',
        'theme-options',
        'betheme_featured_image_section'
    );

    add_settings_section(
        'betheme_homepage_settings_section',
        __('网站首页设置', 'betheme'),
        'betheme_homepage_settings_section_callback',
        'theme-options'
    );

    add_settings_field(
        'homepage_keywords',
        __('网站首页关键词', 'betheme'),
        'betheme_homepage_keywords_callback',
        'theme-options',
        'betheme_homepage_settings_section'
    );

    add_settings_field(
        'homepage_description',
        __('网站首页描述', 'betheme'),
        'betheme_homepage_description_callback',
        'theme-options',
        'betheme_homepage_settings_section'
    );

    add_settings_section(
        'betheme_footer_section',
        __('底部信息设置', 'betheme'),
        'betheme_footer_section_callback',
        'theme-options'
    );

    add_settings_field(
        'footer_bg_color',
        __('底部背景颜色', 'betheme'),
        'betheme_footer_bg_color_callback',
        'theme-options',
        'betheme_footer_section'
    );

    add_settings_field(
        'beian-number',
        '备案号',
        'betheme_beian_number_callback',
        'theme-options',
        'betheme_footer_section'
    );

    add_settings_field(
        'wang-an-beian-number',
        '网安备案号',
        'betheme_wang_an_beian_number_callback',
        'theme-options',
        'betheme_footer_section'
    );

    add_settings_field(
        'custom_footer_text',
        __('底部内容', 'betheme'),
        'betheme_custom_footer_text_callback',
        'theme-options',
        'betheme_footer_section'
    );

    // 确保媒体库功能已加载
    wp_enqueue_media();
}
add_action('admin_init', 'betheme_register_settings');

// 检查设置
function betheme_featured_image_section_callback() {
    echo '<p>' . __('就几个可能需要的小功能可以设置.', 'betheme') . '</p>';
}

// 回调函数用于设置默认特色图片
function betheme_default_featured_image_url_callback() {
    $url = get_option('default_featured_image_url', '');
    ?>
    <input type="text" name="default_featured_image_url" id="default_featured_image_url" value="<?php echo esc_attr($url); ?>" placeholder="<?php _e('支持直接输入图片的URL链接', 'betheme'); ?>" class="becustom-settings-input">
    <input type="button" class="button-secondary" value="<?php _e('选择图片', 'betheme'); ?>" id="upload_image_button">
    <p class="description"><?php _e('选择或上传一张图片作为默认特色图.', 'betheme'); ?></p>
    <?php
    if ($url) {
        echo '<br><img src="' . esc_url($url) . '" class="becustom-featured-image-preview">';
    }
}

// 回调函数用于取消默认特色图片
function betheme_clear_default_featured_image_callback() {
    $checked = checked(get_option('clear_default_featured_image'), 1, false);
    ?>
    <input type="checkbox" name="clear_default_featured_image" value="1" <?php echo $checked; ?> class="becustom-settings-checkbox">
    <p><?php _e('勾选保存之后，新发布的文章就不显示默认设置的特色图片.', 'betheme'); ?></p>
    <?php
}

// 回调函数用于文章卡片特色图
function betheme_hide_featured_image_on_cards_callback() {
    $checked = checked(get_option('hide_featured_image_on_cards'), 1, false);
    ?>
    <input type="checkbox" name="hide_featured_image_on_cards" value="1" <?php echo $checked; ?>>
    <p><?php _e('勾选保存之后，首页分类等文章列表上的特色图片不显示，会更简约.', 'betheme'); ?></p>
    <?php
}


// 回调函数用于手机访问的侧边栏
function betheme_hide_sidebar_on_mobile_callback() {
    $checked = checked(get_option('hide_sidebar_on_mobile'), 1, false);
    ?>
    <input type="checkbox" name="hide_sidebar_on_mobile" value="1" <?php echo $checked; ?>>
    <p><?php _e('勾选保存之后，手机访问时左边的侧边栏会被隐藏，默认会显示在底部.', 'betheme'); ?></p>
    <?php
}

// 网站首页设置部分的说明
function betheme_homepage_settings_section_callback() {
    echo '<p>'. __('网站首页SEO关键词和描述设置.', 'betheme'). '</p>';
}

// 回调函数用于设置网站首页关键词
function betheme_homepage_keywords_callback() {
    $keywords = esc_attr(get_option('homepage_keywords'));
   ?>
    <textarea name="homepage_keywords" rows="1" class="becustom-settings-textarea"><?php echo esc_textarea($keywords);?></textarea>
    <p><?php _e('输入网站首页的关键词，多个关键词用英文逗号分隔。', 'betheme');?></p>
    <?php
}

// 回调函数用于设置网站首页描述
function betheme_homepage_description_callback() {
    $description = esc_attr(get_option('homepage_description'));
   ?>
    <textarea name="homepage_description" rows="3" class="becustom-settings-textarea"><?php echo esc_textarea($description);?></textarea>
    <p><?php _e('输入网站首页的描述信息。', 'betheme');?></p>
    <?php
}

// 回调函数用于颜色选择器
function betheme_footer_bg_color_callback() {
    $color1 = get_option('footer_bg_color_1', '#000000');
    $color2 = get_option('footer_bg_color_2', '#000000');
    ?>
    <input type="text" name="footer_bg_color_1" value="<?php echo esc_attr($color1); ?>" class="becustom-settings-input" data-default-color="#000000" />
    <input type="text" name="footer_bg_color_2" value="<?php echo esc_attr($color2); ?>" class="becustom-settings-input" data-default-color="#000000" />
    <p><?php _e('设置底部背景的对角渐变色，默认显示纯黑色。', 'betheme'); ?></p>
    <?php
}


function betheme_footer_section_callback() {
    echo '<p>' . __('网安备案已经内置图标，只写文字就行.', 'betheme') . '</p>';
}

// 底部备案号
function betheme_beian_number_callback() {
    $beian = esc_attr(get_option('beian_number'));
    echo '<input type="text" name="beian_number" value="' . $beian . '" placeholder="输入备案号" />';
}

// 底部网安备案号
function betheme_wang_an_beian_number_callback() {
    $wang_an_beian = esc_attr(get_option('wang_an_beian_number'));
    echo '<input type="text" name="wang_an_beian_number" value="' . $wang_an_beian . '" placeholder="输入网安备案号" />';
}

// 底部信息内容
function betheme_custom_footer_text_callback() {
    $footer_text = get_option('custom_footer_text', '');
    ?>
    <textarea name="custom_footer_text" rows="5" class="becustom-settings-textarea"><?php echo esc_textarea($footer_text); ?></textarea>
    <p><?php _e('支持HTML代码.', 'betheme'); ?></p>
    <?php
}

// 为没有特色图片且没有正文图片的已发布文章设置默认特色图片
function betheme_apply_default_featured_image_to_existing_posts() {
    $default_image_url = get_option('default_featured_image_url');
    $clear_default = get_option('clear_default_featured_image');

    if ($default_image_url && !$clear_default) {
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_thumbnail_id',
                    'compare' => 'NOT EXISTS'
                )
            )
        );

        $posts_without_thumbnail = new WP_Query($args);

        if ($posts_without_thumbnail->have_posts()) {
            $attachment_id = betheme_get_attachment_id_by_url($default_image_url);

            while ($posts_without_thumbnail->have_posts()) {
                $posts_without_thumbnail->the_post();

                if ($attachment_id && !has_post_thumbnail()) {
                    $content = get_the_content();
                    // 如果内容中没有图片，则设置默认特色图
                    if (!preg_match('/<img[^>]+>/', $content)) {
                        set_post_thumbnail(get_the_ID(), $attachment_id);
                    }
                }
            }
        }

        wp_reset_postdata();
    }
}
add_action('init', 'betheme_apply_default_featured_image_to_existing_posts');


// 通过URL获取附件ID
function betheme_get_attachment_id_by_url($url) {
    global $wpdb;
    $attachment_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM $wpdb->posts WHERE guid='%s'",
        $url
    ));
    return $attachment_id;
}

// 如果选中该选项，则清除默认的特色图片URL
function betheme_check_and_clear_default_featured_image() {
    if (get_option('clear_default_featured_image')) {
        delete_option('default_featured_image_url');
        delete_option('clear_default_featured_image');
    }
}
add_action('admin_init', 'betheme_check_and_clear_default_featured_image');

// 隐藏文章卡片特色图样式
function betheme_apply_card_styles() {
    if (get_option('hide_featured_image_on_cards')) {
        echo '<style>
            .article-card .post-thumbnail {
                display: none;
            }
        </style>';
    }
}
add_action('wp_head', 'betheme_apply_card_styles');

// 手机访问隐藏左边侧边栏的样式
function betheme_apply_mobile_sidebar_styles() {
    if (get_option('hide_sidebar_on_mobile')) {
        echo '<style>
            @media only screen and (max-width: 768px) {
                #secondary {
                    display: none;
                }
            }
        </style>';
    }
}
add_action('wp_head', 'betheme_apply_mobile_sidebar_styles');

// 网页底部背景颜色样式
function betheme_apply_footer_bg_styles() {
    $color1 = get_option('footer_bg_color_1', '#333333');
    $color2 = get_option('footer_bg_color_2', '#333333');
    ?>
    <style>
        .site-footer {
            background: linear-gradient(135deg, <?php echo esc_attr($color1); ?>, <?php echo esc_attr($color2); ?>);
            color: #ffffff;
            padding: 40px 0;
            text-align: center;
        }
    </style>
    <?php
}
add_action('wp_head', 'betheme_apply_footer_bg_styles');

// 添加选择图片按钮的脚本
function betheme_enqueue_media_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var frame;

            $('#upload_image_button').on('click', function(e) {
                e.preventDefault();

                // 如果已经打开了框架，就直接返回
                if (frame) {
                    frame.open();
                    return;
                }

                // 创建选择媒体框架
                frame = wp.media({
                    title: '选择图片',
                    button: {
                        text: '使用此图片'
                    },
                    multiple: false
                });

                // 选择媒体时的回调
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#default_featured_image_url').val(attachment.url);
                    $('.becustom-featured-image-preview').attr('src', attachment.url).show();
                });

                // 打开媒体框架
                frame.open();
            });
        });
    </script>
    <?php
}
add_action('admin_footer', 'betheme_enqueue_media_script');
