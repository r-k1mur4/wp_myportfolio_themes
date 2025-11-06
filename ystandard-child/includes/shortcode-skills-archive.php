<?php
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
