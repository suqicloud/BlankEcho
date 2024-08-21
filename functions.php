<?php
// 设置主题基本功能
require get_template_directory() . '/theme-options.php';

function betheme_setup() {
    add_theme_support('post-thumbnails'); // 启用特色图片支持
    set_post_thumbnail_size(1200, 9999); // 默认特色图片尺寸
    add_image_size('thumbnail-small', 400, 9999); // 自定义小尺寸特色图片

    // 启用标题标签自动生成
    add_theme_support('title-tag');

    // 启用自定义标志支持
    add_theme_support('custom-logo');

    // 启用HTML5支持
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // 注册主菜单
    register_nav_menus(array(
        'primary' => __('主菜单', 'betheme'),
    ));
}
add_action('after_setup_theme', 'betheme_setup');

// 加载主题样式
function betheme_enqueue_styles() {
    wp_enqueue_style('betheme-style', get_stylesheet_uri(), array(), '1.0.4', 'all');
    //wp_enqueue_style('betheme-style', 'https://你的cdn网址/css/style.css', array(), '1.0.3', 'all');
    //你可以把主题文件夹的style.css上传到你的对象存储，让主题css文件走cdn，就把上面的网址换了，然后注释本地调用，启用远程调用
}
add_action('wp_enqueue_scripts', 'betheme_enqueue_styles');


// 加载主题后台样式
function betheme_enqueue_admin_styles() {
    wp_enqueue_style('betheme-admin-style', get_template_directory_uri() . '/css/admin-style.css');
}
add_action('admin_enqueue_scripts', 'betheme_enqueue_admin_styles');

