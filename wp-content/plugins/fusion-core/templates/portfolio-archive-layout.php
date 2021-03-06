<?php
/**
 * Portfolio Template.
 *
 * @package Fusion-Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php
global $wp_query;

// Set the portfolio main classes.
$portfolio_classes[] = 'fusion-portfolio';

$portfolio_layout_setting = strtolower( Avada()->settings->get( 'portfolio_archive_layout' ) );
$portfolio_layout         = explode( ' ', $portfolio_layout_setting );
$portfolio_columns        = $portfolio_layout[1];
$portfolio_layout         = 'fusion-portfolio-' . $portfolio_columns;
$portfolio_classes[]      = $portfolio_layout;

/**
 * Get the number of columns.
 */
$portfolio_columns_int = avada_get_portfolio_columns( $portfolio_columns );

// If one column text layout is used, add special class.
if ( strpos( $portfolio_layout_setting, 'one' ) && ! strpos( $portfolio_layout_setting, 'text' ) ) {
	$portfolio_classes[] = 'fusion-portfolio-one-nontext fusion-portfolio-text-floated';
}

// Add the text class, if a text layout is used.
if ( strpos( $portfolio_layout_setting, 'text' ) || strpos( $portfolio_layout_setting, 'one' ) ) {
	$portfolio_classes[] = 'fusion-portfolio-text';
}

// For text layouts add the class for boxed/unboxed.
$portfolio_text_layout = 'unboxed';
if ( strpos( $portfolio_layout_setting, 'text' ) ) {
	$portfolio_text_layout = Avada()->settings->get( 'portfolio_text_layout' );
	$portfolio_classes[]   = 'fusion-portfolio-' . $portfolio_text_layout;
}

// Set the correct image size.
$portfolio_image_size = 'portfolio-' . $portfolio_columns;

// Portfolio-four no longer exists.
if ( 'four' === $portfolio_columns ) {
	$portfolio_image_size = 'portfolio-three';
}

// Portfolio-six no longer exists.
if ( 'six' === $portfolio_columns ) {
	$portfolio_image_size = 'portfolio-five';
}

if ( 'full' === Avada()->settings->get( 'portfolio_featured_image_size' ) || 'fusion-portfolio-grid' === $portfolio_layout ) {
	$portfolio_image_size = 'full';
}

$post_featured_image_size_dimensions = avada_get_image_size_dimensions( $portfolio_image_size );

// Get the column spacing.
$column_spacing_class = $column_spacing = '';
if ( ! strpos( $portfolio_layout_setting, 'one' ) ) {
	$column_spacing_class = ' fusion-col-spacing';
	$column_spacing = ' style="padding:' . Avada()->settings->get( 'portfolio_column_spacing' ) / 2 . 'px;"';
}

// Check pagination type.
if ( 'load_more_button' === Avada()->settings->get( 'grid_pagination_type' ) ) {
	$portfolio_classes[] = 'fusion-portfolio-paging-load-more-button';
}
if ( 'Infinite Scroll' === Avada()->settings->get( 'grid_pagination_type' ) ) {
	$portfolio_classes[] = 'fusion-portfolio-paging-infinite';
}

// Get the correct ID of the archive.
$archive_id = get_queried_object_id();

$title = true;
$categories = true;

// Get title and category status.
if ( strpos( $portfolio_layout_setting, 'text' ) ) {
	$title_display = Avada()->settings->get( 'portfolio_title_display' );
	$title = ( 'all' === $title_display || 'title' === $title_display ) ? true : false;
	$categories = ( 'all' === $title_display || 'cats' === $title_display ) ? true : false;
}
?>

