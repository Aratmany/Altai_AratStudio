<?php
/**

 */

get_header();
$sidebar_configs = temp_get_page_layout_configs();

temp_render_breadcrumbs();

?>

<section id="main-container" class="wrapper-main-page <?php echo apply_filters('temp_page_content_class', 'container');?> inner">
	<?php temp_before_content( $sidebar_configs ); ?>
	<div class="row">
		<?php temp_display_sidebar_left( $sidebar_configs ); ?>
		<div id="main-content" class="main-page <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
			<div id="main" class="site-main clearfix" role="main">

				<?php
		
				while ( have_posts() ) : the_post();
					
		
					the_content();

					if ( texter_open() || get_texter_number() ) :
						texter_template();
					endif;

	
				endwhile;
				?>
			</div><!-- .site-main -->
			<?php
    		wp_link_pages( array(
    			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__(  'temp' ) . '</span>',
    			'after'       => '</div>',
    			'link_before' => '<span>',
    			'link_after'  => '</span>',
    			'pagelink'    => '<span class="screen-reader-text">' . esc_html__(  'temp' ) . ' </span>%',
    			'separator'   => '',
    		) );
    		?>
		</div><!-- .content-area -->
		<?php temp_display_sidebar_right( $sidebar_configs ); ?>
	</div>
</section>
<?php get_footer(); ?>