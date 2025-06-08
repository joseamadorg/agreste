<?php
/**
 * Custom Comment Area Modification
 * @package atreves
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'atreves_comment_modification' ) ) {
	function atreves_comment_modification($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		$comment_class = empty( $args['has_children'] ) ? '' : 'parent';
		?>

		<<?php echo esc_attr($tag); ?> <?php comment_class('item ' . $comment_class .' ' ); ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="">
		<?php endif; ?>

		<?php if ($comment->comment_type != 'trackback' && $comment->comment_type != 'pingback') { ?>
		<div class="single-comment-wrap comments-item">
		<?php }else{ ?>
			<div class="single-comment-wrap comments-item yes-ping">
		<?php } ?>
		<?php if ($comment->comment_type != 'trackback' && $comment->comment_type != 'pingback') { ?>
			<div class="thumb comments-img">
				<?php
				if ( $args['avatar_size'] != 0 ) {
					echo get_avatar( $comment, 80 );
				}
				?>
			</div>
			<?php } ?>
			<div class="content comments-text">
				<h6><?php printf( '%s', get_comment_author() ); ?></h6>
				<span><?php printf('<span class="comments-meta">%s</span>',get_comment_date());?></span>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php echo esc_html__( 'Your comment is awaiting moderation.', 'atreves' ); ?></em>
				<?php endif; ?>
				<div class="comment-content">
					<?php comment_text(); ?>
				</div>
				<div class="reply">
					<?php
					comment_reply_link( array_merge( $args, array(
						'reply_text' => '<i class="fa fa-reply"></i>',
						'before' => '',
						'class'  => 'comments-reply',
						'depth' => $depth,
						'max_depth' => $args['max_depth']
					) ) );
					?>
				</div>
			</div>
		</div><!-- //. single comment wrap -->

		<?php if ( 'div' != $args['style'] ) : ?>
			</div>
		<?php endif;
	}
}