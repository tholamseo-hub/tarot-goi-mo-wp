<?php get_header(); ?>
<section class="section"><div class="wrap">
  <div class="section-head"><div class="eyebrow">Tarot Gợi Mở</div><h1><?php bloginfo('name'); ?></h1></div>
  <div class="post-list">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article <?php post_class('post-card'); ?>><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><div><?php the_excerpt(); ?></div></article>
    <?php endwhile; else : ?><article class="post-card"><p>Chưa có bài viết.</p></article><?php endif; ?>
  </div>
</div></section>
<?php get_footer(); ?>
