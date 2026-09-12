<?php
/**
 * Tarot Gợi Mở theme functions.
 */
if (!defined('ABSPATH')) { exit; }

function tarot_goi_mo_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form','comment-form','comment-list','gallery','caption','style','script'));
    register_nav_menus(array('primary' => __('Menu chính', 'tarot-goi-mo')));
}
add_action('after_setup_theme', 'tarot_goi_mo_setup');

function tarot_goi_mo_cards(): array {
    static $cards = null;
    if ($cards !== null) { return $cards; }
    $source = include get_template_directory() . '/assets/data/major-arcana.php';
    $cards = array_map(static function(array $card): array {
        $core = $card['core']; $shadow = $card['shadow']; $action = $card['action'];
        $card['overview'] = ucfirst($core) . '. Đây là lời mời quan sát điều đang diễn ra thay vì xem lá bài như một lời phán chắc chắn.';
        $card['love'] = 'Trong tình cảm, ' . $core . '. Hãy chú ý sự tương hỗ, ranh giới và điều hai bên thực sự làm, không chỉ điều được kỳ vọng.';
        $card['work'] = 'Trong công việc, ' . $core . '. Ưu tiên bước đi có thể kiểm chứng, phản hồi thực tế và cách sử dụng nguồn lực có chủ đích.';
        $card['finance'] = 'Với tài chính, hãy tránh quyết định chỉ vì cảm xúc hoặc áp lực thời điểm. ' . ucfirst($action) . ', đồng thời giữ một biên an toàn cho các tình huống chưa chắc chắn.';
        $card['inner'] = 'Ở tầng nội tâm, lá này gợi bạn nhìn vào cách mình phản ứng khi thiếu chắc chắn. ' . ucfirst($action) . ' để tạo thêm khoảng cách giữa cảm xúc và quyết định.';
        $card['reversed'] = 'Khi đảo ngược, hãy đặc biệt để ý ' . $shadow . '. Chiều đảo không mặc định là xấu; nó thường chỉ phần năng lượng đang bị kẹt, quá mức hoặc chưa được nhìn thẳng.';
        $card['reminder'] = ucfirst($action) . '. Một lựa chọn nhỏ nhưng có ý thức thường hữu ích hơn việc cố tìm một dấu hiệu tuyệt đối.';
        return $card;
    }, is_array($source) ? $source : array());
    return $cards;
}

function tarot_goi_mo_assets(): void {
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('tarot-goi-mo', get_stylesheet_uri(), array(), $version);
    wp_enqueue_script('tarot-goi-mo', get_template_directory_uri() . '/assets/js/tarot.js', array(), $version, true);
    wp_localize_script('tarot-goi-mo', 'TarotGoiMo', array(
        'cards' => tarot_goi_mo_cards(),
        'storageKey' => 'tarot-goi-mo:last-draw',
        'labels' => array('copied' => 'Đã sao chép lời giải.', 'copyFailed' => 'Không thể sao chép tự động.'),
    ));
}
add_action('wp_enqueue_scripts', 'tarot_goi_mo_assets');

function tarot_goi_mo_body_classes(array $classes): array {
    if (is_front_page()) { $classes[] = 'tarot-home'; }
    return $classes;
}
add_filter('body_class', 'tarot_goi_mo_body_classes');
