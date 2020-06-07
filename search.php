<?php

get_header();
$sidebar_configs = temp_get_text_layout_configs();

$columns = temp_get_config('text_columns', 1);
$bscol = floor( 12 / $columns );
$_count  = 0;

temp_render_breadcrumbs();
?>
<section id="main-container" class="main-content  <?php echo apply_filters('temp_text_content_class', 'container');?> inner">
		
	<a href="javascript:void(0)" class="sanar-sidebar-btn btn-theme hidden-lg hidden-md right"><i class="fa fa-sliders"></i></a>
	<div class="sanar-sidebar-panel-overlay"></div>
	<div class="row">
		<div id="main-content" class="col-xs-12 <?php echo esc_attr( is_active_sidebar( 'sidebar-default' ) ? 'col-lg-8 col-md-8' : 'col-lg-12 col-md-12'); ?>">
			<main id="main" class="site-main layout-text" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header hidden">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php
		
				while ( have_posts() ) : the_post();

	
					?>
						<?php get_template_part( 'content', 'search' ); ?>
					<?php
					$_count++;

				endwhile;

	
				temp_paging_nav();

			else :
				get_template_part( 'template-posts/content', 'none' );

			endif;
			?>

			</main><!-- .site-main -->
		</div><!-- .content-area -->
		<?php if ( is_active_sidebar( 'sidebar-default' ) ): ?>
			<div class="col-md-4 col-lg-4 col-xs-12 ">
				<div class="sidebar sidebar-right">
			   		<?php dynamic_sidebar('sidebar-default'); ?>
	           	</div>
	        </div>
        <?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>