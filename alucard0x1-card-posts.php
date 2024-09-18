<?php
/**
 * Plugin Name: Elementor Card Posts Widget Addon
 * Description: Elementor-Card-Posts-Widget-Addon is a custom Elementor widget that allows you to display a responsive grid of posts in a card format.
 * Version: 1.0.0
 * Author: Alucard0x1
 * Author URI: https://github.com/Alucard0x1
 * Text Domain: alucard0x1-card-posts
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define constants
define( 'ALUCARD0X1_CARD_POSTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'ALUCARD0X1_CARD_POSTS_URL', plugin_dir_url( __FILE__ ) );

// Include the widget file
function alucard0x1_register_card_posts_widget( $widgets_manager ) {
    require_once ALUCARD0X1_CARD_POSTS_PATH . 'widgets/card-posts-widget.php';
    $widgets_manager->register( new \Elementor\Alucard0x1_Card_Posts_Widget() );
}
add_action( 'elementor/widgets/register', 'alucard0x1_register_card_posts_widget' );

// Enqueue Styles
function alucard0x1_card_posts_enqueue_styles() {
    wp_enqueue_style( 'alucard0x1-card-posts-style', ALUCARD0X1_CARD_POSTS_URL . 'assets/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'alucard0x1_card_posts_enqueue_styles' );
