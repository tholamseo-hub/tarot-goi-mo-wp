<?php
/**
 * Plugin Name: Tarot Gợi Mở Core
 * Description: Logic rút bài, thư viện 22 lá và nội dung Tarot độc lập với theme. Tối ưu để dùng cùng Flatsome UX Builder.
 * Version: 0.1.0
 * Author: Tarot Gợi Mở
 * Text Domain: tarot-goi-mo-core
 */

if (!defined('ABSPATH')) { exit; }

define('TGM_CORE_VERSION', '0.1.0');
define('TGM_CORE_URL', plugin_dir_url(__FILE__));
define('TGM_CORE_PATH', plugin_dir_path(__FILE__));

function tgm_core_register_post_type(): void {
    register_post_type('tgm_tarot_card', array(
        'labels' => array(
            'name' => 'Lá Tarot',
            'singular_name' => 'Lá Tarot',
            'add_new_item' => 'Thêm lá Tarot',
            'edit_item' => 'Sửa lá Tarot',
            'menu_name' => 'Tarot Gợi Mở',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => array('title', 'page-attributes'),
    ));
}
add_action('init', 'tgm_core_register_post_type');

function tgm_core_meta_fields(): array {
    return array(
        'number' => 'Số / La Mã',
        'name_en' => 'Tên tiếng Anh',
        'keywords' => 'Từ khóa',
        'overview' => 'Tổng quan',
        'love' => 'Tình cảm',
        'work' => 'Công việc',
        'finance' => 'Tài chính',
        'inner' => 'Nội tâm',
        'reversed' => 'Khi đảo ngược',
        'reminder' => 'Lời nhắc',
    );
}

function tgm_core_add_meta_box(): void {
    add_meta_box(
        'tgm-card-details',
        'Nội dung lá Tarot',
        'tgm_core_render_meta_box',
        'tgm_tarot_card',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'tgm_core_add_meta_box');

function tgm_core_render_meta_box(WP_Post $post): void {
    wp_nonce_field('tgm_save_card', 'tgm_card_nonce');
    foreach (tgm_core_meta_fields() as $key => $label) {
        $value = (string) get_post_meta($post->ID, '_tgm_' . $key, true);
        $is_short = in_array($key, array('number', 'name_en', 'keywords'), true);
        echo '<p><label for="tgm_' . esc_attr($key) . '"><strong>' . esc_html($label) . '</strong></label></p>';
        if ($is_short) {
            echo '<input class="widefat" id="tgm_' . esc_attr($key) . '" name="tgm_' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
        } else {
            echo '<textarea class="widefat" rows="4" id="tgm_' . esc_attr($key) . '" name="tgm_' . esc_attr($key) . '">' . esc_textarea($value) . '</textarea>';
        }
    }
}

function tgm_core_save_card(int $post_id): void {
    if (!isset($_POST['tgm_card_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tgm_card_nonce'])), 'tgm_save_card')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
    if (!current_user_can('edit_post', $post_id)) { return; }
    foreach (tgm_core_meta_fields() as $key => $label) {
        if (!isset($_POST['tgm_' . $key])) { continue; }
        $raw = wp_unslash($_POST['tgm_' . $key]);
        $value = in_array($key, array('number', 'name_en', 'keywords'), true)
            ? sanitize_text_field($raw)
            : sanitize_textarea_field($raw);
        update_post_meta($post_id, '_tgm_' . $key, $value);
    }
}
add_action('save_post_tgm_tarot_card', 'tgm_core_save_card');

function tgm_core_build_texts(array $card): array {
    $core = isset($card['core']) ? (string) $card['core'] : '';
    $shadow = isset($card['shadow']) ? (string) $card['shadow'] : '';
    $action = isset($card['action']) ? (string) $card['action'] : '';
    return array(
        'overview' => ucfirst($core) . '. Đây là lời mời quan sát điều đang diễn ra thay vì xem lá bài như một lời phán chắc chắn.',
        'love' => 'Trong tình cảm, ' . $core . '. Hãy chú ý sự tương hỗ, ranh giới và điều hai bên thực sự làm, không chỉ điều được kỳ vọng.',
        'work' => 'Trong công việc, ' . $core . '. Ưu tiên bước đi có thể kiểm chứng, phản hồi thực tế và cách sử dụng nguồn lực có chủ đích.',
        'finance' => 'Với tài chính, hãy tránh quyết định chỉ vì cảm xúc hoặc áp lực thời điểm. ' . ucfirst($action) . ', đồng thời giữ một biên an toàn cho các tình huống chưa chắc chắn.',
        'inner' => 'Ở tầng nội tâm, lá này gợi bạn nhìn vào cách mình phản ứng khi thiếu chắc chắn. ' . ucfirst($action) . ' để tạo thêm khoảng cách giữa cảm xúc và quyết định.',
        'reversed' => 'Khi đảo ngược, hãy đặc biệt để ý ' . $shadow . '. Chiều đảo không mặc định là xấu; nó thường chỉ phần năng lượng đang bị kẹt, quá mức hoặc chưa được nhìn thẳng.',
        'reminder' => ucfirst($action) . '. Một lựa chọn nhỏ nhưng có ý thức thường hữu ích hơn việc cố tìm một dấu hiệu tuyệt đối.',
    );
}

function tgm_core_import_legacy_cards(): void {
    $existing = get_posts(array(
        'post_type' => 'tgm_tarot_card',
        'post_status' => 'any',
        'posts_per_page' => 1,
        'fields' => 'ids',
    ));
    if ($existing) { return; }

    $legacy_file = WP_CONTENT_DIR . '/themes/tarot-goi-mo/assets/data/major-arcana.php';
    if (!is_readable($legacy_file)) {
        update_option('tgm_core_import_status', 'legacy_missing');
        return;
    }

    $cards = include $legacy_file;
    if (!is_array($cards) || count($cards) !== 22) {
        update_option('tgm_core_import_status', 'legacy_invalid');
        return;
    }

    foreach (array_values($cards) as $index => $card) {
        $post_id = wp_insert_post(array(
            'post_type' => 'tgm_tarot_card',
            'post_status' => 'publish',
            'post_title' => isset($card['name_vi']) ? sanitize_text_field($card['name_vi']) : 'Lá Tarot',
            'menu_order' => $index,
        ));
        if (is_wp_error($post_id)) { continue; }

        $texts = tgm_core_build_texts($card);
        $values = array(
            'number' => $card['number'] ?? '',
            'name_en' => $card['name'] ?? '',
            'keywords' => $card['keywords'] ?? '',
            'overview' => $texts['overview'],
            'love' => $texts['love'],
            'work' => $texts['work'],
            'finance' => $texts['finance'],
            'inner' => $texts['inner'],
            'reversed' => $texts['reversed'],
            'reminder' => $texts['reminder'],
        );
        foreach ($values as $key => $value) {
            update_post_meta($post_id, '_tgm_' . $key, sanitize_textarea_field((string) $value));
        }
    }
    update_option('tgm_core_import_status', 'ok');
}

function tgm_core_activate(): void {
    tgm_core_register_post_type();
    tgm_core_import_legacy_cards();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'tgm_core_activate');

function tgm_core_admin_notice(): void {
    $status = get_option('tgm_core_import_status');
    if ($status === 'legacy_missing') {
        echo '<div class="notice notice-warning"><p><strong>Tarot Gợi Mở Core:</strong> Chưa tìm thấy dữ liệu theme cũ để import 22 lá. Bạn vẫn có thể thêm lá thủ công trong mục Tarot Gợi Mở.</p></div>';
    }
}
add_action('admin_notices', 'tgm_core_admin_notice');

function tgm_core_get_cards(): array {
    $posts = get_posts(array(
        'post_type' => 'tgm_tarot_card',
        'post_status' => 'publish',
        'posts_per_page' => 30,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ));
    $cards = array();
    foreach ($posts as $post) {
        $card = array('id' => $post->ID, 'name_vi' => get_the_title($post));
        foreach (array_keys(tgm_core_meta_fields()) as $key) {
            $card[$key] = (string) get_post_meta($post->ID, '_tgm_' . $key, true);
        }
        $cards[] = $card;
    }
    return $cards;
}

function tgm_core_enqueue_assets(): void {
    if (!wp_style_is('tgm-core', 'enqueued')) {
        wp_enqueue_style('tgm-core', TGM_CORE_URL . 'assets/tgm-core.css', array(), TGM_CORE_VERSION);
    }
    if (!wp_script_is('tgm-core', 'enqueued')) {
        wp_enqueue_script('tgm-core', TGM_CORE_URL . 'assets/tgm-core.js', array(), TGM_CORE_VERSION, true);
        wp_localize_script('tgm-core', 'TarotGoiMoCore', array(
            'cards' => tgm_core_get_cards(),
            'storageKey' => 'tarot-goi-mo:last-draw:v2',
            'labels' => array(
                'copied' => 'Đã sao chép lời giải.',
                'copyFailed' => 'Không thể sao chép tự động.',
            ),
        ));
    }
}

function tgm_core_draw_shortcode(): string {
    tgm_core_enqueue_assets();
    ob_start();
    ?>
    <div class="tgm-app tgm-draw-app">
        <div class="tgm-card-stage">
            <div class="tgm-tarot-card" data-tgm="card">
                <span class="tgm-reversed-badge" data-tgm="reversed-badge" hidden>ĐẢO</span>
                <div class="tgm-card-core" data-tgm="symbol">☾</div>
            </div>
        </div>
        <div class="tgm-reading-panel">
            <div class="tgm-reading-empty" data-tgm="empty">
                <div>
                    <div class="tgm-eyebrow">Chưa rút bài</div>
                    <h2>Khi sẵn sàng, hãy bắt đầu.</h2>
                    <button class="button primary tgm-draw-btn" type="button">Rút một lá</button>
                </div>
            </div>
            <article class="tgm-reading-result" data-tgm="result" hidden>
                <div class="tgm-reading-kicker" data-tgm="orientation"></div>
                <h2 class="tgm-reading-title"><span data-tgm="number"></span> · <span data-tgm="name"></span></h2>
                <div class="tgm-reading-keywords" data-tgm="keywords"></div>
                <div class="tgm-reading-grid">
                    <div class="tgm-reading-box"><h3>Tổng quan</h3><p data-tgm="overview"></p></div>
                    <div class="tgm-reading-box"><h3>Tình cảm</h3><p data-tgm="love"></p></div>
                    <div class="tgm-reading-box"><h3>Công việc</h3><p data-tgm="work"></p></div>
                    <div class="tgm-reading-box"><h3>Tài chính</h3><p data-tgm="finance"></p></div>
                    <div class="tgm-reading-box"><h3>Nội tâm</h3><p data-tgm="inner"></p></div>
                    <div class="tgm-reading-box"><h3>Khi đảo ngược</h3><p data-tgm="reversed"></p></div>
                </div>
                <div class="tgm-reading-reminder"><strong>Lời nhắc:</strong> <span data-tgm="reminder"></span></div>
                <div class="tgm-reading-actions">
                    <button class="button primary tgm-again-btn" type="button">Rút lá khác</button>
                    <button class="button tgm-copy-btn" type="button">Sao chép lời giải</button>
                </div>
                <div class="tgm-status" data-tgm="status" aria-live="polite"></div>
            </article>
        </div>
    </div>
    <?php
    return (string) ob_get_clean();
}
add_shortcode('tarot_goi_mo_draw', 'tgm_core_draw_shortcode');

function tgm_core_arcana_shortcode(): string {
    tgm_core_enqueue_assets();
    $cards = tgm_core_get_cards();
    ob_start();
    ?>
    <div class="tgm-arcana-grid">
        <?php foreach ($cards as $card) : ?>
            <details class="tgm-arcana-item">
                <summary>
                    <span class="tgm-arcana-number"><?php echo esc_html($card['number']); ?></span>
                    <span class="tgm-arcana-title">
                        <strong><?php echo esc_html($card['name_vi']); ?></strong>
                        <span><?php echo esc_html($card['name_en']); ?> · <?php echo esc_html($card['keywords']); ?></span>
                    </span>
                </summary>
                <div class="tgm-arcana-body">
                    <p><b>Tổng quan:</b> <?php echo esc_html($card['overview']); ?></p>
                    <p><b>Tình cảm:</b> <?php echo esc_html($card['love']); ?></p>
                    <p><b>Công việc:</b> <?php echo esc_html($card['work']); ?></p>
                    <p><b>Tài chính:</b> <?php echo esc_html($card['finance']); ?></p>
                    <p><b>Nội tâm:</b> <?php echo esc_html($card['inner']); ?></p>
                    <p><b>Đảo ngược:</b> <?php echo esc_html($card['reversed']); ?></p>
                    <p><b>Lời nhắc:</b> <?php echo esc_html($card['reminder']); ?></p>
                </div>
            </details>
        <?php endforeach; ?>
    </div>
    <?php
    return (string) ob_get_clean();
}
add_shortcode('tarot_goi_mo_arcana', 'tgm_core_arcana_shortcode');

function tgm_core_combined_shortcode(): string {
    return tgm_core_draw_shortcode() . tgm_core_arcana_shortcode();
}
add_shortcode('tarot_goi_mo', 'tgm_core_combined_shortcode');
