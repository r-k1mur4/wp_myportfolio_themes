<?php
// スキルをレベル降順でグリッド表示（ACFフィールド対応・表示順明示）
// SKILL一覧をレベル降順で表示（ACF対応 / アイコン＋タイトル横並び）
add_shortcode('skill_grid', function ($atts) {
  $a = shortcode_atts(['limit' => 10], $atts);

  $q = new WP_Query([
    'post_type'           => 'skill',
    'posts_per_page'      => (int) $a['limit'],
    'meta_key'            => 'skill_level',
    'orderby'             => 'meta_value_num',
    'order'               => 'DESC',
    'no_found_rows'       => true,
    'ignore_sticky_posts' => true,
  ]);

  ob_start();

  if ($q->have_posts()) {
    echo '<ul class="skill-grid" role="list">';
    while ($q->have_posts()) {
      $q->the_post();

      if (function_exists('get_field')) {
        $level = get_field('skill_level');
        $note  = get_field('skill_note');
      } else {
        $level = get_post_meta(get_the_ID(), 'skill_level', true);
        $note  = get_post_meta(get_the_ID(), 'skill_note', true);
      }

      $level = is_numeric($level) ? (int)$level : 0;
      if ($level < 0)  $level = 0;
      if ($level > 10) $level = 10;

      echo '<li class="skill-card"><article class="skill">';
      echo '<header class="skill__header">';
      echo '<span class="skill__icon">';
      if (has_post_thumbnail()) {
        the_post_thumbnail('thumbnail', [
          'alt'   => esc_attr(get_the_title()),
          'class' => 'skill__icon-img'
        ]);
      }
      echo '</span>';
      echo '<h3 class="skill__title">' . esc_html(get_the_title()) . '</h3>';
      echo '<span class="skill__level" aria-label="Skill level">' . esc_html($level) . '/10</span>';
      echo '</header>';

      if (!empty($note)) {
        echo '<p class="skill__note">' . esc_html($note) . '</p>';
      }

      echo '</article></li>';
    }
    echo '</ul>';
    wp_reset_postdata();
  }

  return ob_get_clean();
});
