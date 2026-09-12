<?php
get_header();
$cards = tarot_goi_mo_cards();
?>
<section class="hero">
  <div class="wrap">
    <div class="eyebrow">Ánh sáng nội tâm</div>
    <h1>Không tìm lời phán.<br>Tìm một góc nhìn mới.</h1>
    <p class="lead">Rút một lá trong 22 lá Ẩn Chính để mở ra câu hỏi, cảm xúc và lựa chọn đáng suy ngẫm. Mỗi lời giải được viết theo hướng gợi mở, không khẳng định chắc chắn tương lai.</p>
    <div class="hero-actions"><a class="btn btn-primary" href="#rut-bai">Rút một lá</a><a class="btn" href="#22-la">Khám phá 22 lá</a></div>
  </div>
</section>
<section class="section" id="rut-bai">
  <div class="wrap">
    <div class="section-head"><div class="eyebrow">Một lá cho hiện tại</div><h2>Rút bài Tarot Gợi Mở</h2><p>Hít một nhịp chậm, giữ một câu hỏi trong đầu nếu bạn muốn, rồi rút bài. Lá có thể xuất hiện ở chiều xuôi hoặc đảo ngược.</p></div>
    <div class="draw-shell">
      <div class="card-stage"><div class="tarot-card" id="drawn-card" aria-live="polite"><div class="card-back-core" id="card-symbol">☾</div></div></div>
      <div class="reading-panel">
        <div class="reading-empty" id="reading-empty"><div><div class="eyebrow">Chưa rút bài</div><h2>Khi sẵn sàng, hãy bắt đầu.</h2><button class="btn btn-primary" id="draw-card-btn" type="button">Rút một lá</button><div class="status" id="draw-status"></div></div></div>
        <article class="reading-result" id="reading-result" hidden>
          <div class="reading-kicker" id="reading-orientation"></div>
          <h2 class="reading-title"><span id="reading-number"></span> · <span id="reading-name"></span></h2>
          <div class="reading-keywords" id="reading-keywords"></div>
          <div class="reading-grid">
            <div class="reading-box"><h3>Tổng quan</h3><p id="reading-overview"></p></div>
            <div class="reading-box"><h3>Tình cảm</h3><p id="reading-love"></p></div>
            <div class="reading-box"><h3>Công việc</h3><p id="reading-work"></p></div>
            <div class="reading-box"><h3>Tài chính</h3><p id="reading-finance"></p></div>
            <div class="reading-box"><h3>Nội tâm</h3><p id="reading-inner"></p></div>
            <div class="reading-box"><h3>Khi đảo ngược</h3><p id="reading-reversed"></p></div>
          </div>
          <div class="reading-reminder"><strong>Lời nhắc:</strong> <span id="reading-reminder"></span></div>
          <div class="reading-actions"><button class="btn btn-primary" id="draw-again-btn" type="button">Rút lá khác</button><button class="btn" id="copy-reading-btn" type="button">Sao chép lời giải</button></div>
          <div class="status" id="result-status" aria-live="polite"></div>
        </article>
      </div>
    </div>
  </div>
</section>
<section class="section" id="22-la">
  <div class="wrap">
    <div class="section-head"><div class="eyebrow">Major Arcana</div><h2>22 lá Ẩn Chính</h2><p>Mở từng lá để xem ý nghĩa theo Tổng quan, Tình cảm, Công việc, Tài chính, Nội tâm, chiều đảo ngược và một lời nhắc ngắn.</p></div>
    <div class="arcana-grid">
      <?php foreach ($cards as $card) : ?>
      <details class="arcana-item"><summary><span class="arcana-number"><?php echo esc_html($card['number']); ?></span><span class="arcana-title"><strong><?php echo esc_html($card['name_vi']); ?></strong><span><?php echo esc_html($card['name']); ?> · <?php echo esc_html($card['keywords']); ?></span></span></summary><div class="arcana-body"><p><b>Tổng quan:</b> <?php echo esc_html($card['overview']); ?></p><p><b>Tình cảm:</b> <?php echo esc_html($card['love']); ?></p><p><b>Công việc:</b> <?php echo esc_html($card['work']); ?></p><p><b>Tài chính:</b> <?php echo esc_html($card['finance']); ?></p><p><b>Nội tâm:</b> <?php echo esc_html($card['inner']); ?></p><p><b>Đảo ngược:</b> <?php echo esc_html($card['reversed']); ?></p><p><b>Lời nhắc:</b> <?php echo esc_html($card['reminder']); ?></p></div></details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section" id="luu-y"><div class="wrap"><div class="note">Tarot Gợi Mở được thiết kế để hỗ trợ tự phản chiếu. Với các quyết định quan trọng về sức khỏe, pháp lý, tài chính hoặc an toàn, hãy dựa trên thông tin đáng tin cậy và người có chuyên môn phù hợp.</div></div></section>
<?php get_footer(); ?>
