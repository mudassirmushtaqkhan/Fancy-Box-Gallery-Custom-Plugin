<?php
/*
Plugin Name: Crexed Gallery
Description: A simple portfolio gallery plugin with image scroll hover effects and FancyBox lightbox.
Version: 1.0
Author: Muhammad Mudassir Mushtaq
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Enqueue necessary scripts and styles

// Register Custom Post Type for Gallery
function crexed_register_gallery_cpt() {
    $labels = array(
        'name' => 'Gallery',
        'singular_name' => 'Gallery Image',
        'menu_name' => 'Gallery',
        'add_new' => 'Add New Image',
        'add_new_item' => 'Add New Gallery Image',
        'edit_item' => 'Edit Gallery Image',
        'new_item' => 'New Gallery Image',
        'view_item' => 'View Gallery Image',
        'search_items' => 'Search Gallery Images',
    );
    $args = array(
        'label' => 'Gallery',
        'labels' => $labels,
        'supports' => array('title', 'thumbnail'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-format-gallery',
        'has_archive' => true,
        'rewrite' => array('slug' => 'gallery'),
    );

    register_post_type('crexed_gallery', $args);
}

add_action('init', 'crexed_register_gallery_cpt');

// Create Shortcode to Display Gallery Images with Pagination and Mobile Navigation
function crexed_gallery_shortcode($atts) {
    $atts = shortcode_atts(array(
        'posts_per_page' => 8, // Show 4 post per page
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    ), $atts, 'crexed_gallery');

    $args = array(
        'post_type' => 'crexed_gallery',
        'posts_per_page' => $atts['posts_per_page'],
        'paged' => $atts['paged'],
    );

    $query = new WP_Query($args);
    
    $output = '<div class="crexed-gallery-container">';

    while ($query->have_posts()) {
        $query->the_post();
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $output .= '<div class="crexed-item">';
        $output .= '<div class="crexed-gallery-item">';
        $output .= '<a href="' . $image . '" data-fancybox="gallery">';
        $output .= get_the_post_thumbnail(get_the_ID(), 'full', ['class' => 'crexed-gallery-image']);
        $output .= '<div class="crexed-overlay"><span class="crexed-plus">+</span></div>';    
        $output .= '</a></div></div>';
    }

    $output .= '</div>'; // Close gallery container
   

    // Add navigation for mobile
    $output .= '<div class="crexed-gallery-navigation">';
    $output .= '<div class="mobile-navigation"><a class="crexed-prev" href="#" <i class="fa fa-angle-right" style="font-size:24px;text-decoration: none;"></i>Prev</a><a class="crexed-next" href="#" <i class="fa fa-angle-left" style="font-size:24px;text-decoration: none;"></i>Next</a> </div>';
    $output .= get_previous_posts_link('<span class="crexed-prev">&larr; Previous</span>', $query->max_num_pages);
    $output .= get_next_posts_link('<span class="crexed-next">Next &rarr;</span>', $query->max_num_pages);
    
    $output .= '</div>';
    

    wp_reset_postdata();

    return $output;
}
add_shortcode('crexed_gallery', 'crexed_gallery_shortcode');
// Add support for thumbnails
function crexed_add_thumbnail_support() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'crexed_add_thumbnail_support');

// add custom js file 

function crexed_gallery_enqueue_scripts() {
 
    wp_enqueue_style('crexed-gallery-icon', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', ['jquery'], null, true);
    wp_enqueue_style('fancybox-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css');
    wp_enqueue_script('crexed-gallery-js', plugin_dir_url(__FILE__) . 'js/crexed-gallery.js', ['jquery'], null, true);
    wp_enqueue_style('crexed-gallery-style', plugin_dir_url(__FILE__) . 'css/crexed-gallery-style.css');
}
add_action('wp_enqueue_scripts', 'crexed_gallery_enqueue_scripts');

?> 
