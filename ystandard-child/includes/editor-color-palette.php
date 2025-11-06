<?php
/* カラーパレットの色追加 */
function rk_add_my_editor_color_palette()
{
  $palette = get_theme_support('editor-color-palette');
  if (! empty($palette)) {
    $palette = array_merge($palette[0], array(
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
    ));
    add_theme_support('editor-color-palette', $palette);
  }
}

add_action(
  'after_setup_theme',
  'rk_add_my_editor_color_palette',
  11
);
