<?php
/**
 * Frontpage Template
 *
 * @package PaintTrimAndMoreTheme2018
 */

global $post;

get_header(); 

while ( have_posts() ) : the_post();

	get_template_part( 'template-parts/featured-image' );

endwhile;

?>

<div class="main-content">
	
	<div class="main-wrap full-width">
		
		<div class="row expanded">
			
			<div class="small-12 medium-6 columns">
				<?php the_content(); ?>
			</div>

			<div class="small-12 medium-6 columns">
				
				<div class="portfolio-loop">

				<?php 

					$portfolio_loop = new WP_Query( array(
						'post_type' => 'portfolio',
						'posts_per_page' => -1,
						'orderby' => 'menu_order',
						'order' => 'ASC',
					) );

					$image_size = 'medium';
					$columns = 2;

					// Modified [gallery] shortcode
					if ( $portfolio_loop->have_posts() ) : ?>

						<h2><?php _e( 'Our Portfolio', 'paint-trim-and-more-theme' ); ?></h2>

						<div id="portfolio-gallery" class="gallery gallery-columns-<?php echo $columns; ?> gallery-size-<?php echo $image_size; ?> row small-up-2 medium-up-<?php echo $columns; ?>">

						<?php while ( $portfolio_loop->have_posts() ) : $portfolio_loop->the_post(); ?>

							<?php if ( ! has_post_thumbnail() ) continue; ?>

							<div class="column column-block">

								<figure class="gallery-item">

									<?php 

										$attachment_id = get_post_thumbnail_id();
										$image_meta = wp_get_attachment_metadata( $attachment_id );

										$orientation = '';
										if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
											$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
										}

									?>

									<div class='gallery-icon <?php echo $orientation; ?>'>
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
											<?php the_post_thumbnail( $image_size, array(
												'aria-describedby' => 'portfolio-gallery-' . get_the_ID()
											) ); ?>
										</a>
									</div>

									<figcaption class="wp-caption-text gallery-caption" id="portfolio-gallery-<?php echo get_the_ID(); ?>">
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
											<?php echo wptexturize( get_the_title() ); ?>
										</a>
									</figcaption>

								</figure>

							</div>

						<?php endwhile; ?>

						</div>

					<?php endif; ?>
					
				</div>

				</div>
			
			</div>

		</div>
		
	</div>
	
</div>

<?php 

get_footer();