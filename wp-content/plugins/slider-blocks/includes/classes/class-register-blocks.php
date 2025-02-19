<?php
/**
 * Register Blocks 
 * @package GutSliderBlocks
 */

 if( ! defined( 'ABSPATH' ) ) {
 	exit;
 } 

 if( ! class_exists( 'GutSliderBlocks_Registration' ) ) {

    /**
     * @since 1.0.0
     * @package GutSlider Blocks
     */
    class GutSliderBlocks_Registration {

        /**
         * Constructor
         * 
         * @since 1.0.0
         * @return void
         */
        public function __construct() {
            $this->init();
        }

        /**
         * Initialize the Class
         * 
         * @since 1.0.0
         * @return void
         */
        private function init() {
            add_action( 'init', array ( $this, 'register_blocks'  ) );
        }

        /**
         * Register Blocks
         * 
         * @since 1.0.0
         * @return void
         */
        public function register_blocks() {

            $blocks = get_option( 'gutslider_blocks', $this->get_gutslider_blocks() );
        
            if ( ! empty( $blocks ) && is_array( $blocks ) ) {
                foreach ( $blocks as $block ) {
                    $path = GUTSLIDER_DIR_PATH;
        
                    if( isset( $block['is_pro'] ) && $block['is_pro'] === true && defined( 'GUTSLIDER_PRO_PATH' ) ) {
                        $path = GUTSLIDER_PRO_PATH;
                    }
        
                    $block_name = trailingslashit( $path ) . 'build/blocks/' . $block['name'];
                    $full_block_name = 'gutsliders/' . $block['name'];
        
                    if ( isset( $block['active'] ) && $block['active'] === false ) {
                        // Check if the block type is registered before trying to unregister it
                        if( WP_Block_Type_Registry::get_instance()->is_registered( $full_block_name ) ) {
                            unregister_block_type( $full_block_name );
                        }
                    } else {
                        if( file_exists( $block_name ) ) {
                            // Check if the block is not already registered
                            if ( ! WP_Block_Type_Registry::get_instance()->is_registered( $full_block_name ) ) {
                                register_block_type( $block_name );
                            }
                        }
                    }
                }
            }
        }

         /**
         * Get GutSlider Blocks
         */
        public function get_gutslider_blocks() {
            return require GUTSLIDER_DIR_PATH . 'includes/api/blocks.php';
        }


    }

 }

    new GutSliderBlocks_Registration(); // Initialize the class.