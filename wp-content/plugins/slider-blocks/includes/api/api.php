<?php

// exit if accessed directly
if (!defined('ABSPATH')) exit;

if (!class_exists('GutSlider_Blocks_API')) {

    /**
     * Nexa Blocks API
     *
     * @since 1.0.0
     */

    class GutSlider_Blocks_API {

        /**
         * Constructor
         *
         * @since 1.0.0
         */
        public function __construct() {
            add_action('rest_api_init', [$this, 'register_endpoints']);
            add_action('init', [$this, 'save_default_blocks']);
        }

        /**
         * Register Endpoints
         *
         * @since 1.0.0
         */
        public function register_endpoints() {
            register_rest_route('gutslider/v1', '/blocks', [
                'methods'             => ['GET', 'POST'],
                'callback'            => [$this, 'handle_blocks_request'],
                'permission_callback' => [$this, 'get_permissions']
            ]);
        }

        /**
         * Handle Blocks Request
         *
         * @since 1.0.0
         */
        public function handle_blocks_request($request) {
            if ($request->get_method() === 'GET') {
                return $this->get_blocks();
            } elseif ($request->get_method() === 'POST') {
                return $this->update_block_status($request);
            }
        }

        /**
         * Get Blocks
         *
         * @since 1.0.0
         */
        public function get_blocks() {
            return rest_ensure_response(get_option('gutslider_blocks'));
        }

        /**
         * Update Block Status
         * 
         * @since 1.0.0
         */
        public function update_block_status( $request ) {
            // nonce verification
            $nonce = $request->get_param('nonce');
        
            if (!wp_verify_nonce($nonce, 'gutslider_nonce')) {
                return new WP_Error('invalid_request', __('Invalid request.', 'slider-blocks'), array('status' => 403));
            }
        
            $block_names       = $request->get_param('names');
            $single_block_name = $request->get_param('name');
            $active_status     = filter_var($request->get_param('active'), FILTER_VALIDATE_BOOLEAN);
        
            // Fetch existing blocks
            $blocks = get_option('gutslider_blocks');
        
            if (!empty($single_block_name)) {
                $block_names = [sanitize_text_field($single_block_name)];
            } elseif (is_array($block_names)) {
                $block_names = array_map('sanitize_text_field', $block_names);
            } else {
                return new WP_Error('invalid_request', __('Invalid block name(s) provided.', 'slider-blocks'), array('status' => 400));
            }
        
            // Update the blocks' active status
            foreach ($blocks as &$block) {
                if (in_array($block['name'], $block_names)) {
                    $block['active'] = $active_status;
                }
            }
        
            // Update the option
            update_option('gutslider_blocks', $blocks);
        
            return rest_ensure_response($blocks);
        }

        /**
         * Get Blocks Permissions
         *
         * @since 1.0.0
         */
        public function get_permissions() {
            return current_user_can('edit_posts');
        }

        /**
         * Save Default Blocks
         *
         * @since 1.0.0
         */
        public function save_default_blocks() {
            $existing_blocks = get_option('gutslider_blocks', []);
            $new_blocks = $this->get_gutslider_blocks();

            // Temporary array to store the merged blocks
            $merged_blocks = [];
        
            // Merge existing and new blocks
            foreach ($new_blocks as $new_block) {
                $found = false;
        
                foreach ($existing_blocks as $existing_block) {
                    if ($existing_block['name'] === $new_block['name']) {
                        // Merge the existing block with new data, but retain the active status
                        $merged_blocks[] = array_merge($new_block, ['active' => $existing_block['active']]);
                        $found = true;
                        break;
                    }
                }
        
                // If the block does not exist in the current options, add it
                if (!$found) {
                    $merged_blocks[] = $new_block;
                }
            }
        
            // Remove blocks that are no longer in the new list
            foreach ($existing_blocks as $existing_block) {
                $block_exists = false;
        
                foreach ($new_blocks as $new_block) {
                    if ($new_block['name'] === $existing_block['name']) {
                        $block_exists = true;
                        break;
                    }
                }
        
                if (!$block_exists) {
                    // If the block exists in existing_blocks but not in new_blocks, remove it from merged_blocks
                    $key = array_search($existing_block['name'], array_column($merged_blocks, 'name'));
                    if ($key !== false) {
                        unset($merged_blocks[$key]);
                    }
                }
            }
        
            // Re-index the array to ensure there are no gaps in keys
            $merged_blocks = array_values($merged_blocks);
        
            update_option('gutslider_blocks', $merged_blocks);
        }

        /**
         * Get GutSlider Blocks
         */
        public function get_gutslider_blocks() {
            return require GUTSLIDER_DIR_PATH . 'includes/api/blocks.php';
        }

    }

    new GutSlider_Blocks_API(); // Initialize the API class.
}