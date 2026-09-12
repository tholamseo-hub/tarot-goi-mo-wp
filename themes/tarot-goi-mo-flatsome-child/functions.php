<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Child theme chỉ làm nhiệm vụ tích hợp nhẹ với Flatsome.
 * Toàn bộ logic Tarot nằm trong plugin Tarot Gợi Mở Core.
 */
function tgm_flatsome_child_assets(): void {
    $theme = wp_get_theme();
    wp_enqueue_style(
        'tarot-goi-mo-flatsome-child',
        get_stylesheet_uri(),
        array(),
        $theme->get('Version') ?: '0.1.0'
    );
}
add_action('wp_enqueue_scripts', 'tgm_flatsome_child_assets', 20);

function tgm_flatsome_child_body_class(array $classes): array {
    $classes[] = 'tarot-goi-mo-flatsome';
    return $classes;
}
add_filter('body_class', 'tgm_flatsome_child_body_class');

function tgm_flatsome_child_admin_notice(): void {
    $parent = wp_get_theme(get_template());
    if (strtolower((string) $parent->get('Name')) !== 'flatsome') {
        echo '<div class="notice notice-warning"><p><strong>Tarot Gợi Mở — Flatsome Child:</strong> Child theme này cần theme cha Flatsome đã được cài đặt.</p></div>';
    }
}
add_action('admin_notices', 'tgm_flatsome_child_admin_notice');
