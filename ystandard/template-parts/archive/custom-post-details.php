<?php
/**
 * 記事一覧テンプレート(カードタイプ デフォルト)
 *
 * @package ystandard
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

defined( 'ABSPATH' ) || die();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( ys_get_archive_item_class() ); ?>>
	<div class="archive__detail">
		<?php do_action( 'ys_archive_detail_prepend', '' ); ?>
		<div class="archive__text">
			<div class="archive__title-row">
				<?php
				// アイキャッチ画像（スキルアイコン）を小さく表示
				if ( has_post_thumbnail() ) {
					echo '<span class="skill-icon">';
					the_post_thumbnail('thumbnail', [
						'class' => '',
						'alt'   => get_the_title(),
					]);
					echo '</span>';
				}
				the_title(
					'<h2 class="archive__title skill-title"><a class="archive__link" href="' . get_the_permalink() . '" style="pointer-events: none;">',
					'</a></h2>'
				);
				?>
			</div>
			<?php ys_the_archive_meta(); ?>

			<?php
			// スキルレベル
			$skill_level = get_field('skill_level');
			if ($skill_level) {
				$level = intval($skill_level);
				$max = 10;
				$percent = min(100, max(0, ($level / $max) * 100));
				echo '<div class="skill-level-row">';
				// ゲージ
				echo '<span class="skill-level-gauge"><span class="skill-level-bar" style="width:' . esc_attr($percent) . '%"></span></span>';
				// テキスト
				echo '<span class="skill-level-label">レベル: ' . esc_html($level) . ' / ' . $max . '</span>';
				echo '</div>';
			}
			// 備考
			$skill_note = get_field('skill_note');
			if ($skill_note) {
				echo '<div class="skill-note">' . esc_html($skill_note) . '</div>';
			}

			ys_the_archive_description();
			?>
		</div>
		<?php do_action( 'ys_archive_detail_append', '' ); ?>
	</div>
</article>
