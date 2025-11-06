<?php
/**
 * カスタマイザーにメインビジュアル画像の設定を追加
 */
function my_customize_register($wp_customize)
{
  // セクションを追加(設定をグループ化するため)
  $wp_customize->add_section('hero_section', array(
    'title' => 'メインビジュアル設定',
    'priority' => 30,
  ));

  // 画像設定を追加
  $wp_customize->add_setting('hero_image', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw', // URLを安全に処理
  ));

  // 画像アップロードコントロールを追加
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
    'label' => 'メインビジュアル画像',
    'section' => 'hero_section',
    'settings' => 'hero_image',
    'description' => '推奨サイズ: 1920×1080px (16:9)',
  )));
}
add_action('customize_register', 'my_customize_register');
