<?php

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