<div class="<?php echo esc_attr( implode( ' ', $portfolio_classes ) ); ?>">

	<?php
	/**
	 * Render category description if it is set.
	 */
	?>
	<?php if ( category_description() ) : ?>
		<div id="post-<?php echo intval( get_the_ID() ); ?>" <?php post_class( 'post' ); ?>>
			<div class="post-content">
				<?php echo category_description(); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="fusion-portfolio-wrapper" data-picturesize="<?php echo ( 'full' !== $portfolio_image_size ) ? 'fixed' : 'auto'; ?>" data-pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php if ( Avada()->settings->get( 'featured_image_placeholder' ) || has_post_thumbnail() ) : ?>

				<?php // @codingStandardsIgnoreLine ?>
				<article class="fusion-portfolio-post post-<?php echo esc_attr( get_the_ID() ); ?> <?php echo esc_attr( $column_spacing_class ); ?>"<?php echo $column_spacing; ?>>

					<?php
					/**
					 * Open portfolio-item-wrapper for text layouts.
					 */
					?>
					<?php if ( strpos( $portfolio_layout_setting, 'text' ) || strpos( $portfolio_layout_setting, 'one' ) ) : ?>
						<div class="fusion-portfolio-content-wrapper">
					<?php endif; ?>

						<?php
						/**
						 * If no featured image is present,
						 * on one column layouts render the video set in page options.
						 */
						?>
						<?php if ( ! has_post_thumbnail() && fusion_get_page_option( 'video', $post->ID ) ) : ?>
							<?php
							/**
							 * For the portfolio one column layout we need a fixed max-width.
							 * For all other layouts get the calculated max-width from the image size.
							 */
							?>
							<?php $video_max_width = ( 'fusion-portfolio-one' === $portfolio_layout && ! strpos( $portfolio_layout_setting, 'text' ) ) ? '540px' : $post_featured_image_size_dimensions['width']; ?>
							<div class="fusion-image-wrapper fusion-video" style="max-width:<?php echo esc_attr( $video_max_width ); ?>;">
								<?php // @codingStandardsIgnoreLine ?>
								<?php echo fusion_get_page_option( 'video', $post->ID ); ?>
							</div>

							<?php
							/**
							 * On every other other layout render the featured image.
							 */
							?>
						<?php else : ?>
							<?php
							if ( 'full' === $portfolio_image_size ) {
								Avada()->images->set_grid_image_meta( array(
									'layout' => 'portfolio_full',
									'columns' => $portfolio_columns_int,
									'gutter_width' => Avada()->settings->get( 'portfolio_column_spacing' ),
								) );
							}
							// @codingStandardsIgnoreLine
							echo fusion_render_first_featured_image_markup( $post->ID, $portfolio_image_size, get_permalink( $post->ID ), true );
							Avada()->images->set_grid_image_meta( array() );
							?>

						<?php endif; ?>

						<?php
						/**
						 * If we don't have a text layout and not a one column layout,
						 * then only render rich snippets.
						 */
						?>
						<?php if ( ! strpos( $portfolio_layout_setting, 'text' ) && ! strpos( $portfolio_layout_setting, 'one' ) ) : ?>
							<?php
							// @codingStandardsIgnoreLine
							echo fusion_render_rich_snippets_for_pages(); ?>
							<?php
							/**
							 * If we have a text layout render its contents.
							 */
							?>
						<?php else : ?>
							<div class="fusion-portfolio-content">
								<?php
								/**
								 * Render the post title.
								 */
								?>
								<?php
								if ( $title ) {
									// @codingStandardsIgnoreLine
									echo avada_render_post_title( $post->ID );
								}
								?>
								<?php
								/**
								 * Render the post categories.
								 */
								?>
								<?php
								if ( $categories ) {
									echo '<h4>' . get_the_term_list( $post->ID, 'portfolio_category', '', ', ', '' ) . '</h4>';
								}
								?>
								<?php // @codingStandardsIgnoreLine ?>
								<?php echo fusion_render_rich_snippets_for_pages( false ); ?>

								<?php
								/**
								 * For boxed layouts add a content separator if there is a post content and either categories or title is used.
								 */
								?>
								<?php if ( 'boxed' === $portfolio_text_layout && fusion_get_portfolio_excerpt_length( $current_page_id ) !== '0' &&
									( $title || $categories ) ) : ?>
									<div class="fusion-content-sep"></div>
								<?php endif; ?>

								<div class="fusion-post-content">
									<?php
									/**
									 * The avada_portfolio_post_content hook.
									 *
									 * @hooked avada_get_portfolio_content - 10 (outputs the post content).
									 */
									do_action( 'avada_portfolio_post_content', $archive_id );
									?>

									<?php
									/**
									 * On one column layouts render the "Learn More" and "View Project" buttons.
									 */
									?>
									<?php if ( strpos( $portfolio_layout_setting, 'one' ) ) : ?>
										<div class="fusion-portfolio-buttons">
											<?php
											/**
											 * Render "Learn More" button.
											 */
											?>
											<a href="<?php echo esc_url_raw( get_permalink( $post->ID ) ); ?>" class="fusion-button fusion-button-small fusion-button-default fusion-button-<?php echo esc_attr( strtolower( Avada()->settings->get( 'button_shape' ) ) ); ?> fusion-button-<?php echo esc_attr( strtolower( Avada()->settings->get( 'button_type' ) ) ); ?>">
												<?php esc_html_e( 'Learn More', 'fusion-core' ); ?>
											</a>
											<?php
											/**
											 * Render the "View Project" button only if a project url was set.
											 */
											?>
											<?php if ( fusion_get_page_option( 'project_url', $post->ID ) ) : ?>
												<a href="<?php echo esc_url_raw( fusion_get_page_option( 'project_url', $post->ID ) ); ?>" class="fusion-button fusion-button-small fusion-button-default fusion-button-<?php echo esc_attr( strtolower( Avada()->settings->get( 'button_shape' ) ) ); ?> fusion-button-<?php echo esc_attr( strtolower( Avada()->settings->get( 'button_type' ) ) ); ?>">
													<?php esc_html_e( ' View Project', 'fusion-core' ); ?>
												</a>
											<?php endif; ?>
										</div>
									<?php endif; ?>

								</div><!-- end post-content -->

							</div><!-- end portfolio-content -->

						<?php endif; // End template check. ?>

					<?php
					/**
					 * Close portfolio-item-wrapper for text layouts.
					 */
					?>
					<?php if ( strpos( $portfolio_layout_setting, 'text' ) || strpos( $portfolio_layout_setting, 'one' ) ) : ?>
						</div>

						<?php
						/**
						 * On unboxed one column layouts render a separator at the bottom of the post.
						 */
						?>
						<?php if ( strpos( $portfolio_layout_setting, 'one' ) && 'unboxed' === $portfolio_text_layout ) : ?>
							<div class="fusion-clearfix"></div>
							<div class="fusion-separator sep-double"></div>
						<?php endif; ?>
					<?php endif; ?>

				</article><!-- end portfolio-post -->

			<?php endif; // Placeholders or featured image. ?>
		<?php endwhile; ?>

	</div><!-- end portfolio-wrapper -->

	<?php
	/**
	 * Render the pagination.
	 */
	?>
	<?php fusion_pagination( '', 2 ); ?>
	<?php
	/**
	 * If infinite scroll with "load more" button is used.
	 */
	?>
	<?php if ( 'load_more_button' === Avada()->settings->get( 'grid_pagination_type' ) ) : ?>
		<div class="fusion-load-more-button fusion-portfolio-button fusion-clearfix">
			<?php echo esc_attr( apply_filters( 'avada_load_more_posts_name', esc_html__( 'Load More Posts', 'fusion-core' ) ) ); ?>
		</div>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>
</div><!-- end fusion-portfolio -->
