<?php
/**
 * Plugin Name: Custom GutSlider Block
 * Description: Gutenberg-блок для кастомного слайдера.
 * Version: 1.0
 */

if (!defined('ABSPATH')) exit;

// Регистрируем блок
function register_custom_gutslider_block() {
    wp_register_script(
        'custom-gutslider-block',
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element', 'wp-i18n'),
        filemtime(plugin_dir_path(__FILE__) . 'block.js')
    );

    wp_register_style(
        'custom-gutslider-style',
        plugins_url('style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'style.css')
    );

    register_block_type('custom/gutslider', array(
        'editor_script' => 'custom-gutslider-block',
        'style'         => 'custom-gutslider-style',
    ));
}

add_action('init', 'register_custom_gutslider_block');
