<?php
/**
 * Tarot Gợi Mở theme functions.
 */

if (!defined('ABSPATH')) {
    exit;
}

function tarot_goi_mo_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    register_nav_menus(array(
        'primary' => __('Menu chính', 'tarot-goi-mo'),
    ));
}
add_action('after_setup_theme', 'tarot_goi_mo_setup');

function tarot_goi_mo_assets(): void {
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('tarot-goi-mo', get_stylesheet_uri(), array(), $version);
    wp_enqueue_script(
        'tarot-goi-mo',
        get_template_directory_uri() . '/assets/js/tarot.js',
        array(),
        $version,
        true
    );

    wp_localize_script('tarot-goi-mo', 'TarotGoiMo', array(
        'dataUrl' => get_template_directory_uri() . '/assets/data/major-arcana.json',
        'siteName' => get_bloginfo('name'),
    ));
}
add_action('wp_enqueue_scripts', 'tarot_goi_mo_assets');

function tarot_goi_mo_body_classes(array $classes): array {
    if (is_front_page()) {
        $classes[] = 'tarot-home';
    }
    return $classes;
}
add_filter('body_class', 'tarot_goi_mo_body_classes');
