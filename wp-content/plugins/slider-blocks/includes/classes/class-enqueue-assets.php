<?php
/**
 * Enqueue Assets 
 * @package GutSliderBlocks
 */
 
if (!defined('ABSPATH')) exit;

class GutSlider_Assets {

    /**
     * Preview images for blocks
     * @var array
     */
    private const PREVIEW_IMAGES = [
        'content'            => 'content.svg',
        'photo_carousel'     => 'photo.svg',
        'testimonial_slider' => 'testimonial.svg',
        'before_after'       => 'ba.svg'
    ];


    /**
     * Constructor
     * return void
     */
    public function __construct() {
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_assets'], 2);
        add_action('enqueue_block_assets', [$this, 'enqueue_assets']);
    }

    /**
     * Enqueue editor assets
     * return void
     */
    public function enqueue_editor_assets() {
        $this->enqueue_asset('global');
        $this->enqueue_asset('modules', false);
        $this->localize_preview_images();
    }

    /**
     * Enqueue assets
     * return void
     */
    public function enqueue_assets() {

        wp_register_style(
            'gutslider-swiper-style',
            GUTSLIDER_URL . 'assets/css/swiper-bundle.min.css',
            [],
            GUTSLIDER_VERSION
        );

        wp_register_script(
            'gutslider-swiper-script',
            GUTSLIDER_URL . 'assets/js/swiper-bundle.min.js',
            [],
            GUTSLIDER_VERSION,
            true
        );

        wp_localize_script(
            'gutslider-swiper-script',
            'gutslider_swiper',
            [
                'placeholder' => GUTSLIDER_URL . 'assets/images/placeholder.svg' 
            ]
        );

        if(!is_admin()) {
            wp_register_script(
                'gutslider-fslightbox',
                GUTSLIDER_URL . 'assets/js/fslightbox.js',
                [],
                GUTSLIDER_VERSION,
                true
            );
        }
    }

    /**
     * Enqueue asset
     * @param string $name
     * @param bool $enqueue_style
     * return void
     */
    private function enqueue_asset($name, $enqueue_style = true) {
        $asset_path = GUTSLIDER_DIR_PATH . "build/{$name}/{$name}.asset.php";
        
        if (file_exists($asset_path)) {
            $dependency_file = include $asset_path;
            if (is_array($dependency_file) && !empty($dependency_file)) {
                wp_enqueue_script(
                    "gutslider-blocks-{$name}-script",
                    GUTSLIDER_URL . "build/{$name}/{$name}.js",
                    $dependency_file['dependencies'] ?? [],
                    $dependency_file['version'] ?? GUTSLIDER_VERSION,
                    $name === 'global'
                );
            }
        }

        if ($enqueue_style) {
            wp_enqueue_style(
                "gutslider-blocks-{$name}-style",
                GUTSLIDER_URL . "build/{$name}/{$name}.css",
                [],
                GUTSLIDER_VERSION
            );
        }
    }

    /**
     * Localize preview images
     * return void
     */
    private function localize_preview_images() {
        $preview_urls = [];
        foreach (self::PREVIEW_IMAGES as $key => $image) {
            $preview_urls[$key] = GUTSLIDER_URL . "assets/images/{$image}";
        }
        
        // is Gutslider Pro active 
        $is_pro_active = defined('GUTSLIDER_PRO_VERSION');

        // add to the preview urls
        $preview_urls['is_pro'] = $is_pro_active;

        wp_localize_script(
            'gutslider-blocks-modules-script',
            'gutslider_preview',
            $preview_urls
        );
    }
    
}

new GutSlider_Assets();