// 注册侧边栏
function betheme_widgets_init() {
    // 现有的侧边栏注册代码
    register_sidebar(array(
        'name'          => __('侧边栏', 'betheme'),
        'id'            => 'primary-sidebar',
        'description'   => __('首页和文章列表侧边栏.', 'betheme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    // 注册底部小工具区域
    register_sidebar(array(
        'name'          => __('左边底部小工具', 'betheme'),
        'id'            => 'footer-1',
        'description'   => __('网页底部左边小工具.', 'betheme'),
        'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="footer-widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('右边底部小工具', 'betheme'),
        'id'            => 'footer-2',
        'description'   => __('网页底部右边小工具.', 'betheme'),
        'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="footer-widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'betheme_widgets_init');

function betheme_posted_on() {
    echo '<span class="posted-on">' . get_the_date() . '</span>';
}


// 获取后台设置logo
function betheme_custom_logo_setup() {
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'betheme_custom_logo_setup');

// 在文章和页面的编辑屏幕下方添加自定义字段
function betheme_add_meta_boxes() {
    add_meta_box(
        'betheme_meta_box',           // ID
        '自定义SEO设置',               // 标题
        'betheme_meta_box_callback',  // 回调函数
        ['post', 'page'],             // 显示的屏幕类型
        'normal',                     // 上下位置
        'high'                        // 优先级
    );
}
add_action('add_meta_boxes', 'betheme_add_meta_boxes');

// 自定义字段的HTML
function betheme_meta_box_callback($post) {
    // 获取当前的自定义字段值
    $keywords = get_post_meta($post->ID, '_betheme_keywords', true);
    $description = get_post_meta($post->ID, '_betheme_description', true);

    wp_nonce_field('betheme_save_meta_box_data', 'betheme_meta_box_nonce');

    echo '<p><label for="betheme_keywords">关键词:</label></p>';
    echo '<input type="text" id="betheme_keywords" name="betheme_keywords" value="' . esc_attr($keywords) . '" style="width: 100%;" />';
    
    echo '<p><label for="betheme_description">描述:</label></p>';
    echo '<textarea id="betheme_description" name="betheme_description" rows="4" style="width: 100%;">' . esc_textarea($description) . '</textarea>';
}

// 保存自定义字段数据
function betheme_save_meta_box_data($post_id) {
    if (!isset($_POST['betheme_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['betheme_meta_box_nonce'], 'betheme_save_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $keywords = sanitize_text_field($_POST['betheme_keywords']);
    $description = sanitize_textarea_field($_POST['betheme_description']);

    update_post_meta($post_id, '_betheme_keywords', $keywords);
    update_post_meta($post_id, '_betheme_description', $description);
}
add_action('save_post', 'betheme_save_meta_box_data');

// 在head中添加自定义meta标签，包括文章、页面、分类页面和首页
function betheme_add_meta_tags() {
    if (is_singular()) { // 如果是单个文章或页面
        global $post;

        // 获取自定义字段
        $keywords = get_post_meta($post->ID, '_betheme_keywords', true);
        $description = get_post_meta($post->ID, '_betheme_description', true);

        // 如果没有自定义关键词，从标签中提取
        if (empty($keywords)) {
            $tags = get_the_tags();
            if ($tags) {
                $keywords = implode(', ', wp_list_pluck($tags, 'name'));
            }
        }

        // 如果没有自定义描述，从文章内容中提取前80个字符
        if (empty($description)) {
            // 提取内容
            $description = get_post_field('post_content', $post->ID);

            // 删除HTML标签
            $description = preg_replace('/<[^>]*>/', '', $description);

            // 删除多余空格
            $description = preg_replace('/\s+/', ' ', $description);
            
            // 去除末尾的特殊符号
            //$description = rtrim($description, '.,!?');

            // 提取前80个字符
            $description = mb_substr($description, 0, 80);

            // 使用esc_attr进行安全转义
            $description = esc_attr($description);
        }

        // 输出meta标签
        if (!empty($keywords)) {
            echo '<meta name="keywords" content="' . esc_attr($keywords) . '">' . "\n";
        }
        if (!empty($description)) {
            echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        }

    } elseif (is_category()) { // 如果是分类页面
        // 获取当前分类
        $category_name = single_cat_title('', false);

        // 设置关键词
        echo '<meta name="keywords" content="' . esc_attr($category_name) . '">' . "\n";

        // 设置描述
        $category_description = category_description();
        if ($category_description) {
            // 移除HTML标签
            $category_description = wp_strip_all_tags($category_description);
            echo '<meta name="description" content="' . esc_attr($category_description) . '">' . "\n";
        }

    } elseif (is_front_page()) { // 如果是首页
        $keywords = get_option('homepage_keywords');
        $description = get_option('homepage_description');

        if (!empty($keywords)) {
            echo '<meta name="keywords" content="'. esc_attr($keywords) . '">' . "\n";
        }

        if (!empty($description)) {
            echo '<meta name="description" content="'. esc_attr($description) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'betheme_add_meta_tags', 1);


// 获取文章中的图片设置为特色图
function wbset_first_image_as_featured_image($post_id) {
    // 检查这是否是自动保存，或者是否尚未发布
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (get_post_status($post_id) !== 'publish') return;

    // 获取帖子内容
    $post_content = get_post_field('post_content', $post_id);

    // 在内容中查找第一张图片
    preg_match('/<img[^>]+>/i', $post_content, $matches);

    // 如果匹配，则继续
    if (!empty($matches)) {
        $first_image_tag = $matches[0];
        
        // 从标签中提取图像URL
        preg_match('/src="([^"]+)"/i', $first_image_tag, $url_matches);
        if (!empty($url_matches[1])) {
            $image_url = esc_url($url_matches[1]);

            // 检查图片URL是否有效，以及是否已存在于媒体库中
            $attachment_id = attachment_url_to_postid($image_url);

            // 如果图片不在媒体库中，请上传图片
            if (!$attachment_id) {
                $attachment_id = media_sideload_image($image_url, $post_id, null, 'id');
            }

            // 如果有一个有效的附件ID，则将其设置为特色图片
            if ($attachment_id) {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }
    }
}

add_action('save_post', 'wbset_first_image_as_featured_image');

function betheme_custom_footer_css() {
    // 从后台设置中获取颜色值
    $color1 = get_option('footer_bg_color_1', '#000000');
    $color2 = get_option('footer_bg_color_2', '#000000');
    ?>
    <style type="text/css">
        .site-footer {
            background: linear-gradient(45deg, <?php echo esc_attr($color1); ?>, <?php echo esc_attr($color2); ?>);
            color: #ffffff;
            padding: 40px 0;
            text-align: center;
        }
    </style>
    <?php
}
add_action('wp_head', 'betheme_custom_footer_css');

// 文章字数
function get_filtered_character_count($post_id) {
    $post_content = get_post_field('post_content', $post_id);
    
    // 去除HTML标签
    $text = strip_tags($post_content);

    // 只保留数字、中文和英文字符
    $filtered_text = preg_replace('/[^0-9a-zA-Z\x{4e00}-\x{9fff}]/u', '', $text);

    // 计算字符总数
    $character_count = mb_strlen($filtered_text, 'UTF-8');
    
    return $character_count;
}

// 设置分类页面的前缀
function custom_archive_title_prefix($title) {
    if (is_category()) {
        $title = single_cat_title('当前分类：', false);
    }
    return $title;
}
add_filter('get_the_archive_title', 'custom_archive_title_prefix');

// 注册心情动态的自定义文章类型
function betheme_register_social_post_type() {
    $labels = array(
        'name'               => _x('心情动态', 'post type general name', 'betheme'),
        'singular_name'      => _x('心情动态', 'post type singular name', 'betheme'),
        'menu_name'          => _x('心情动态', 'admin menu', 'betheme'),
        'name_admin_bar'     => _x('心情动态', 'add new on admin bar', 'betheme'),
        'add_new'            => _x('添加新动态', 'dynamic', 'betheme'),
        'add_new_item'       => __('添加新动态', 'betheme'),
        'new_item'           => __('新动态', 'betheme'),
        'edit_item'          => __('编辑动态', 'betheme'),
        'view_item'          => __('查看动态', 'betheme'),
        'all_items'          => __('所有动态', 'betheme'),
        'search_items'       => __('搜索动态', 'betheme'),
        'not_found'          => __('没有找到动态', 'betheme'),
        'not_found_in_trash' => __('回收站中没有找到动态', 'betheme')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'social-posts'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor'),
        'show_in_rest'       => true,
    );

    register_post_type('social_posts', $args);
}
add_action('init', 'betheme_register_social_post_type');

// 自动生成心情动态的标题
function betheme_generate_social_post_title($post_id, $post, $update) {
    // 仅在文章类型为 'social_posts' 且标题为空时运行
    if ($post->post_type == 'social_posts' && empty($post->post_title)) {
        // 获取内容并去除HTML标签
        $content = wp_strip_all_tags($post->post_content);

        // 获取内容的前10个字作为标题
        $new_title = mb_substr($content, 0, 10); // 截取前10个字

        // 如果内容为空，设置默认标题
        if (empty($new_title)) {
            $new_title = __('未命名社交动态', 'betheme');
        }

        // 更新文章的标题
        $post_data = array(
            'ID'         => $post_id,
            'post_title' => $new_title,
        );

        // 移除钩子，避免无限循环
        remove_action('save_post', 'betheme_generate_social_post_title', 10);

        // 更新文章
        wp_update_post($post_data);

        // 恢复钩子
        add_action('save_post', 'betheme_generate_social_post_title', 10, 3);
    }
}
add_action('save_post', 'betheme_generate_social_post_title', 10, 3);

// 在心情动态编辑页面隐藏标题输入框
function betheme_hide_social_post_title() {
    global $post_type;
    if ($post_type == 'social_posts') {
        echo '<style type="text/css">
            #postdivrich {
                margin-top: 0;
            }
            #post-body #titlediv, #post-body #title-prompt-text {
                display: none;
            }
        </style>';
    }
}
add_action('admin_head', 'betheme_hide_social_post_title');
