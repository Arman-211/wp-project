<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body>

<header class="header">
    <div class="container">
        <!-- Левая часть (Логотип + меню) -->
        <div class="header-left">
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/logo2.svg" alt="Boomerang Casino">
                </a>
            </div>

            <nav class="nav">
                <?php wp_nav_menu([
                    'theme_location' => 'main_menu',
                    'container' => false,
                    'menu_class' => 'menu'
                ]); ?>
            </nav>
        </div>

        <div class="header-right">
            <div class="auth-buttons">
                <div class="btn is-60 vip-slider__btn login" style="background-color: #292c32">
                    <span class="btn_span_login with">Войти</span>
                </div>
                <div class="btn is-60 vip-slider__btn show-user" style="background-color: #ffcd34;">
                    <span class="btn_span_register">Регистрация</span>
                </div>
            </div>

            <button class="burger-menu">
                <img src="<?= get_theme_file_uri() . '/assets/menu-icon.svg' ; ?>" alt="Меню">
            </button>
        </div>
    </div>
</header>

