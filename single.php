<?php

get_header();

$sidebar_configs = temp_get_text_layout_configs();
temp_render_breadcrumbs();
?>
<section id="main-container" class="main-content <?php echo apply_filters( 'temp_text_content_class', 'container' ); ?> inner">
	<?php temp_before_content( $sidebar_configs ); ?>
	<div class="row">
		<?php temp_display_sidebar_left( $sidebar_configs ); ?>

		<div id="main-content" class="col-xs-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
			<div id="primary" class="content-area">
				<div id="content" class="site-content detail-post" role="main">
					<?php
		
						while ( have_posts() ) : the_post();

				
							get_template_part( 'template-posts/single/inner' );
							
						
							if ( temp_get_config('show_text_releated', false) ): ?>
								<?php get_template_part( 'template-parts/pos' ); ?>
			                <?php

			                endif;
			     
							if ( texter_open() || get_texter_number() ) :
								texter_template();
							endif;
		
						endwhile;
					?>
				</div><!-- #content -->
			</div><!-- #primary -->
		</div>	
		
		<?php temp_display_sidebar_right( $sidebar_configs ); ?>
		
	</div>	
</section>
<?php get_footer(); ?>