<?php
/**
 * 投稿タイプ「skills」の一覧ページにアイキャッチ画像を表示する.
 */
add_filter(
  'ys_get_header_thumbnail',
  function ($thumbnail) {
    if (is_post_type_archive('skills')) {
      $img_url = get_stylesheet_directory_uri() . '/assets/img/coder01.png';
      return '<img src="' . esc_url($img_url) . '" alt="コーダー" />';
    }
    return null;
  }
);
