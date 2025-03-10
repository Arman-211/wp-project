<?php
/**
 * GutSliderBlocks Init 
 * @package GutSliderBlocks
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly.

if (!class_exists('GutSlider_Init')) {

    class GutSlider_Init {

        /**
         * Constructor
         * return void
         */
        public function __construct() {
            $this->includes();
        }

        /**
         * Include the required files
         * return void
         */
        public function includes() {

            // icons 
            require_once trailingslashit(GUTSLIDER_DIR) . 'includes/icons/icons.php';
            require_once trailingslashit(GUTSLIDER_DIR) . 'includes/icons/allowed-svg.php';

            // classes
            require_once trailingslashit(GUTSLIDER_DIR) . 'includes/classes/class-enqueue-assets.php';
            require_once trailingslashit(GUTSLIDER_DIR) . 'includes/classes/class-blocks-category.php';
            require_once trailingslashit(GUTSLIDER_DIR) . 'includes/classes/class-register-blocks.php';
            require_once trailingslashit(GUTSLIDER_DIR) . 'includes/classes/class-generate-style.php';
            require_once trailingslashit(GUTSLIDER_DIR) . 'includes/classes/class-load-fonts.php';

            // api 
            require_once trailingslashit(GUTSLIDER_DIR) . 'includes/api/api.php';
        }
    }
}

new GutSlider_Init(); // Initialize the class