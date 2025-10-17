<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
  wp_enqueue_style(
    'child-style',
    get_stylesheet_directory_uri() . '/style.css',
    array('parent-style')
  );
}


/**
 * 最新の投稿3件を表示するショートコード
 */
function yst_front_latest_posts_shortcode()
{
  ob_start();
?>
  <section class="front-latest-posts">
    <h2 class="wp-block-heading">制作実績</h2>
    <ul class="archive__container is-<?php echo esc_attr(ys_get_archive_type()); ?>">
      <?php
      $args = [
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
      ];
      $latest_posts = new WP_Query($args);
      if ($latest_posts->have_posts()) :
        while ($latest_posts->have_posts()) : $latest_posts->the_post();
          ys_get_template_part(
            'template-parts/archive/details',
            ys_get_archive_type()
          );
        endwhile;
        wp_reset_postdata();
      else :
      ?>
        <li>投稿がありません。</li>
      <?php endif; ?>
    </ul>
  </section>
<?php
  return ob_get_clean();
}
add_shortcode('front_latest_posts', 'yst_front_latest_posts_shortcode');


/**
 * スキル一覧を表示するショートコード（導線ボタンなし）
 */
function yst_skills_archive_shortcode( $atts ) {
    ob_start();

    $args = [
        'post_type'      => 'skills',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ];
    $skills_query = new WP_Query( $args );

    if ( $skills_query->have_posts() ) {
        echo '<div class="skills-archive-shortcode">';
        echo '<h2 class="skills-archive-title wp-block-heading">スキル一覧</h2>';
        echo '<div class="archive__container is-card">';
        while ( $skills_query->have_posts() ) {
            $skills_query->the_post();
            ys_get_template_part( 'template-parts/archive/custom-post-details', 'skills' );
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>スキルがありません。</p>';
    }
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode( 'skills_archive', 'yst_skills_archive_shortcode' );


/**
 *カスタム投稿一覧ページのみ表示件数を変更
 */
function my_preget_posts($query)
{
  if (is_admin() || ! $query->is_main_query()) {
    return;
  }
  if ($query->is_post_type_archive('skills')) {
    $query->set('posts_per_page', 100);
    // $query->set('posts_per_page', 設定したい最大表示件数)
    return;
  }
}
add_action('pre_get_posts', 'my_preget_posts');

/**
 * 投稿タイプ「skills」の一覧ページにアイキャッチ画像を表示する.
 */
add_filter(
  'ys_get_header_thumbnail',
  function ($thumbnail) {
    // カスタム投稿タイプのアーカイブページの場合に画像(img)タグを返す.
    if (is_post_type_archive('skills')) {
      $img_url = get_stylesheet_directory_uri() . '/assets/img/coder01.png';
      return '<img src="' . esc_url($img_url) . '" alt="コーダー" />';
    }
    // 変更しない場合はnullを返す.
    return null;
  }
);




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

      // --- ACF優先 + フォールバック ---
      if (function_exists('get_field')) {
        $level = get_field('skill_level');
        $note  = get_field('skill_note');
      } else {
        $level = get_post_meta(get_the_ID(), 'skill_level', true);
        $note  = get_post_meta(get_the_ID(), 'skill_note', true);
      }

      // 正規化
      $level = is_numeric($level) ? (int)$level : 0;
      if ($level < 0)  $level = 0;
      if ($level > 10) $level = 10;

      echo '<li class="skill-card"><article class="skill">';

      // 1行目：アイコン（小）＋タイトル（横並び）＋レベル（右寄せ）
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

      // 2行目：備考（あれば）
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



/* カラーパレットの色追加 */
function rk_add_my_editor_color_palette() {
    $palette = get_theme_support( 'editor-color-palette' );
    if ( ! empty( $palette ) ) {
        $palette = array_merge( $palette[0], array(
            array(
                'name'  => 'Color1',
                'slug'  => 'color1',
                'color' => '#958a8a',
            ),
            array(
                'name'  => 'Color2',
                'slug'  => 'color2',
                'color' => '#616371',
            ),
        ) );
        add_theme_support( 'editor-color-palette', $palette );
    }
}

add_action( 'after_setup_theme',
		   'rk_add_my_editor_color_palette', 11 );
