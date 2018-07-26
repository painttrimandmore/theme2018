<?php
// If a featured image is set, insert into layout and use Interchange
// to select the optimal image size per named media query.
if ( has_post_thumbnail( $post->ID ) ) : ?>
	<header class="featured-hero" role="banner" data-interchange="[<?php echo the_post_thumbnail_url('featured-medium'); ?>, small], [<?php echo the_post_thumbnail_url('featured-medium'); ?>, medium], [<?php echo the_post_thumbnail_url('featured-large'); ?>, large], [<?php echo the_post_thumbnail_url('featured-xlarge'); ?>, xlarge]">
		
		<?php if ( is_front_page() ) : ?>
		
			<div class="main-wrap">

				<div class="row tagline text-center">
					<div class="small-8 small-push-2 medium-12 medium-push-0 columns">
						
						<h1 class="page-title">

							<?php echo get_bloginfo( 'description' ); ?>

						</h1>

					</div>
				</div>

			</div>
		
			<div class="hero-logos show-for-medium">
				
				<div class="row logo-image-container">
					<img src="<?php echo THEME_URL . '/dist/assets/images/ppg.jpg'; ?>" alt="hire-it-done" />
				</div>
				<div class="row logo-image-container">
					<img src="<?php echo THEME_URL . '/dist/assets/images/hire-it-done.png'; ?>" alt="hire-it-done" />
				</div>

			</div>
		
		<?php endif; ?>
		
	</header>

	<?php if ( is_front_page() ) : ?>

		<div class="hero-logos show-for-small-only">
				
			<div class="row logo-image-container">
				<img src="<?php echo THEME_URL . '/dist/assets/images/ppg.jpg'; ?>" alt="hire-it-done" />
			</div>
			<div class="row logo-image-container">
				<img src="<?php echo THEME_URL . '/dist/assets/images/hire-it-done.png'; ?>" alt="hire-it-done" />
			</div>

		</div>

	<?php endif; ?>

<?php endif;
