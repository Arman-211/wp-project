<?php
// Подключаем стили и скрипты
function boomerang_enqueue_scripts()
{
    wp_enqueue_style('boomerang-main', get_template_directory_uri() . '/assets/css/main.css');
    wp_enqueue_script('boomerang-scripts', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], null, true);
}

add_action('wp_enqueue_scripts', 'boomerang_enqueue_scripts');

// Регистрация меню
function boomerang_register_menus()
{
    register_nav_menus([
        'main_menu' => 'Главное меню',
    ]);
}

add_action('after_setup_theme', 'boomerang_register_menus');

// Регистрация кастомного типа записей "Слоты"
function register_slot_post_type()
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

// API для вывода JSON со слотами
function get_slots_api()
{
    $args = ['post_type' => 'slot', 'posts_per_page' => -1];
    $query = new WP_Query($args);
    $slots = [];

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $slots[] = [
                'name' => get_the_title(),
                'thumb' => get_the_post_thumbnail_url(),
                'slug' => get_permalink()
            ];
        endwhile;
    endif;

    return rest_ensure_response($slots);
}

function register_slots_api_route()
{
    register_rest_route('testtask/v1', '/slots/get', [
        'methods' => 'GET',
        'callback' => 'get_slots_api',
        'permission_callback' => '__return_true',
    ]);
}

add_action('rest_api_init', 'register_slots_api_route');


function slots_shortcode($atts)
{
    // Set default attributes
    $atts = shortcode_atts(array(
        'posts_per_page' => 5, // Default number of posts
        'order' => 'DESC', // Sorting order
        'orderby' => 'date' // Order by date
    ), $atts, 'slots');

    // Query slots post type
    $query = new WP_Query(array(
        'post_type' => 'slot',
        'posts_per_page' => $atts['posts_per_page'],
        'order' => $atts['order'],
        'orderby' => $atts['orderby']
    ));

    // Start output buffer
    ob_start();

    if ($query->have_posts()) {
        echo '<div class="slots-list">';
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="slot-item">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="slot-content"><?php the_excerpt(); ?></div>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p>No slots found.</p>';
    }

    // Reset post data
    wp_reset_postdata();

    // Return buffer content
    return ob_get_clean();
}

// Register shortcode
add_shortcode('slots', 'slots_shortcode');


//slider
function custom_slider_shortcode()
{
    ob_start();
    ?>
    <div class="custom-slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Слайд 1 -->
                <div class="swiper-slide">
                    <img src="assets/sada.png" alt="" style="width: 300px;height: 300px">
                    <div class="slider-text">
                        <h2>Приветственный Бонус</h2>
                        <p><span class="highlight">100% ДО</span> 245,000₸ + 200 ФС</p>
                        <a href="#" class="slider-button">Зарегистрируйтесь</a>
                    </div>
                </div>

                <div class="swiper-slide">
                    <img src="assets/sdad.png" alt="" style="width: 300px;height: 300px">
                    <div class="slider-text">
                        <h2>Эксклюзивное Предложение</h2>
                        <p><span class="highlight">50% ДО</span> 150,000₸ + 100 ФС</p>
                        <a href="#" class="slider-button">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <?php
    return ob_get_clean();
}

add_shortcode('custom_slider', 'custom_slider_shortcode');

function deposit_bonus_shortcode()
{
    ob_start();
    ?>
    <div class="deposit-container">
        <img src="<?= get_theme_file_uri() . '/assets/red-boomerang.webp'?>" alt="black-boomerang" class="red-boomerang">
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
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/visa-svgrepo-com.svg'?>" alt="visa_log" class="icon_in_deposit"></span>
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/mastercard.svg'?>" alt="mastercard" class="icon_in_deposit"></span>
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/bank.svg'?>" alt="paymsystem_footer_banktransfer" class="icon_in_deposit"></span>
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/ethereum.svg'?>" alt="ethereum" class="ethereum"></span>
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/usdt.svg'?>" alt="ethereum" class="ethereum"></span>
                <span class="icon_span"><img src="<?= get_theme_file_uri() . '/assets/bitcoin-btc-logo.svg'?>" alt="bitcoin-btc-logo.svg" class="bitcoin"></span>
            </div>
        </div>
        <img src="<?= get_theme_file_uri() . '/assets/gray-boomerang.png'?>" alt="gray-boomerang" class="gray-boomerang">
    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('deposit_bonus', 'deposit_bonus_shortcode');

?>
