<?php
function boomerang_enqueue_scripts(): void
{
    wp_enqueue_style('boomerang-main', get_template_directory_uri() . '/assets/css/main.css');
    wp_enqueue_script('boomerang-scripts', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], null, true);
}

add_action('wp_enqueue_scripts', 'boomerang_enqueue_scripts');

function boomerang_register_menus(): void
{
    register_nav_menus([
        'main_menu' => 'Главное меню',
    ]);
}

add_action('after_setup_theme', 'boomerang_register_menus');

function register_slot_post_type(): void
{
    register_post_type('slot', [
        'labels' => [
            'name' => 'Слоты',
            'singular_name' => 'Слот'
        ],
        'public' => true,
        'menu_icon' => 'dashicons-games',
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
        'show_in_rest' => true
    ]);
}

add_action('init', 'register_slot_post_type');


function register_slots_api_route(): void
{
    register_rest_route('testtask/v1', '/slots/get', [
        'methods' => 'GET',
        'callback' => 'get_slots_api',
        'permission_callback' => '__return_true',
    ]);
}

add_action('rest_api_init', 'register_slots_api_route');

function categories_bar_shortcode(): bool|string
{
    $categories = [
        [
            'title' => 'Топ',
            'icon' => 'assets/icons/crown.svg',
            'link' => '#'
        ],
        [
            'title' => 'Новые',
            'icon' => 'assets/icons/plus.svg',
            'link' => '#'
        ],
        [
            'title' => 'Популярные',
            'icon' => 'assets/icons/popular.svg',
            'link' => '#'
        ],
        [
            'title' => 'Рекомендуем',
            'icon' => 'assets/icons/roulletes.svg',
            'link' => '#'
        ],
        [
            'title' => 'Эксклюзив',
            'icon' => 'assets/icons/bonus-buys.svg',
            'link' => '#'
        ],
        [
            'title' => 'Слоты',
            'icon' => 'assets/icons/iconslotsboom.svg',
            'link' => '#'
        ],
        [
            'title' => 'Рулетки',
            'icon' => 'assets/icons/iconlivecasinoboom.svg',
            'link' => '#'
        ],
        [
            'title' => 'Настольные',
            'icon' => 'assets/icons/iconall.png',
            'link' => '#'
        ],
    ];

    ob_start();
    ?>
    <div class="categories-bar">
        <label class="categories-label">
            <input type="text" placeholder="Поиск" class="search-input">
            <button class="search-button">
                <?php echo file_get_contents(get_template_directory() . '/assets/searchicon.svg'); ?>
            </button>
        </label>
        <button class="provider-button">
            <div class="provider-button-block">
                <?php echo file_get_contents(get_template_directory() . '/assets/left.svg'); ?>
                <span class="provider-button-title">Провайдеры</span>
            </div>
            <?php echo file_get_contents(get_template_directory() . '/assets/open-arrow.svg'); ?>
        </button>
    </div>
    <div class="categories-list">
        <?php foreach ($categories as $cat): ?>
            <a class="category-item" href="<?php echo esc_url($cat['link']); ?>">
                      <span class="category-icon">
                        <?php
                        $icon_path = get_template_directory() . '/' . $cat['icon'];
                        if (file_exists($icon_path)) {
                            echo file_get_contents($icon_path);
                        } else {
                            echo '<!-- SVG not found -->';
                        }
                        ?>
                    </span>
                <span class="category-title"><?php echo esc_html($cat['title']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <h2 class="slot-list-title">Топ Слот</h2>
    <?php

    return ob_get_clean();
}

add_shortcode('categories_bar', 'categories_bar_shortcode');


function slots_shortcode(): bool|string
{
    $slots = [
        [
            'image' => 'assets/game/bufalo_extra.jpg',
            'provider' => 'Zillion',
            'is_top_slot' => true,
            'link' => '#'
        ],
        [
            'image' => 'assets/game/plinko.webp',
            'provider' => 'BetSoft',
            'is_top_slot' => true,
            'link' => '#'
        ],
        [
            'image' => 'assets/game/bookofdeadicon.jpg',
            'provider' => 'BetSoft',
            'is_top_slot' => true,
            'link' => '#'
        ],
        [
            'image' => 'assets/game/joker400x600.svg',
            'provider' => 'CasinoMax',
            'is_top_slot' => true,
            'link' => '#'
        ],
        [
            'image' => 'assets/game/dggsponentialbanneropt400x600logotop.svg',
            'provider' => 'BetSoft',
            'is_top_slot' => true,
            'link' => '#'
        ],

        [
            'image' => 'assets/game/cashofgods400x600fix.svg',
            'provider' => 'SpinTech',
            'is_top_slot' => true,
            'link' => '#'
        ],
    ];

    ob_start();
    ?>
    <div class="slots-list">
        <?php foreach ($slots as $slot): ?>
            <div class="slot-item">
                <a href="<?php echo htmlspecialchars($slot['link']); ?>" class="slot-card">
                    <div class="slot-image">
                        <img src="<?php echo get_theme_file_uri() . '/' . $slot['image']; ?>"
                             alt="<?php echo htmlspecialchars($slot['provider']); ?>">
                        <?php if ($slot['is_top_slot']): ?>
                            <span class="top-slot">Топ Слот</span>
                        <?php endif; ?>
                    </div>
                    <div class="slot-info">
                        <span class="slot-provider"><?php echo htmlspecialchars($slot['provider']); ?></span>
                        <div class="slot-favorite">❤</div>
                    </div>
                    <div class="slot-hover-content">
                        <button class="play-button">
                            <span class="play-icon">
                                <img class="img_slot_hover"
                                     src="<?php echo get_theme_file_uri() . '/' . "assets/slot_right.svg" ?>"
                                     alt="<?php echo htmlspecialchars("assets/slot_right.svg"); ?>">
                            </span>
                        </button>
                        <p class="hover-text">Demo</p>
                        <div class="slot-hover-image">
                            <img class="hover-image"
                                 src="<?php echo get_theme_file_uri() . '/' . "assets/slot-hover.svg"; ?>"
                                 alt="Hover Image">
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('slots', 'slots_shortcode');

function deposit_bonus_shortcode(): bool|string
{
    ob_start();
    ?>
    <div class="deposit-container">
        <img src="<?= get_theme_file_uri() . '/assets/red-boomerang.webp' ?>" alt="black-boomerang"
             class="red-boomerang">
        <div>
            <h2 class="deposit-title">СДЕЛАЙТЕ ДЕПОЗИТ И ИГРАЙТЕ</h2>

            <div class="deposit-bonus-container">

                <div class="bonus-box">
                    <div class="bonus-icon">🍒</div>
                    <div class="bonus-content">
                        <p class="bonus-title">Приветственный бонус</p>
                        <p class="bonus-text">
                            <span class="highlight">100% до €500 + 200 ФС</span>
                        </p>
                    </div>
                    <div class="bonus-arrow">
                        <span class="arrow_span">
                            <img src="<?= get_theme_file_uri() . '/assets/arrow.svg' ?>"
                                 alt="" class="arrow_svg">
                        </span>
                    </div>
                </div>

                <div class="deposit-input-container">
                    <div class="deposit-input-section">
                        <label>
                            <input type="number" class="deposit-input" value="60" min="10" step="10">
                        </label>
                    </div>
                    <div class="deposit-input-section-two">
                        <label class="custom-select-container">
                            <select class="currency-select">
                                <option value="USD" style="background-color: #c2c2c2;width: 45%;">USD</option>
                                <option value="EUR" selected style="background-color: #c2c2c2;width: 45%;">EUR</option>
                                <option value="RUB" style="background-color: #c2c2c2;width: 45%;">RUB</option>
                            </select>
                        </label>
                    </div>

                </div>

                <div class="btn is-60 vip-slider__btn show-user" style="background-color: #ffcd34">
                    <span class="btn_span">Играть сейчас </span>
                </div>

            </div>
            <div class="social-icons">
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/visa-svgrepo-com.svg' ?>"
                                             alt="visa_log" class="icon_in_deposit"></span>
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/mastercard.svg' ?>"
                                             alt="mastercard" class="icon_in_deposit"></span>
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/bank.svg' ?>"
                                             alt="paymsystem_footer_banktransfer" class="icon_in_deposit"></span>
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/ethereum.svg' ?>" alt="ethereum"
                                             class="ethereum"></span>
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/usdt.svg' ?>" alt="ethereum"
                                             class="ethereum"></span>
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/bitcoin-btc-logo.svg' ?>"
                                             alt="bitcoin-btc-logo.svg" class="bitcoin"></span>
            </div>
        </div>
        <img src="<?= get_theme_file_uri() . '/assets/gray-boomerang.png' ?>" alt="gray-boomerang"
             class="gray-boomerang">
    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('deposit_bonus', 'deposit_bonus_shortcode');

?>
