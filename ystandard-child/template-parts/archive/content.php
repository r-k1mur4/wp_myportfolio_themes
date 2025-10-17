<?php

/**
 * 記事一覧テンプレート
 *
 * @package ystandard
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

defined('ABSPATH') || die();
?>
<main id="main" class="archive__main site-main">
	<?php do_action('ys_site_main_prepend'); ?>
	<!-- 投稿一覧（制作実績）ページの場合、ページタイトルを表示 -->
	<?php if (is_home()) : ?>
		<h1 class="post-index__title"><?php the_archive_title(); ?></h1>
	<?php endif; ?>
	<?php
	/**
	 * アーカイブヘッダーの読み込み
	 */
	ys_get_template_part('template-parts/archive/header');
	?>
<?php
// スキルアーカイブページの場合、固定ページ「skills」の本文を表示
if ( is_post_type_archive("skills") ) {
    $page = get_page_by_path('skills');
    if ( $page ) {
        echo '<div class="skills-intro">';
        echo apply_filters('the_content', $page->post_content);
        echo '</div>';
    }
}
?>

	<div class="archive__container is-<?php echo ys_get_archive_type(); ?>">
		<?php
		while (have_posts()) :
			the_post();
			do_action('ys_archive_before_content');
			// カスタム投稿（スキル）一覧ページの場合
			if (is_post_type_archive("skills")) {
				ys_get_template_part(
					'template-parts/archive/custom-post-details',
					ys_get_archive_type()
				);
			} else {
				ys_get_template_part(
					'template-parts/archive/details',
					ys_get_archive_type()
				);
			}
			do_action('ys_archive_after_content');
		endwhile;
		?>
	</div>
	<?php
	/**
	 * ページネーション
	 */
	ys_get_template_part('template-parts/parts/pagination');
	?>
	<?php do_action('ys_site_main_append'); ?>
</main>
