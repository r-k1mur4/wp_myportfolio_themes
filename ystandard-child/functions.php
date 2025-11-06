<?php


$inc = get_stylesheet_directory() . '/includes';

// 読み込み（必要に応じて順序は調整）

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// アセット読み込み（CSS/JS）
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
require_once $inc . '/enqueue-styles.php';

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// カスタマイザー（管理画面設定）
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
require_once $inc . '/customizer-hero.php';
require_once $inc . '/editor-color-palette.php';

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// クエリ・ループ調整
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
require_once $inc . '/query-pre-get-posts.php';

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// フィルター・フック
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
require_once $inc . '/filter-header-thumbnail.php';


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// ショートコード
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
require_once $inc . '/shortcode-front-latest-posts.php';
require_once $inc . '/shortcode-skills-archive.php';
require_once $inc . '/shortcode-skill-grid.php';
require_once $inc . '/shortcode-tool-type-list.php';

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// プラグイン連携（ACF等）
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
require_once $inc . '/acf-json.php';

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// その他・システム
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
require_once $inc . '/updates-email.php';
