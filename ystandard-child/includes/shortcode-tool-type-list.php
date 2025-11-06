<?php
/*
ツールタイプ一覧の表示
*/

add_shortcode('tool_type_list', function($atts){
  $a = shortcode_atts([
    'orderby'     => 'name',
    'order'       => 'ASC',
    'hide_empty'  => '1',
    'order_slugs' => '',
  ], $atts, 'tool_type_list');

  $hide_empty = (bool) intval($a['hide_empty']);

  if ($a['orderby'] === 'custom' && !empty($a['order_slugs'])) {
    $slugs = array_filter(array_map('trim', explode(',', $a['order_slugs'])));
    $ids   = [];
    foreach ($slugs as $slug) {
      $t = get_term_by('slug', $slug, 'tool_type');
      if ($t && ($hide_empty ? ($t->count > 0) : true)) {
        $ids[] = $t->term_id;
      }
    }
    $terms_specified = get_terms([
      'taxonomy'   => 'tool_type',
      'include'    => $ids,
      'orderby'    => 'include',
      'hide_empty' => $hide_empty,
    ]);

    $terms_rest = get_terms([
      'taxonomy'   => 'tool_type',
      'exclude'    => $ids,
      'hide_empty' => $hide_empty,
      'orderby'    => 'name',
      'order'      => 'ASC',
    ]);

    $terms = array_merge(
      is_wp_error($terms_specified) ? [] : $terms_specified,
      is_wp_error($terms_rest) ? [] : $terms_rest
    );

  } else {
    $terms = get_terms([
      'taxonomy'   => 'tool_type',
      'hide_empty' => $hide_empty,
      'orderby'    => $a['orderby'],
      'order'      => $a['order'],
    ]);
  }

  if (is_wp_error($terms) || empty($terms)) return '';

  ob_start();
  echo '<section class="tool-type-groups">';
  foreach ($terms as $term) {
    $icon_html = '';
    if (function_exists('get_field')) {
      $icon_id     = get_field('tool_type_icon', 'tool_type_' . $term->term_id);
      $icon_preset = get_field('tool_type_icon_preset', 'tool_type_' . $term->term_id);
      if ($icon_id) {
        $icon_html = wp_get_attachment_image($icon_id, 'thumbnail', false, ['class'=>'tool-type__icon','alt'=>esc_attr($term->name)]);
      } else {
        $emoji_map = ['design'=>'🎨','coding'=>'💻','cms'=>'🧩','communication'=>'💬','analytics'=>'📊','default'=>'🛠️'];
        $emoji = isset($emoji_map[$icon_preset]) ? $emoji_map[$icon_preset] : $emoji_map['default'];
        $icon_html = '<span class="tool-type__icon tool-type__icon--preset" aria-hidden="true">'.esc_html($emoji).'</span>';
      }
    }

    $q = new WP_Query([
      'post_type'      => 'tool',
      'posts_per_page' => -1,
      'tax_query'      => [[
        'taxonomy' => 'tool_type',
        'field'    => 'term_id',
        'terms'    => $term->term_id,
      ]],
      'orderby'        => 'title',
      'order'          => 'ASC',
      'no_found_rows'  => true,
      'fields'         => 'ids',
    ]);
    if ($q->have_posts()) {
      $names = array_map(fn($pid)=>get_the_title($pid), $q->posts);
      $list_text = esc_html(implode(', ', $names));
      echo '<div class="tool-type-row">';
        echo $icon_html;
        echo '<div class="tool-type__body">';
          echo '<div class="tool-type__line">';
            echo '<span class="tool-type__name">'.esc_html($term->name).'</span>';
            echo '<span class="tool-type__sep"> ： </span>';
            echo '<span class="tool-type__tools">'.$list_text.'</span>';
          echo '</div>';
          if (function_exists('get_field')) {
            $desc = get_field('tool_type_desc', 'tool_type_' . $term->term_id);
            if ($desc) echo '<p class="tool-type__desc">'.esc_html($desc).'</p>';
          }
        echo '</div>';
      echo '</div>';
    }
    wp_reset_postdata();
  }
  echo '</section>';
  return ob_get_clean();
});
