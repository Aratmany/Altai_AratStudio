<?php


get_header();
?>
	<div id="primary" class="content-area content-index">
		<main id="main" class="site-main" role="main">
			<div class="container">
			<div class="container-inner main-content">
				<div class="row"> 
	          
	                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
	                        <?php  if ( have_posts() ) : 
	                        	while ( have_posts() ) : the_post();
									?>
									
									<?php
				
								endwhile;
								temp_paging_nav();
								?>
	                        <?php else : ?>
	                            <?php get_template_part( 'template-posts/content', 'none' ); ?>
	                        <?php endif; ?>
	                </div>
	                <div class="col-sm-3 col-xs-12 sidebar">
	                	<?php if ( is_active_sidebar( 'sidebar-default' ) ): ?>
				   			<?php dynamic_sidebar('sidebar-default'); ?>
				   		<?php endif; ?>
	                   	
	                </div>
	            </div>
            </div>
            </div>
		</main><!-- .site-main -->
	</div><!-- .content-area -->
<?php get_footer(); ?>