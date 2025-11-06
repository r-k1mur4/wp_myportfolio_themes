<?php
/**
 * ACF Local JSON 保存 / 読み込み設定
 * 子テーマの /acf-json/ にまとめる
 */

// 保存先の上書き
add_filter('acf/settings/save_json', function ($path) {
  $dir = get_stylesheet_directory() . '/acf-json';
  if (! is_dir($dir)) {
    // ディレクトリが無ければ作成（パーミッションは環境に応じて）
    wp_mkdir_p($dir);
  }
  return $dir;
});

// 読み込み先の追加
add_filter('acf/settings/load_json', function ($paths) {
  // デフォルト（親/子テーマの acf-json）を残しても問題ありませんが、
  // 完全に子テーマに寄せるならコメントアウトを外して消す
  // unset($paths[0]);

  $paths[] = get_stylesheet_directory() . '/acf-json';
  return $paths;
});
