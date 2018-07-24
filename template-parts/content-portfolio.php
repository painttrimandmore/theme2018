<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package PaintTrimAndMoreTheme2018
 * @since FoundationPress 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
	<?php if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else : ?>
				
			<div class="media-object">
				<div class="media-object-section">
					<div class="thumbnail">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
							<?php the_post_thumbnail(); ?>
						</a>
					</div>
				</div>
				<div class="media-object-section">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
						<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
					</a>
				</div>
			</div>
		
		<?php endif;
	?>
	</header>
	<div class="entry-content">
		<?php edit_post_link( __( '(Edit)', 'paint-trim-and-more-theme' ), '<span class="edit-link">', '</span>' ); ?>
		<?php if ( is_single() ) {
			the_content();
		} ?>
	</div>
	<footer>
		<?php
			wp_link_pages(
				array(
					'before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'paint-trim-and-more-theme' ),
					'after'  => '</p></nav>',
				)
			);
		?>
		<?php $tag = get_the_tags(); if ( $tag ) { ?><p><?php the_tags(); ?></p><?php } ?>
	</footer>
</article>
