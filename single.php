<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package PaintTrimAndMoreTheme2018
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>

<div class="main-wrap">
	<main class="main-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
			<?php if ( get_post_type() !== 'portfolio' ) {
				the_post_navigation();
				comments_template(); 
			} ?>
		<?php endwhile;?>
	</main>
<?php
	
	if ( get_post_type() !== 'portfolio' ) {
		get_sidebar(); 
	}
	
?>
</div>
<?php get_footer();
