<?php

/**
 * フロントページテンプレート
 *
 * @package ystandard
 * @author yosiakatsuki
 * @license GPL-2.0+
 */

?>

<!-- メインビジュアル -->
<div class="hero-main">
    <?php
    // カスタマイザーで設定した画像を取得
    $hero_image = get_theme_mod('hero_image');

    // 画像が設定されている場合は表示
    if ($hero_image) {
        echo '<img src="' . esc_url($hero_image) . '" alt="メインビジュアル">';
    }
    ?>
</div>

<?php
/**
 * フロントページテンプレート読み込み
 */
ys_get_template_part(ys_get_front_page_template());
