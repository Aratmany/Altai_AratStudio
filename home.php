<?php
get_header();
$sidebar_configs = temp_get_text_layout_configs();

temp_render_breadcrumbs();
?>
<section id="main-container" class="main-content home-page-default <?php echo apply_filters('temp_text_content_class', 'container');?> inner">
	<?php temp_before_content( $sidebar_configs ); ?>
	<div class="row">
		<?php temp_display_sidebar_left( $sidebar_configs ); ?>

		<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
			<div id="main" class="site-main layout-text" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header hidden">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header>

				<?php
				$layout = temp_get_config( 'text_display_mode', 'list' );
				get_template_part( 'template-posts/layouts/'.$layout );

		
				temp_paging_nav();

	
			else :
				get_template_part( 'template-posts/content', 'none' );

			endif;
			?>

			</div><!-- .site-main -->
		</div><!-- .content-area -->
		
		<?php temp_display_sidebar_right( $sidebar_configs ); ?>
		
	</div>
</section>
<?php get_footer(); ?>