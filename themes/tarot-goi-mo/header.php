<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
  <div class="wrap nav">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>"><span class="brand-mark">✦</span>Tarot Gợi Mở</a>
    <nav class="nav-links" aria-label="<?php esc_attr_e('Điều hướng chính', 'tarot-goi-mo'); ?>">
      <a href="#rut-bai">Rút bài</a><a href="#22-la">22 lá Ẩn Chính</a><a href="#luu-y">Lưu ý</a>
    </nav>
  </div>
</header>
<main id="main-content">
