<?php
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
