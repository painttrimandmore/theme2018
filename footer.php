<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package PaintTrimAndMoreTheme2018
 * @since FoundationPress 1.0.0
 */
?>

</div><!-- Close container -->
<div class="footer-container">
	<footer class="footer">
		
		<div class="footer-content">

			<div class="row">
				<div class="small-12 columns copyright text-right">
					<span class="text">
						<?php echo sprintf( __( '&copy; %s %s', 'paint-trim-and-more-theme' ), date( 'Y' ), get_bloginfo( 'name' ) ); ?>
						<br />
						<?php _e( 'Powered by WordPress, Built by <a href="https://realbigmarketing.com/" class="footer-rbm-link" target="_blank">Real Big Marketing</a>', 'paint-trim-and-more-theme' ); ?>
					</span>
				</div>
			</div>
			
		</div>

	</footer>
</div>

</div><!-- Close off-canvas content -->

<?php wp_footer(); ?>
</body>
</html>