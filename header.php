<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    
<header id="masthead" class="site-header">
    <div class="site-branding">
        <?php
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            if (is_front_page() && is_home()) :
                ?>
                <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                <?php
            else :
                ?>
                <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
                <?php
            endif;
        }
        ?>

        <div class="mobile-menu-toggle">
            <button id="mobile-menu-button" aria-label="切换导航">
                <span class="menu-icon">&#9776;</span> <!-- 手机访问菜单 -->
            </button>
        </div>
    </div>

    <nav id="site-navigation" class="main-navigation">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'container'      => false, // 可以避免额外的 <div> 包裹
        ));
        ?>
    </nav><!-- 菜单 -->
</header><!-- 头部结束 -->

<div id="content" class="site-content">
